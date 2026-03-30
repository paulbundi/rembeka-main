<?php

namespace App\Cart;

use App\Models\Product;
use Carbon\Carbon;
use JsonSerializable;

class CartItem implements JsonSerializable
{
    public $id;
    public $qty;
    public $product;
    public $options;
    public $appointmentDate;
    public $appointmentTime;
    public $appointmentType;
    public $provider;
    public $type;
    public $providerDetails;

    public function __construct($item)
    {
        $this->id = $item->id;
        $this->qty = $item->quantity;
        $this->product = $item->attributes['product'];
        $this->appointmentDate = $item->attributes['appointmentDate'] ?? null;
        $this->appointmentTime = $item->attributes['appointmentTime'] ?? null;
        $this->appointmentType = $item->attributes['appointmentType'] ?? null;
        $this->provider = $item->attributes['provider'];
        $this->providerDetails = $item->attributes['providerDetails'] ?? null;
        $this->type = $item->attributes['type'];
    }

    public function unitPrice()
    {
        if ($this->product && $this->type == PRODUCT::TYPE_PRODUCT) {
            if (is_array($this->product)) {
                return $this->product['product']['discount'] ?
                    $this->product['product']['discount']['amount'] :
                    $this->product['amount'];
            }

            return $this->product->product->discount ?
                $this->product->product->discount->amount :
                $this->product->amount;
        }

        if ($this->product && $this->type == PRODUCT::TYPE_SERVICE) {
            if (is_array($this->product)) {
                return $this->product['discount'] ?
                    $this->product['discount']['product_price'] :
                    $this->product['final_price'];
            }

            return $this->product->discount ?
                $this->product->discount->product_price :
                $this->product->final_price;
        }

        return $this->product->amount;
    }

    public function total()
    {
        return $this->unitPrice() * $this->qty;
    }

    public function optionsPrice()
    {
        return $this->calculateOptionsPrice();
    }

    public function calculateOptionsPrice()
    {
        if (!$this->options) {
            return $this->product->amount;
        }

        return $this->options->sum(
            function ($option) {
                return $this->valuesSum($option->values);
            }
        );
    }

    private function valuesSum($values)
    {
        return $values->sum(
            function ($value) {
                if ($value->price_type === 'fixed') {
                    return $value->price->amount();
                }

                return ($value->price / 100) * $this->product->selling_price->amount();
            }
        );
    }

    public function refreshStock()
    {
        $product = Product::select(['manage_stock', 'in_stock', 'qty'])->find($this->product->id);

        $this->product->fill(
            [
                'manage_stock' => $product->manage_stock,
                'in_stock' => $product->in_stock,
                'qty' => $product->qty,
            ]
        );

        return $this;
    }

    public function findTax(array $addresses)
    {
        return $this->product->taxClass->findTaxRate($addresses);
    }

    public function jsonSerialize()
    {
        $payload = [
            'id' => $this->id,
            'qty' => $this->qty,
            'unitPrice' => $this->unitPrice(),
            'appointmentDate' => $this->appointmentDate,
            'appointmentTime' => $this->appointmentTime,
            'appointmentType' => $this->appointmentType,
            'type' => $this->type,
            'providerId' => $this->provider,
            'providerDetails' => $this->providerDetails,
            'fullAppointmentDate' => Carbon::parse($this->appointmentDate)->isoFormat('Do MMMM YYYY, h:mm a'),
            'total' => $this->total(),
        ];

        if ($this->type == PRODUCT::TYPE_SERVICE) {
            $payload = array_merge($payload, [
                'product' => Product::where(
                    'id',
                    is_array($this->product) ? $this->product['id'] : $this->product->id
                )->with(['attachments.media'])->first()->clean(),
            ]);
        }

        if ($this->type == PRODUCT::TYPE_PRODUCT) {
            $payload = array_merge($payload, [
                'product' => Product::where(
                    'id',
                    is_array($this->product) ? $this->product['product_id'] : $this->product->product_id
                )->with(['attachments.media'])->first()->clean(),
            ]);
        }

        return $payload;
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }
}
