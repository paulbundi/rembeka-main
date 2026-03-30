<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use App\Models\ProviderPricing;
use App\Models\User;
use App\Models\WalletAudit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderItemController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return OrderItem::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()->whereHas('order');
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'order', 'order.customer', 'items.provider', 'items.product', 'items.category', 'items', 'provider',
            'product',
        ];
    }

    /**
     * handle preUpdate action
     *
     * @param Request $request
     * @param int     $modelId
     *
     * @return void
     */
    public function preUpdate(Request $request, $modelId)
    {
        /**
         * Disable updating item quantity.
         */
        
        // if ($this->model->isDirty('quantity')) {

        //     $providerPricing = ProviderPricing::where('product_id', $this->model->product_id)
        //         ->where('product_id', $this->model->product_id)
        //         ->where('provider_id', $this->model->provider_id)
        //         ->first();

        //     $this->model->amount = $this->model->quantity * $providerPricing->cost_of_labour;
        // }
    }

    /**
     * @param Request $request
     * @param int     $modelId
     *
     * @return void
     */
    public function postUpdate(Request $request, $modelId)
    {
        updateOrderPricing($this->model->order_id);
    }

    /**
     * @param int $orderId
     *
     * @return void
     */
    public function makeProviderPayment($orderId)
    {
        $orderItem = OrderItem::where('id', $orderId)
            ->whereNull('provider_paid')
            ->with(['order', 'product'])
            ->first();

        if ($orderItem && $orderItem->order->balance > 0) {
            return response()->json(['errors' => ['message' => ['Order Not fully paid for!']]], 422);
        }

        $provider = null;
        if ($orderItem && $orderItem->type == OrderItem::TYPE_SERVICE) {
            /**
             *TODO:: CHANGE BELOW / DEPRECATE.
             * This was based on salons using the platform directly, but since we have realised the platform is
             * becoming super big and downloading all those asserts to users is no-longer viable.
             * Then this design of stylist belonging to an organization should be DEPRECATED.
             */

            /**
             * TODO:: this is the second time am passing here, the organisation_id should be changed to provider_id
             *  There is too much dependency created against this column including provider payment etc.
             * NB changing is dangerous
             */
            $provider = User::where('organization_id', $orderItem->provider_id)->first();
        }

        if ($orderItem && $orderItem->type == OrderItem::TYPE_PRODUCT) {
            $orderItem->load('supplier.user');
            $provider = $orderItem->supplier->user;
            if (!$provider) {
                return response()->json(['errors' => ['message' => ['Supplier has no wallet!!!']]], 422);
            }
        }

        $runningBalance =  $provider->wallet;
        $payable = $orderItem->provider_amount;
        $provider->wallet = $provider->wallet + $payable;
        $provider->save();

        $orderItem->provider_paid = OrderItem::PROVIDER_PAID;
        $orderItem->save();

        if ($orderItem->type == OrderItem::TYPE_SERVICE) {
            $description = 'Ksh '.$payable. ' for service delivery for order number'. $orderItem->order->order_no. ' on '.$orderItem->product->name.' Credited to the wallet';
        } else {
            $description = 'Ksh '.$payable. ' for Product sold for order number'. $orderItem->order->order_no. ' on '.$orderItem->product->name.' Credited to the wallet';
        }

        makeAudit( $provider->id, 'App\Models\User',$description,WalletAudit::CREDIT,auth()->id(),$payable,$runningBalance);

        if($orderItem->assisting_provider_id != null) {
            $provider = User::where('organization_id', $orderItem->assisting_provider_id)->first();
            $runningBalance =  $provider->wallet;
            $payable = $orderItem->provider_amount;
            $provider->wallet = $provider->wallet + $payable;
            $provider->save();

            $description = 'Ksh '.$payable. ' for service delivery for order number'. $orderItem->order->order_no. ' on '.$orderItem->product->name.' Credited to the wallet';
            makeAudit( $provider->id, 'App\Models\User', $description,WalletAudit::CREDIT,auth()->id(), $payable, $runningBalance);

        }

        return response()->json();
    }
}
