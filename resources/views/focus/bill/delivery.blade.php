<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print DO #{{$invoice['tid']}}</title>
    <style>
        body {
            color: #2B2000;
            font-family: '{{config('pdf.default_font')}}';
            font-size: 11pt;
        }

        @page {
            margin: 3mm;
        }

        .invoice-box {
            width: 210mm;
            padding: 0mm;
            border: 0;
            font-size: 11pt;
            line-height: 12pt;
            color: #000;
        }

        .party {
            border: #ccc 1px solid;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
        }

        .company {
            width: 300pt;
        }

        .customer {
            width: 290pt;
        }

        .bill_info {
            font-size: 10pt;
        }

        .heading {
            width: 900pt;
        }

        .m_fill {
            background-color: #eee;
        }

        .product_list td {
            padding: 4px;
        }

        .product_row td {
            border: 1px solid #ddd;
        }

        .summary td {
            padding-left: 8pt;
            padding-right: 8pt;
            margin: 2px;
            border: 1px solid #ccc;


        }

        .sign {
            text-align: center;
            margin-bottom: 4pt
        }

        .logo_box {
            width: 70%;
            align: left;
        }

        .date_box {
            width: 30%;
            align: right;
        }

        .text_center {
            text-align: center;
        }

        .text_right {
            text-align: right;
        }


    </style>
</head>

<body direction="{{$general['direction']}}">
<div class="information">
    <table width="100%">
        <tr>
            <td class="logo_box">
                <img src="{{ Storage::disk('public')->url('app/public/img/company/' . config('core.logo')) }}"
                     class="top_logo" width="200">
            </td>

            <td class="date_box">
                <table class="bill_info">
                    <tr>
                        <td colspan="1" class="text_right"><h4>{{$general['bill_type']}}</h4></td>
                    </tr>
                    <tr>

                        <td>{{$general['lang_bill_number']}}:</td>
                        <td>DO#<?php echo $invoice['tid'] ?></td>
                    </tr>
                    <tr>
                        <td>{{trans('invoices.tid')}}</td>
                        <td> {{prefix(1,$invoice['ins'])}} # {{$invoice['tid']}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('invoices.delivery_date')}}</td>
                        <td><?php echo dateFormat(date('Y-m-d')) ?></td>
                    </tr>
                    @if($invoice['refer'])
                        <tr>
                            <td>{{trans('general.reference')}}</td>
                            <td>: {{$invoice['refer']}}</td>
                        </tr>
                    @endif
                </table>


            </td>
        </tr>
    </table>
</div>
<br>
<div class="invoice-box">

    <table class="party">
        <thead>
        <tr class="heading">
            <td>{{trans('general.our_info')}}:</td>

            <td>{{$general['person']}}:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="company"><strong>{{(config('core.cname'))}}</strong><br>
                {{(config('core.address'))}},<br>
                {{(config('core.city'))}}, {{(config('core.region'))}}<br>
                {{(config('core.cname'))}} - {{(config('core.postbox'))}}<br>
                {{trans('general.phone')}}{{(config('core.cname'))}}: {{(config('core.phone'))}}<br>
                {{trans('general.email')}}{{(config('core.email'))}}: {{(config('core.email'))}}<br>
                @if(config('core.taxid'))
                    {{trans('general.tax_id')}}: {{config('core.taxid')}}
                @endif

            </td>

            <td class="customer">
                {{$invoice->customer->name}}<br>
                {{$invoice->customer->address}}, {{$invoice->customer->city}}<br>
                {{$invoice->customer->region}}, {{$invoice->customer->country}} - {{$invoice->customer->postbox}}<br>
                {{trans('general.phone')}} : {{$invoice->customer->phone}}<br>
                {{trans('general.email')}} : {{$invoice->customer->email}}<br>
                @if($invoice->customer->taxid) {{trans('general.tax_id')}}: {{$invoice->customer->taxid}}<br>
                @endif
            </td>
        </tr>@if ($invoice->customer->name_s)

            <tr>

                <td><br><strong>{{trans('customers.address_s')}}</strong><br> {{$invoice->customer->name_s}}<br>
                    {{$invoice->customer->address_s}}, {{$invoice->customer->city_s}}<br>
                    {{$invoice->customer->region_s}}, {{$invoice->customer->country_s}}
                    - {{$invoice->customer->postbox_s}}<br>
                    {{trans('general.phone')}} : {{$invoice->customer->phone_s}}<br>
                    {{trans('general.email')}} : {{$invoice->customer->email_s}}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    <br>
    @php
        $fill = true;
    @endphp
    <table class="product_list" cellpadding="0" cellspacing="0" width="100%">


        <tr class="heading">
            <td width="1rem;">#</td>
            <td>
                {{trans('products.product_des')}}
            </td>
            <td>
                {{trans('products.qty')}}
            </td>


        </tr>

        @foreach($invoice->products as $product)
            @php
                if ($fill == true) {
                  $flag = ' m_fill';
              } else {
                  $flag = '';
              }
               $fill = !$fill;
            $col_span=2;
            @endphp
            <tr class="product_row {{$flag}}">
                <td style="width: 1rem;">
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{$product['product_name']}}
                </td>
                <td>
                    {{numberFormat($product['product_qty'])}}
                </td>

            </tr>
            @if($product['product_des'])
                <tr class="product_row  {{$flag}}">
                    <td style="width: 1rem;">

                    </td>
                    <td colspan="2">{!!$product['product_des'] !!}</td>

                </tr>
            @endif

        @endforeach

    </table>
    <br> <br>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="width: 300pt;margin: 5pt;  text-align: center;">
                <div class="sign">{{trans('general.authorized_person')}}</div>
                <div class="sign"><img
                            src="{{ Storage::disk('public')->url('app/public/img/signs/' . $invoice->user->signature) }}"
                            width="160"
                            height="50" border="0" alt=""></div>
                <div class="sign">({{$invoice->user->first_name}} {{$invoice->user->last_name}})</div>
            </td>
            <td style="width: 300pt;margin: 5pt;  text-align: center;">
                __________________________<br>{{trans('invoices.received_by')}}</td>
        </tr>
    </table>

    <div class="terms">{{$invoice['notes']}} </div>
    <hr>
    <h6>{{trans('general.payment_terms')}}:</h6>

    <strong>{{@$invoice->term->title}}</strong><br>{!!  @$invoice->term->terms !!}


</div>
</body>
</html>
