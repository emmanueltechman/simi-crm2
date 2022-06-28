<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-size: 10pt;
            line-height: 11pt;
            font-family: '{{config('pdf.default_font')}}';
        }

        .product th,
        table .product {
            border-top: 1px solid #2B2B2B;
            border-collapse: collapse;
            font-size: 10pt;
            font-weight: 600;
        }

        .sum_table th, table .sum_table {
            border-collapse: collapse;
            font-size: 10pt;
        }

        .sum_table td, .sum_table tr {
            border-collapse: collapse;
            font-size: 10pt;
            padding-top: 5pt;
        }

        .product td, .product tr {
            border-top: 1px solid #8c8c8c;
            border-collapse: collapse;
            font-size: 10pt;
            padding-top: 5pt;
        }

        td.description,
        th.description {
            width: 33mm;
            max-width: 57mm;
        }

        td.quantity,
        th.quantity {
            width: 12mm;
            max-width: 12mm;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 12mm;
            max-width: 12mm;
            word-break: break-all;
        }

        td.summary {
            width: 28mm;
            max-width: 28mm;
            word-break: break-all;

        }

        .text_right {
            text-align: right;
        }


        .align_center {
            text-align: center;
            align-content: center;
        }

        .receipt {
            width: 57mm;
            max-width: 57mm;
        }

        img {
            max-width: inherit;
            width: inherit;
            max-height: 20mm;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color
        }

    </style>
    <title>{{$general['lang_bill_number']}}</title>
</head>
<body dir="{{$general['direction']}}">
<div class="receipt">
    <div class="align_center"><img
                src="{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}">
    </div>
    <p class="align_center">{{$company['cname']}}<small>
            <br>{{$company['address']}}, {{$company['city']}}
            <br>{{trans('pos.ph')}}{{$company['phone']}} </small>
    </p>
    <p><small>
            {{$general['lang_bill_number']}} :{{prefix($general['prefix'],$invoice['ins'])}} # {{$invoice['tid']}}
            <br>{{$general['person']}} : {{$invoice->customer->name}}
        </small></p>
    <table class="product">
        <thead>
        <tr>
            <th class="description">{{trans('products.product_des')}}</th>
            <th class="quantity">{{trans('products.qty')}}</th>
            <th class="price">{{trans('general.amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @php
            $height =130;
           foreach ($invoice->products as $row) {
            $height +=8;
            $length=strlen($row['product_name']);
            $rows=(integer)($length/10);
            $height +=2*$rows;
               echo '<tr>
               <td >' . $row['product_name'].' </td>
                <td>' . +$row['product_qty'] . ' ' . $row['unit'] . '</td>
               <td>' . numberFormat($row['product_subtotal'], $invoice['currency']) . '</td>
           </tr>';
           }

        @endphp

        </tbody>
    </table>
    <hr>
    <table class="sum_table">
        <tbody>
        <tr>
            <td class="summary text_right">{{trans('general.tax')}} :</td>
            <td class="summary">{{amountFormat($invoice['tax'], $invoice['currency'])}}</td>
        </tr>
        <tr>
            <td class="summary text_right">{{trans('general.discount')}} :</td>
            <td class="summary">{{amountFormat($invoice['discount'], $invoice['currency'])}}</td>
        </tr>
        <tr>
            <td class="summary text_right">{{trans('general.grand_total')}} :</td>
            <td class="summary">{{amountFormat($invoice['total'], $invoice['currency'])}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p class="align_center"><small>{{trans('invoices.short_thank_you_note')}}</small></p>
    @if(isset($image))

        @php
            $height +=40;
        @endphp
        <div class="align_center">
            <small>{{trans('invoices.scan_pay')}}</small><br>
            <img style="max-height:170px;" src='{{$image}}' alt='QR'>
        </div>
    @else
        <div class="stamp"> {{trans('payments.'.$invoice['status'])}}</div>
    @endif
    @php
        session(['height' =>$height]);
    @endphp
</div>
</body>
</html>
