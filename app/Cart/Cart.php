<?php

namespace App\Cart;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductPricing;
use App\Models\Provider;
use Darryldecode\Cart\Cart as DarryldecodeCart;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use JsonSerializable;

class Cart extends DarryldecodeCart implements JsonSerializable
{
    /**
     * Get the current instance.
     *
     * @return $this
     */
    public function instance()
    {
        return  app(Cart::class);
    }

    /**
     * Clear the cart.
     *
     * @return void
     */
    public function clear()
    {
        parent::clear();

        $this->clearCartConditions();
    }

    /**
     * Store a new item to the cart.
     *
     * @param int   $productId
     * @param int   $qty
     * @param int   $isExpress
     * @param array $options
     *
     * @return void
     */
    public function store($data)
    {
        if ($data['type'] == Product::TYPE_PRODUCT) {
            $this->handleProduct($data);
        } else {
            $this->handleService($data);
        }
    }

    /**
     * Add product to cart
     *
     * @param array $data
     *
     * @return void
     */
    public function handleProduct(array $data)
    {
        $productPricing = ProductPricing::where('id', $data['pricing_id'])
            ->with(['product.discount'])
            ->firstOrFail();

        $this->add([
            'id' => md5("supplier_id.{$productPricing->id}"),
            'name' => $productPricing->product->name,
            'price' => $productPricing->amount,
            'quantity' => $data['quantity'],
            'attributes' => [
                'type' => $data['type'],
                'product' => $productPricing,
                'provider' => $productPricing['supplier_id'],
                'color' => $data['color'] ?? null,
            ],
            'conditions' => [],
            'associatedModel' => null,
        ]);
    }

    /**
     * Add service to cart
     *
     * @param array $data
     *
     * @return void
     */
    public function handleService(array $data)
    {
        $product = Product::with(['discount'])
            ->findOrFail($data['product_id']);

        $stylist =  null;
        if (isset($data['provider_id'])) {
            $stylist = Provider::where('id', $data['provider_id'])->first();
        }

        $this->add([
            'id' => md5("provider_item_id.{$product->id}"),
            'name' => $product->name,
            'price' => $product->final_price,
            'quantity' => $data['quantity'],
            'attributes' => [
                'type' => $data['type'],
                'product' => $product,
                'provider' => $data['provider_id'],
                'appointmentType' => $product->category_id,
                'providerDetails' => $stylist->name,
                'created_at' => time(),
                'appointmentDate' => $data['date']?? '',
                'appointmentTime' => $data['time'] ?? '',
            ],
            'conditions' => [],
            'associatedModel' => null,
        ]);
    }

    public function updateQuantity($id, $qty)
    {
        $this->update(
            $id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $qty,
                ],
            ]
        );
    }

    public function items()
    {
        return $this->getContent()->sortBy('attributes.created_at')->map(
            function ($item) {
                return new CartItem($item);
            }
        );
    }

    public function addedQty($productId)
    {
        return $this->findByProductId($productId)->sum('qty');
    }

    public function findByProductId($productId)
    {
        return $this->items()->filter(
            function ($cartItem) use ($productId) {
                return $cartItem->product->id == $productId;
            }
        );
    }

    public function crossSellProducts()
    {
        return $this->getAllProducts()->load(
            ['crossSellProducts' => function ($query) {
                $query->forCard();
            }]
        )->pluck('crossSellProducts')->flatten();
    }

    public function getAllProducts()
    {
        return $this->items()->map(
            function ($cartItem) {
                return $cartItem->product;
            }
        )->flatten()->pipe(
            function ($products) {
                return new EloquentCollection($products);
            }
        );
    }

    public function reduceStock()
    {
        $this->manageStock(
            function ($cartItem) {
                $cartItem->product->decrement('qty', $cartItem->qty);

                if ($cartItem->refreshStock()->product->qty === 0) {
                    $cartItem->product->outOfStock();
                }
            }
        );
    }

    public function restoreStock()
    {
        $this->manageStock(
            function ($cartItem) {
                $cartItem->product->increment('qty', $cartItem->qty);
            }
        );
    }

    private function manageStock($callback)
    {
        $this->items()->filter(
            function ($cartItem) {
                return $cartItem->product->manage_stock;
            }
        )->each($callback);
    }

    public function quantity()
    {
        return $this->getTotalQuantity();
    }

    public function paymentMethod()
    {
        return 0;
    }

    public function paymentCost()
    {
        return 0;
    }

    public function hasCoupon()
    {
        if ($this->getConditionsByType('coupon')->isEmpty()) {
            return false;
        }

        $couponId = $this->getConditionsByType('coupon')->first()->getAttribute('coupon_id');

        return Coupon::where('id', $couponId)->exists();
    }

    public function discount()
    {
        return 0;//$this->coupon()->value();
    }

    public function coupon()
    {
        return  null;
    }

    public function applyCoupon(Coupon $coupon)
    {
        $this->removeCoupon();

        $this->condition(
            new CartCondition(
                [
                    'name' => $coupon->code,
                    'type' => 'coupon',
                    'target' => 'total',
                    'value' => $this->getCouponValue($coupon),
                    'order' => 2,
                    'attributes' => [
                        'coupon_id' => $coupon->id,
                    ],
                ]
            )
        );
    }

    private function getCouponValue($coupon)
    {
        if ($coupon->is_percent) {
            return "-{$coupon->value}%";
        }

        return "-{$coupon->value->amount()}";
    }

    public function removeCoupon()
    {
        $this->removeConditionsByType('coupon');
    }

    public function hasTax()
    {
        return $this->getConditionsByType('tax')->isNotEmpty();
    }

    public function taxes()
    {
        return new Collection;
    }

    private function getTaxRateIds($taxConditions)
    {
        return $taxConditions->map(
            function ($taxCondition) {
                return $taxCondition->getAttribute('tax_rate_id');
            }
        );
    }

    public function tax()
    {
        return $this->calculateTax();
    }

    private function calculateTax()
    {
        return $this->taxes()->sum(
            function ($cartTax) {
                return $cartTax->amount()->amount();
            }
        );
    }

    public function addTaxes($request)
    {
        $this->removeTaxes();

        $this->findTaxes($request)->each(
            function ($taxRate) {
                $this->condition(
                    new CartCondition(
                        [
                            'name' => $taxRate->id,
                            'type' => 'tax',
                            'target' => 'total',
                            'value' => "+{$taxRate->rate}%",
                            'order' => 3,
                            'attributes' => [
                                'tax_rate_id' => $taxRate->id,
                            ],
                        ]
                    )
                );
            }
        );
    }

    public function removeTaxes()
    {
        $this->removeConditionsByType('tax');
    }

    private function findTaxes($request)
    {
        return $this->items()
            ->groupBy('tax_class_id')
            ->flatten()
            ->map(
                function (CartItem $cartItem) use ($request) {
                    return $cartItem->findTax($request->only(['billing', 'shipping']));
                }
            )
            ->filter();
    }

    public function subTotal()
    {
        $subtotal = $this->getSubTotal();

        return $subtotal;
    }

    /**
     * Override
     * get cart sub total.
     *
     * @param bool $formatted
     *
     * @return float
     */
    public function getSubTotal($formatted = true)
    {
        $cartItems = $this->items();
        $newTotal = 0;

        foreach ($cartItems as $item) {
            $newTotal += $item->total();
        }

        return $newTotal;
    }

    private function optionsPrice()
    {
        return $this->calculateOptionsPrice();
    }

    private function calculateOptionsPrice()
    {
        return $this->items()->sum(
            function ($cartItem) {
                return $cartItem->optionsPrice() * $cartItem->qty;
            }
        );
    }

    public function total()
    {
        return $this->subTotal();
        // ->subtract($this->coupon()->value())
            // ->add($this->paymentMethod()->cost())
            // ->add($this->tax())
            // ->add($this->transportFee());
    }

    public function transportFee()
    {
        return 0;
    }

    public function toArray()
    {
        return [
            'items' => $this->items(),
            'quantity' => $this->quantity(),
            'subTotal' => $this->subTotal(),
            'paymentCost' => $this->paymentMethod(),
            'coupon' => $this->coupon(),
            'taxes' => $this->taxes(),
            'transportFee' => $this->transportFee(),
            'total' => $this->total(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
