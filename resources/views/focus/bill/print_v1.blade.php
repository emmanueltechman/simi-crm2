<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print {{$general['bill_type']}} {{$invoice['tid']}}</title>
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
            width: 60%;
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

        .sign_box {
            display: block;
            margin-left: 400pt;
            width: 100pt;
            align: right;
        }

        .row {
            width: 100%;
        }


    </style>
</head>
<body dir="{{$general['direction']}}">
<div class="information">
    <table width="100%">
        <tr>
            <td class="logo_box">
                <img src="{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}"
                     class="top_logo" height="120">
            </td>

            <td class="date_box">
                <table class="bill_info">
                    <tr>
                        <td colspan="1" class="text_right"><h4>{{$general['bill_type']}}</h4></td>
                    </tr>
                    <tr>
                        <td>{{$general['lang_bill_number']}}</td>
                        <td>: {{prefix($general['prefix'],$invoice['ins'])}} # {{$invoice['tid']}}</td>
                    </tr>
                    <tr>
                        <td>{{$general['lang_bill_date']}}</td>
                        <td>: {{dateFormat($invoice['invoicedate'],$company['main_date_format'])}}</td>
                    </tr>
                    <tr>
                        <td>{{$general['lang_bill_due_date']}}</td>
                        <td>: {{dateFormat($invoice['invoiceduedate'],$company['main_date_format'])}}</td>
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
            <td> {{trans('general.our_info')}}:</td>
            <td>{{$general['person']}}:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="company">
                 <strong>{{$company['cname']}}</strong><br>
                {{$company['address']}},<br>
                {{$company['city']}}, {{$company['region']}}<br>
                {{$company['country']}} - {{$company['postbox']}}<br>
                {{trans('general.phone')}}: {{$company['phone']}}<br>
                {{trans('general.email')}}: {{$company['email']}}<br>
                @if($company['taxid'])
                    {{$general['tax_id']}}: {{$company['taxid']}}
                @endif
                 {!! custom_fields_view(6,$invoice->ins,3,$invoice->ins) !!}
            </td>
            <td class="customer">
               <strong> {{$invoice->customer->name}}</strong><br>   <strong> {{$invoice->customer->company}}</strong><br>
                {{$invoice->customer->address}}, {{$invoice->customer->city}}<br>
                {{$invoice->customer->region}}, {{$invoice->customer->country}} - {{$invoice->customer->postbox}}<br>
                {{trans('general.phone')}} : {{$invoice->customer->phone}}<br>
                {{trans('general.email')}} : {{$invoice->customer->email}}<br>
                @if($invoice->customer->taxid) {{$general['tax_id']}}: {{$invoice->customer->taxid}}<br>
                @endif
                {!! custom_fields_view($invoice['person'],$invoice['person_id'],2,$invoice['ins']) !!}
            </td>
        </tr>@if ($invoice->customer->name_s)
            <tr>
                <td><br><strong>{{trans('customers.address_s')}}</strong><br> {{$invoice->customer->name_s}}<br>
                    {{$invoice->customer->address_s}}, {{$invoice->customer->city_s}}<br>
                    {{$invoice->customer->region_s}}, {{$invoice->customer->country_s}}
                    @if($invoice->customer->postbox_s)- {{$invoice->customer->postbox_s}} @endif<br>
                    {{trans('general.phone')}} : {{$invoice->customer->phone_s}},<br>
                    {{trans('general.email')}} : {{$invoice->customer->email_s}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <br>
    @php
        $fill = true;
    @endphp
    <table class="product_list" cellpadding="0" cellspacing="0" width="100%">

        {{--  exclusive --}}
        @if($invoice['tax_format']=='exclusive' OR $invoice['tax_format']=='inclusive'  OR $invoice['tax_format']=='off')
            <tr class="heading">
                <td style="width: 1rem;">
                    #
                </td>
                <td>
                    {{trans('products.product_des')}}
                </td>
                <td>
                    {{trans('products.qty')}}
                </td>
                <td>
                    {{trans('products.price')}}
                </td>
                @if($invoice['tax']>0)
                    <td>{{trans('general.tax')}}</td>@endif
                @if($invoice['discount']>0)
                    <td>{{trans('general.discount')}}</td>@endif
                <td>
                    {{trans('general.subtotal')}}
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
                $col_span=4;
                @endphp
                <tr class="product_row {{$flag}}">
                    <td style="width: 1rem;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{$product['product_name']}} @if(isset($product['serial'])){{$product['serial']}}@endif
                    </td>
                    <td>
                        {{numberFormat($product['product_qty'],$invoice['currency'])}} {{$product['unit']}}
                    </td>
                    <td>
                        {{amountFormat($product['product_price'],$invoice['currency'])}}
                    </td>
                    @if($invoice['tax']>0)
                        @php $col_span++ @endphp
                        <td>{{amountFormat($product['total_tax'],$invoice['currency'])}}</td> @endif
                    @if($invoice['discount']>0)
                        @php $col_span++ @endphp
                        <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>
                    @endif
                    <td>
                        {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                    </td>
                </tr>
                @if($product['product_des'])
                    <tr class="product_row  {{$flag}}">
                        <td style="width: 1rem;">

                        </td>
                        <td class="" colspan="{{$col_span}}"> {!!$product['product_des'] !!} </td>

                    </tr>
                @endif

            @endforeach
        @endif

        {{--  cgst --}}

        @if($invoice['tax_format']=='cgst')
            <tr class="heading">
                <td style="width: 1rem;">
                    #
                </td>
                <td>
                    {{trans('products.product_des')}}
                </td>
                <td>
                    {{trans('products.qty')}}
                </td>
                <td>
                    {{trans('products.price')}}
                </td>

                <td>{{trans('general.cgst')}}</td>
                <td>{{trans('general.sgst')}}</td>
                @if($invoice['discount']>0)
                    <td>{{trans('general.discount')}}</td>@endif
                <td>
                    {{trans('general.subtotal')}}
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
                $col_span=5;
                @endphp
                <tr class="product_row {{$flag}}">
                    <td style="width: 1rem;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{$product['product_name']}}
                    </td>
                    <td>
                        {{numberFormat($product['product_qty'],$invoice['currency'])}} {{$product['unit']}}
                    </td>
                    <td>
                        {{amountFormat($product['product_price'],$invoice['currency'])}}
                    </td>


                    <td>{{amountFormat($product['total_tax']/2,$invoice['currency'])}} <span class="font-size-xsmall">({{numberFormat($product['product_tax']/2,$invoice['currency'])}}%)</span>
                    </td>
                    <td>{{amountFormat($product['total_tax']/2,$invoice['currency'])}} <span class="font-size-xsmall">({{numberFormat($product['product_tax']/2,$invoice['currency'])}}%)</span>
                    </td>
                    @if($invoice['discount']>0)
                        @php $col_span++ @endphp
                        <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>
                    @endif
                    <td>
                        {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                    </td>
                </tr>
                @if($product['product_des'])
                    <tr class="product_row  {{$flag}}">
                        <td style="width: 1rem;">

                        </td>
                        <td class="" colspan="7">{!!$product['product_des'] !!}</td>

                    </tr>
                @endif

            @endforeach
        @endif

        {{--  igst --}}

        @if($invoice['tax_format']=='igst')
            <tr class="heading">
                <td style="width: 1rem;">
                    #
                </td>
                <td>
                    {{trans('products.product_des')}}
                </td>
                <td>
                    {{trans('products.qty')}}
                </td>
                <td>
                    {{trans('products.price')}}
                </td>

                <td>{{trans('general.igst')}}</td>
                @if($invoice['discount']>0)
                    <td>{{trans('general.discount')}}</td>@endif
                <td>
                    {{trans('general.subtotal')}}
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
                $col_span=5;
                @endphp
                <tr class="product_row {{$flag}}">
                    <td style="width: 1rem;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{$product['product_name']}}
                    </td>
                    <td>
                        {{numberFormat($product['product_qty'],$invoice['currency'])}} {{$product['unit']}}
                    </td>
                    <td>
                        {{amountFormat($product['product_price'],$invoice['currency'])}}
                    </td>


                    <td>{{amountFormat($product['total_tax'],$invoice['currency'])}} <span class="font-size-xsmall">({{numberFormat($product['product_tax'],$invoice['currency'])}}%)</span>
                    </td>
                    @if($invoice['discount']>0)
                        @php $col_span++ @endphp
                        <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>
                    @endif
                    <td>
                        {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                    </td>
                </tr>
                @if($product['product_des'])
                    <tr class="product_row  {{$flag}}">
                        <td style="width: 1rem;">

                        </td>
                        <td class="" colspan="7">{!!$product['product_des'] !!}</td>

                    </tr>
                @endif

            @endforeach
        @endif
    </table>
    <br>

    <table class="summary" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 50%" rowspan="6"><br>
                <p style="font-size: large"><strong>{{trans('general.status')}}
                        : {{trans('payments.'.$invoice['status'])}} {{$invoice['pmethod']}}</strong></p><br>
                @if($general['status_block'])

                    <p>{{trans('general.grand_total')}} : {{amountFormat($invoice['total'],$invoice['currency'])}}</p>


                    <p>{{trans('general.round_off')}}: 0</p><br>
                    <p>{{trans('payments.paid_amount')}}: {{amountFormat($invoice['pamnt'],$invoice['currency'])}}</p>
                @endif
                @if(@$invoice['proposal'])
                    <hr>
                    {{trans('general.proposal')}}: </br></br>
                    <small>{!! $invoice['proposal']  !!}</small>
                @endif
            </td>
            <td class="text_right"><strong> {{trans('general.summary')}}</strong></td>
            <td></td>

        </tr>
        <tr>
            <td class="text_right"> {{trans('general.subtotal')}}</td>
            <td> {{amountFormat($invoice['subtotal'],$invoice['currency'])}}</td>
        </tr>
        @if($invoice['tax']>0)
            <tr>
                <td class="text_right">{{$general['tax_string_total']}} @if($invoice['tax_format']=='cgst')
                   <br> <small>CGST<br>SGST</small>
                 @endif</td>
                <td> {{amountFormat($invoice['tax'],$invoice['currency'])}}
 @if($invoice['tax_format']=='cgst')
                 <br>  </small>  {{amountFormat($invoice['tax']/2,$invoice['currency'])}}<br>{{amountFormat($invoice['tax']/2,$invoice['currency'])}}</small>
                 @endif
                </td>
            </tr>
         @endif
         @if($invoice['tax_format']=='cgst')
            <tr>
                <td class="text_right">{{$general['tax_string_total']}}</td>
                <td> {{amountFormat($invoice['tax'],$invoice['currency'])}}</td>
            </tr>
         @endif
         @if($invoice['discount']>0)<tr>
                    <td class="text_right"> {{trans('general.discount')}}</td>
                    <td> {{amountFormat($invoice['discount'],$invoice['currency'])}}</td>
            </tr>
        @endif
        @if($invoice['shipping']>0)
            <tr>
                <td class="text_right"> {{trans('general.shipping')}}</td>
                <td> {{amountFormat($invoice['shipping'],$invoice['currency'])}}</td>
            </tr>
        @endif

        @if((($invoice['total']-$invoice['pamnt'])>0) AND ($general['status_block']))
            <tr>
                <td class="text_right"> {{trans('general.balance_due')}}</td>
                <td> {{amountFormat($invoice['total']-$invoice['pamnt'],$invoice['currency'])}}</td>
            </tr>
        @else
            <tr>
                <td class="text_right"> {{trans('general.grand_total')}}</td>
                <td> {{amountFormat($invoice['total'],$invoice['currency'])}}</td>
            </tr>
        @endif
    </table>
    <br>
    <div class="sign_box">
        <div class="sign">{{trans('general.authorized_person')}}</div>
        <div class="sign"><img
                    src="{{Storage::disk('public')->url('app/public/img/signs/' . $invoice->user->signature)}}"
                    width="160"
                    height="50" border="0" alt=""></div>
        <div class="sign">({{$invoice->user->first_name}} {{$invoice->user->last_name}})</div>
    </div>
    {!! custom_fields_view($invoice['custom'],$invoice['id'],2,true) !!}
    <div class="terms">{{$invoice['notes']}}
        <hr>
        <h6>{{@$invoice->term->title}}:</h6>
        {!!@$invoice->term->terms  !!}
    </div>
</div>


</body>
</html>
