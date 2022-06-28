@extends ('core.layouts.public_app')
@section ('title', $general['bill_type'] . ' | ' . $company['cname'])
@section ('icon',  $company['icon'])
@section('content')
    <div class="content-body">
        <div class="card">
            <div class="card-content">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>


                <div id="invoice-template" class="card-body">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col">
                            @php
                                $remaining = $invoice['total'] - $invoice['pamnt'];
                            @endphp
                            @if($invoice['status'] != 'canceled')
                                <div class="row">


                                    <div class="col-md-8">
                                        <div class="form-group mt-2">
                                            @if($general['status_block'])

                                                {{trans('payments.payment')}}:

                                                @if($online_payment)
                                                    <a class="btn btn-success text-white btn-min-width mr-1"
                                                       data-toggle="modal" data-target="#paymentCard"><i
                                                                class="fa fa-cc"></i> {{trans('payments.credit_card')}}
                                                    </a>
                                                @endif

                                                <a class="btn btn-secondary btn-min-width mr-1"
                                                   href="{{$link['bank']}}" role="button"><i
                                                            class="fa fa-bank"></i> {{trans('payments.bank')}}
                                                    - {{trans('payments.cash')}}</a>
                                            @endif
                                            @if ($logged_in_user)
                                                <a class="btn btn-warning  mr-1"
                                                   href="{{$invoice['url']}}"
                                                   role="button"><i
                                                            class="fa fa-backward"></i> </a>

                                            @endif

                                        </div>
                                    </div>


                                    <div class="col-md-4 text-right">
                                        <div class="btn-group mt-2">
                                            <button type="button" class="btn btn-primary btn-min-width dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                        class="fa fa-print"></i> {{trans('general.print')}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="{{$link['link']}}">{{trans('general.print')}}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{$link['download']}}">{{trans('general.pdf')}}</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="title-action ">


                                </div>
                            @else
                                <h2 class="btn btn-oval btn-danger">{{trans('payments.'.$invoice['status'])}}</h2>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                            <p class="text-muted">{{trans('general.our_info')}}</p>


                            <ul class="px-0 list-unstyled">
                                <li> {{$company['cname']}}</li>
                                <li>
                                    {{$company['address']}},
                                </li>
                                <li>
                                    {{$company['city']}}, {{$company['region']}},</li>
                                <li>
                                    {{$company['country']}}, @if($company['postbox']) - {{$company['postbox']}} @endif</li>
                                <li>
                                    {{trans('general.phone')}}: {{$company['phone']}}</li>
                                <li>
                                    {{trans('general.email')}}: {{$company['email']}}</li>
                                @if($company['taxid'])
                                    <li>{{$general['tax_id']}}: {{$company['taxid']}}</li>
                                @endif
                                 {!! custom_fields_view(6,$invoice['ins'],false,$invoice['ins']) !!}
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right mt-2">
                            <h2>{{$general['bill_type']}}</h2>
                            <p class="pb-1"> {{prefix($general['prefix'],$invoice['ins'])}} # {{$invoice['tid']}}</p>
                           @if($invoice['refer']) <p class="pb-1">{{trans('general.reference')}} : {{$invoice['refer']}}</p>@endif
                            <ul class="px-0 list-unstyled">
                                <li>{{trans('general.gross_amount')}}</li>
                                <li class="lead text-bold-800"> {{amountFormat($invoice['total'],$invoice['currency'])}}</li>
                            </ul>
                        </div>

                    </div>


                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->


                    <div class="row pt-3">
                        <div class="col-md-5 col-sm-12 text-xs-center text-md-left">

                            <p class="text-muted">{{trans('invoices.bill_to')}}</p>
                            <ul class="px-0 list-unstyled">
                                <li class="text-bold-800"><strong>  {{$invoice->customer->name}}</strong></li>
                                <li>{{$invoice->customer->address}},</li>
                                <li>{{$invoice->customer->city}}, {{$invoice->customer->region}},</li>
                                <li>{{$invoice->customer->country}}, @if($invoice->customer->postbox) - {{$invoice->customer->postbox}}@endif</li>
                                <li>{{$invoice->customer->email}},</li>
                                <li>{{$invoice->customer->phone}},</li>
                                @if($invoice->customer->taxid)
                                    <li>{{$general['tax_id']}}: {{$invoice->customer->taxid}}</li>@endif
                                {!! custom_fields_view($invoice['person'],$invoice['person_id'],false,$invoice['ins']) !!}
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-12 text-xs-center text-md-left">@if ($invoice->customer->name_s)
                                <p class="text-muted">{{trans('customers.address_s')}}</p>
                                <ul class="px-0 list-unstyled">


                                    <li class="text-bold-800"><strong>  {{$invoice->customer->name_s}}</strong></li>
                                    <li>{{$invoice->customer->address_s}},</li>
                                    <li>{{$invoice->customer->city_s}},{{$invoice->customer->region_s}}</li>
                                    <li>{{$invoice->customer->country_s}} - {{$invoice->customer->postbox_s}}.</li>
                                    <li>{{$invoice->customer->email_s}},</li>
                                    <li>{{$invoice->customer->phone_s}},</li>

                                </ul>
                            @endif
                        </div>
                        <div class="col-md-3 col-sm-12 text-md-right">
                            @php
                                $date_text = $general['lang_bill_due_date'];
                               $fill=false;
                            @endphp

                            <p><span class="text-muted">{{$general['lang_bill_date']}}</span>
                                : {{dateFormat($invoice['invoicedate'],$company['main_date_format'])}}</p>
                            <p><span class="text-muted">{{$general['lang_bill_due_date']}}</span>
                                : {{dateFormat($invoice['invoiceduedate'],$company['main_date_format'])}}</p>
                            <p><span class="text-muted">{{trans('general.payment_terms')}}</span>
                                : {{@$invoice->term->title}}</p>
                        </div>
                    </div>

                    <!--/ Invoice Customer Details -->
                    @if(isset($invoice['proposal']))
                        <div class="row">
                            <div class="col">

                                <hr>

                                <p>{!! $invoice['proposal']  !!}</p>
                            </div>

                        </div>@endif
                <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>

                                    @if($invoice['tax_format']=='exclusive' OR $invoice['tax_format']=='inclusive')
                                        <tr>
                                            <th>#</th>
                                            <th> {{trans('products.product_des')}}</th>
                                            <th class="text-xs-left">{{trans('products.qty')}}</th>
                                            <th class="text-xs-left">{{trans('products.price')}}</th>
                                            <th class="text-xs-left">{{trans('general.tax')}}</th>
                                            <th class="text-xs-left">{{trans('general.discount')}}</th>
                                            <th class="text-xs-left">{{trans('general.subtotal')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->products as $product)

                                        @php
                                            if ($fill == true) {
                                              $flag = ' m_fill';
                                          } else {
                                              $flag = '';
                                          }
                                           $fill = !$fill;
                                        @endphp
                                        <tr class="product_row {{$flag}}">
                                            <td style="width: 1rem;">
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{$product['product_name']}} @if(isset($product['serial'])){{$product['serial']}}@endif
                                            </td>
                                            <td>
                                                {{numberFormat($product['product_qty'])}} {{$product['unit']}}
                                            </td>
                                            <td>
                                                {{amountFormat($product['product_price'],$invoice['currency'])}}
                                            </td>


                                            <td>{{amountFormat($product['total_tax'],$invoice['currency'])}} <span
                                                        class="font-size-xsmall">({{numberFormat($product['product_tax'],$invoice['currency'])}}%)</span>
                                            </td>


                                            <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>

                                            <td>
                                                {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                                            </td>
                                        </tr>
                                        @if($product['product_des'])
                                            <tr class="product_row  {{$flag}}">
                                                <td style="width: 1rem;">

                                                </td>
                                                <td class="" colspan="4">  {!!$product['product_des'] !!} </td>

                                            </tr>
                                        @endif
                                        @if(isset($product->variation->id))
                                            <tr>
                                                <td colspan="7">{!! custom_fields_view(3,@$product->variation->id,false,true) !!}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    @elseif($invoice['tax_format']=='off' )
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('products.product_des')}}</th>
                                                <th class="text-right">{{trans('products.price')}}</th>
                                                <th class="text-right">{{trans('products.qty')}}</th>

                                                <th class="text-right">{{trans('general.discount')}}</th>
                                                <th class="text-right">{{trans('general.subtotal')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($invoice->products as $product)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>
                                                        <p>{{$product['product_name']}}</p>
                                                        <p class="text-muted">  <p class="text-muted">{!!$product['product_des'] !!}</p></p>@if($product['serial']){{$product['serial']}}@endif
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['product_price'])}}</td>
                                                    <td class="text-right">{{numberFormat($product['product_qty'])}} {{$product['unit']}}</td>

                                                    <td class="text-right">{{amountFormat($product['total_discount'])}}</td>
                                                    <td class="text-right">{{amountFormat($product['product_subtotal'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">{!! custom_fields_view(3,$product['product_id'],false) !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif

                                    @if($invoice['tax_format']=='cgst')
                                        <tr>
                                            <th>#</th>
                                            <th> {{trans('products.product_des')}}</th>
                                            <th class="text-xs-left">{{trans('products.qty')}}</th>
                                            <th class="text-xs-left">{{trans('products.price')}}</th>
                                            <th class="text-xs-left">{{trans('general.cgst')}}</th>
                                            <th class="text-xs-left">{{trans('general.sgst')}}</th>
                                            <th class="text-xs-left">{{trans('general.discount')}}</th>
                                            <th class="text-xs-left">{{trans('general.subtotal')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->products as $product)
                                            @php
                                                if ($fill == true) {
                                                  $flag = ' m_fill';
                                              } else {
                                                  $flag = '';
                                              }
                                               $fill = !$fill;

                                            @endphp
                                            <tr class="product_row {{$flag}}">
                                                <td style="width: 1rem;">
                                                    #
                                                </td>
                                                <td>
                                                    {{$product['product_name']}}
                                                </td>
                                                <td>
                                                    {{numberFormat($product['product_qty'])}} {{$product['unit']}}
                                                </td>
                                                <td>
                                                    {{amountFormat($product['product_price'],$invoice['currency'])}}
                                                </td>


                                                <td>{{amountFormat($product['total_tax']/2,$invoice['currency'])}} <span
                                                            class="font-size-xsmall">({{numberFormat($product['product_tax']/2,$invoice['currency'])}}%)</span>
                                                </td>
                                                <td>{{amountFormat($product['total_tax']/2,$invoice['currency'])}} <span
                                                            class="font-size-xsmall">({{numberFormat($product['product_tax']/2,$invoice['currency'])}}%)</span>
                                                </td>


                                                <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>

                                                <td>
                                                    {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                                                </td>
                                            </tr>

                                            @if($product['product_des'])
                                                <tr class="product_row  {{$flag}}">
                                                    <td style="width: 1rem;">

                                                    </td>
                                                    <td class="" colspan="4">{!!$product['product_des'] !!}</td>

                                                </tr>
                                            @endif
                                            @if(isset($product->variation->id))
                                                <tr>
                                                    <td colspan="7">{!! custom_fields_view(3,@$product->variation->id,false,true) !!}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    @endif

                                    @if($invoice['tax_format']=='igst')
                                        <tr>
                                            <th>#</th>
                                            <th> {{trans('products.product_des')}}</th>
                                            <th class="text-xs-left">{{trans('products.qty')}}</th>
                                            <th class="text-xs-left">{{trans('products.price')}}</th>
                                            <th class="text-xs-left">{{trans('general.igst')}}</th>
                                            <th class="text-xs-left">{{trans('general.discount')}}</th>
                                            <th class="text-xs-left">{{trans('general.subtotal')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->products as $product)
                                            @php
                                                if ($fill == true) {
                                                  $flag = ' m_fill';
                                              } else {
                                                  $flag = '';
                                              }
                                               $fill = !$fill;

                                            @endphp
                                            <tr class="product_row {{$flag}}">
                                                <td style="width: 1rem;">
                                                    #
                                                </td>
                                                <td>
                                                    {{$product['product_name']}}
                                                </td>
                                                <td>
                                                    {{numberFormat($product['product_qty'])}} {{$product['unit']}}
                                                </td>
                                                <td>
                                                    {{amountFormat($product['product_price'],$invoice['currency'])}}
                                                </td>


                                                <td>{{amountFormat($product['total_tax'],$invoice['currency'])}} <span
                                                            class="font-size-xsmall">({{numberFormat($product['product_tax'],$invoice['currency'])}}%)</span>
                                                </td>


                                                <td>{{amountFormat($product['total_discount'],$invoice['currency'])}}</td>

                                                <td>
                                                    {{amountFormat($product['product_subtotal'],$invoice['currency'])}}
                                                </td>
                                            </tr>
                                            @if($product['product_des'])
                                                <tr class="product_row  {{$flag}}">
                                                    <td style="width: 1rem;">

                                                    </td>
                                                    <td class="" colspan="4">{!!$product['product_des'] !!}</td>

                                                </tr>
                                            @endif
                                            @if(isset($product->variation->id))
                                                <tr>
                                                    <td colspan="7">{!! custom_fields_view(3,@$product->variation->id,false,true) !!}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    @endif


                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                                <div class="row">
                                    <div class="col-md-8"><p
                                                class="lead">{{trans('general.status')}}:
                                            <u><strong
                                                        id="pstatus">{{trans('payments.'.$invoice['status'])}}</strong></u>
                                        </p>
                                        @if($invoice['pmethod'])
                                            <p class="lead">{{trans('general.payment_method')}}: <u><strong
                                                            id="pmethod">{{$invoice['pmethod']}}</strong></u>
                                            </p>
                                        @endif

                                        @if($invoice['notes'])<p class="lead mt-1"><br>{{trans('general.note')}}:</p>
                                        <code>
                                            {{$invoice['notes']}}
                                        </code> @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">{{trans('general.summary')}}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>{{trans('general.subtotal')}}</td>
                                            <td class="text-xs-right"> {{amountFormat($invoice['subtotal'],$invoice['currency'])}}</td>
                                        </tr>
                                        @if($invoice['tax']>0)
                                            <tr>
                                                <td>{{$general['tax_string_total']}}</td>
                                                <td class="text-xs-right">{{amountFormat($invoice['tax'],$invoice['currency'])}}</td>
                                            </tr>@endif
                                        @if($invoice['discount']>0)
                                            <tr>
                                                <td>{{trans('general.discount')}}</td>
                                                <td class="text-xs-right">{{amountFormat($invoice['discount'],$invoice['currency'])}}</td>
                                            </tr>@endif
                                        @if($invoice['shipping']>0)
                                            <tr>
                                                <td>{{trans('general.shipping')}}</td>
                                                <td class="text-xs-right">{{amountFormat($invoice['shipping'],$invoice['currency'])}}</td>
                                            </tr>
                                            @if($invoice['ship_tax']>0)
                                                <tr>
                                                    <td>{{trans('general.shipping_tax')}}
                                                        ({{trans('general.'.$invoice['ship_tax_type'])}})
                                                    </td>
                                                    <td>{{amountFormat($invoice['ship_tax'],$invoice['currency'])}}</td>
                                                </tr>@endif
                                        @endif
                                        <tr>
                                            <td class="text-bold-800">{{trans('general.total')}}</td>
                                            <td class="text-bold-800">{{amountFormat($invoice['total'],$invoice['currency'])}}</td>
                                        </tr>
                                        @if( $general['status_block'])
                                            <tr>
                                                <td>{{trans('general.payment_made')}}</td>
                                                <td class="pink">(-) <span
                                                            id="payment_made">{{amountFormat($invoice['pamnt'],$invoice['currency'])}}</span>
                                                </td>
                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800">{{trans('general.balance_due')}}</td>
                                                <td class="text-bold-800"
                                                    id="payment_due"> {{amountFormat($invoice['total']-$invoice['pamnt'],$invoice['currency'])}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <p><strong>{{trans('general.authorized_person')}}</strong></p>
                                    <img src="{{ Storage::disk('public')->url('app/public/img/signs/' . $invoice->user->signature) }}"
                                         alt="signature" class="height-100 m-2"/>
                                    <h6>({{$invoice->user->first_name}} {{$invoice->user->last_name}})</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer">
                        @if(isset($invoice->transactions[0]))
                            <p class="lead">{{trans('transactions.transactions')}}
                                :</p>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('transactions.payment_date')}}</th>
                                    <th class="">{{trans('transactions.method')}}</th>
                                    <th class="text-right">{{trans('transactions.debit')}}</th>
                                    <th class="text-right">{{trans('transactions.credit')}}</th>
                                    <th class="">{{trans('general.note')}}</th>


                                </tr>
                                </thead>
                                <tbody id="activity">
                                @foreach($invoice->transactions as $transaction)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <p class="text-muted">{{$transaction['payment_date']}}</p>
                                        </td>
                                        <td class="">{{$transaction['method']}}</td>
                                        <td class="text-right">{{amountFormat($transaction['debit'],$invoice['currency'])}}</td>
                                        <td class="text-right">{{amountFormat($transaction['credit'],$invoice['currency'])}}</td>
                                        <td class="">{{$transaction['note']}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                        <hr>
                        {!! custom_fields_view($invoice['custom'],$invoice['id'],true,$invoice['ins']) !!}
                        <div class="row">

                            <div class="col-md-7 col-sm-12">


                                <h5>{{@$invoice->term->title}}</h5>
                                <p>{!! @$invoice->term->terms !!}</p>
                            </div>

                        </div>


                    </div>
                    <!--/ Invoice Footer -->

                    @if(isset($invoice->attachment))
                        <table id="files" class="files table table-striped mt-2">
                            @foreach($invoice->attachment as $row)
                                <tr>
                                    <td>
                                        <a href="{{ Storage::disk('public')->url('app/public/files/' . $row['value']) }}"
                                           class="purple"><i class="btn-sm fa fa-eye"></i> {{$row['value']}}</a></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                </section>
            </div>
        </div>
    </div>
    @if($online_payment)
        <div id="paymentCard" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{trans('general.make_payment')}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @foreach ($gateway as $row)
                            @if($row->config['enable']=='Yes')
                                @php
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    if ($row->config['surcharge'] > 0) {
                                        $surcharge_t = true;
                                        $fee = '( ' . amountFormat($invoice['total']-$invoice['pamnt'],$invoice['currency']) . '+' . numberFormat($row->config['surcharge']) . ' %)';
                                    } else {
                                        $fee = '';
                                    }
                                @endphp
                                <a href="{{$link['payment']}}?g={{$row['id']}}"
                                   class="btn mb-1 btn-block blue rounded border border-info text-bold-700 border-lighten-5 "><span
                                            class=" display-block"><span
                                                class="grey">{{trans('payments.pay_with')}} </span><span
                                                class="blue font-medium-2">{{$row['name']}} {{$fee}}</span></span><br>

                                    <img class="mt-1 bg-white round" style="max-width:20rem;max-height:10rem"
                                         src="{{ Storage::disk('public')->url('app/public/img/gateway_logo/' . $row['id'].'.png') }}">
                                </a><br>
                            @endif
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    @endif
@endsection