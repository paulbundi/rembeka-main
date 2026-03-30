<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Order Payment</title>

    <style>

        body {
            font-size: 14px;
            color: black
        }

        .header {
            height: 80px;
        }

        .logo {
            width: 250px;
            max-width: 50%;
            height: 80px;
            float: left;
        }

        .issuing {
            float: left;
            width: 33%;
        }

        .payment {
            float: left;
            width: 50%;
        }

        .receiving {
            float: left;
            width: 33%;
        }

        .requested {
            float: right;
            width: 33%;
        }

        .info {
            margin-top: 5px;
        }

        .totals {
            float: right;
        }

        .page_break {
            page-break-before: always;
        }

        .no_page_break {
            page-break-before: avoid;
        }

        hr {
            color: gray;
            border-bottom: .2px solid grey;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            padding: 8px;
        }
        
        tr:nth-child(even){
            background-color: #f2f2f2;
            color: #000;
        }
        
        th {
            background-color: #c2425d;
            color: white;
        }
    </style>
</head>
<div class="header">
    <div class="logo">
        <img src="{{public_path().'/img/logo-large.png'}}" alt="logo" height="100%" width="100%">
    </div>
</div>
<hr/>
<h5 align="center">Order Payment </h5>
<div class="about">
    <div class="issuing">
        <div class="vendor"><strong>Particulars</strong></div>
        <div class="address">
            {{ $order['customer']->first_name}} {{ $order['customer']->last_name}}<br>
            {{ $order['created_at'] }} <br>
        </div>
    </div>
    <div class="issuing">
        <div class="vendor"><strong>Order ID</strong></div>
        <div class="address">
            #order No. <b>{{$order->order_no}}</b>
        </div>
    </div>
    <div class="issuing">
        <div class="vendor"><strong>Receipt From</strong></div>
        <div class="address">
            <p>
                REMBEKA<br>
                Phone: {{ config('services.whatsapp.rembeka_whatsapp_no') }}<br>
                Email: {{ env('MAIL_FROM_ADDRESS') }}<br>
            </p>
        </div>
    </div>
</div>

<div class="info">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
<hr/>
<h5>Order summary</h5>


Order balance: <b>{{ number_format($order->balance, 2) }}</b>
    @php
        $discount = 0;
    @endphp
<h6>Products</h6>
<table>
    <thead>
        <th width="60%">Product</th>
        <th>Qty</th>
        <th style="text-align:right;">Price</th>
        <th style="text-align:right;">Total</th>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            @if($item->discounted)
                @php($discount += $item->discount_amount)
            @endif
            <tr>
                <td>
                    {{ $item->product->name }}<br/>
                    @if($item->product->type == \App\Models\Product::TYPE_SERVICE)
                        <small>{{ $item->appointment_date}}</small>
                        <small>{{ $item->appointment_time}}</small>
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                <td style="text-align:right;">{{ number_format($item->amount / $item->quantity, 2) }}</td>
                <td style="text-align:right;">{{ number_format($item->amount,2) }}</td>
            </tr>
        @endforeach
        <tr style="border:1px solid #000 solid"></tr>
        @if($discount > 0 || $order->referral_discount > 0)
        <tr>
            <td colspan="3" style="text-align:right;"> 
                <b>Discount</b>
            </td>
            <td style="text-align:right;">{{ number_format($discount + $order->referral_discount , 2) }}</td>
        </tr>
        @endif
            <tr>
                <td colspan="3" style="text-align:right;"> 
                    <b>VAT</b>
                </td>
                <td style="text-align:right;">16%</td>
            </tr>

            @if($order->delivery_amount)
            <tr>
                <td colspan="3" style="text-align:right;"> 
                    <b>Delivery Fee</b>
                </td>
                <td style="text-align:right;">{{number_format($order->delivery_amount ?? 0,2)}}</td>
            </tr>
            @endif

            @if($order->transport_cost)
                <tr>
                    <td colspan="3" style="text-align:right;"> 
                        <b>Transport Cost</b>
                    </td>
                    <td style="text-align:right;">{{ $order->transport_cost }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="3" style="text-align:right;"> 
                    <b>Paid Amount</b>
                </td>
                <td style="text-align:right;">{{ number_format($order->paid, 2) }}</td>
            </tr>

            <tr>
                <td colspan="3" style="text-align:right;"> 
                    <b style="font-size:18px">Total</b>
                </td>
                <td style="text-align:right;"><b style="font-size:18px">{{ number_format($order->amount , 2) }}</b></td>
            </tr>
        </tbody>
    </table>
<div class="info">
    <p>&nbsp;</p>
</div>

<div style="border-bottom: 1px solid rgba(0, 0, 0, 0.2)"> </div>


<div class="about" style="position: relative; width: 100%;">
    <div class="payment">
        <p>NB: All payments to rembeka are made via paybill number : <b>{{ config('services.paybill_no')}} </b> and the order number  <b>{{$order->order_no}}</b> as the account</p>
    </div>
</div>

</body>
</html>