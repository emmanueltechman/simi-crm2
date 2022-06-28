@extends ('core.layouts.app')

@section ('title', trans('labels.backend.invoices.management') . ' | ' . trans('labels.backend.invoices.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.invoices.management') }}
        <small>{{ trans('labels.backend.invoices.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">

            <div class="content-body">
                <section class="card">
                    <div id="invoice-template" class="card-body">
                        <div class="row">
                            @if($invoice['status']!='canceled')
                                <div class="col">
                                    <a href="{{$invoice['id']}}/edit" class="btn btn-warning mb-1"><i
                                                class="fa fa-pencil"></i> {{trans('labels.backend.invoices.edit')}}</a>

                                    <a href="#modal_bill_payment_1" data-toggle="modal" data-remote="false"
                                       data-type="reminder"
                                       class="btn btn-large btn-info mb-1" title="Partial Payment"><span
                                                class="fa fa-money"></span> {{trans('general.make_payment')}} </a>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-facebook dropdown-toggle mb-1"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="fa fa-envelope-o"></span> {{trans('customers.email')}}
                                        </button>
                                        <div class="dropdown-menu"><a href="#sendEmail" data-toggle="modal"
                                                                      data-remote="false"
                                                                      class="dropdown-item send_bill"
                                                                      data-type="1"
                                                                      data-type1="notification">{{trans('general.invoice_notification')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                               class="dropdown-item send_bill"
                                               data-type="2"
                                               data-type1="reminder">{{trans('general.payment_reminder')}}</a>
                                            <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                               class="dropdown-item send_bill"
                                               data-type="3"
                                               data-type1="received">{{trans('general.payment_received')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                               class="dropdown-item send_bill" href="#"
                                               data-type="4"
                                               data-type1="overdue"> {{trans('general.payment_overdue')}}</a><a
                                                    href="#sendEmail" data-toggle="modal" data-remote="false"
                                                    class="dropdown-item send_bill"
                                                    data-type="5"
                                                    data-type1="refund">{{trans('general.refund_generated')}}</a>
                                        </div>

                                    </div>

                                    <!-- SMS -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-blue dropdown-toggle mb-1"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="fa fa-mobile"></span> {{trans('general.sms')}}
                                        </button>
                                        <div class="dropdown-menu"><a href="#sendSMS" data-toggle="modal"
                                                                      data-remote="false" class="dropdown-item send_sms"
                                                                      data-type="11"
                                                                      data-type1="notification">{{trans('general.invoice_notification')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#sendSMS" data-toggle="modal" data-remote="false"
                                               class="dropdown-item send_sms"
                                               data-type="12"
                                               data-type1="reminder">{{trans('general.payment_reminder')}}</a>
                                            <a
                                                    href="#sendSMS" data-toggle="modal" data-remote="false"
                                                    class="dropdown-item send_sms"
                                                    data-type="13"
                                                    data-type1="received">{{trans('general.payment_received')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#sendSMS" data-toggle="modal" data-remote="false"
                                               class="dropdown-item send_sms" href="#"
                                               data-type="14"
                                               data-type1="overdue">{{trans('general.payment_overdue')}}</a><a
                                                    href="#sendSMS" data-toggle="modal" data-remote="false"
                                                    class="dropdown-item send_sms"
                                                    data-type="15"
                                                    data-type1="refund">{{trans('general.refund_generated')}}</a>
                                        </div>

                                    </div>

                                    @php
                                        $valid_token = token_validator('','i' . $invoice['id'].$invoice['tid'],true);
                                        $link=route( 'biller.print_bill',[$invoice['id'],1,$valid_token,1]);
                                        $link_download=route( 'biller.print_bill',[$invoice['id'],1,$valid_token,2]);
                                        $link_preview=route( 'biller.view_bill',[$invoice['id'],1,$valid_token,0]);
                                             if($invoice['i_class']>1) {
                                    $title= trans('invoices.subscription');
                                  $inv_no= prefix(6).' # '.$invoice['tid'];
                                  } else  if($invoice['i_class']==1) {
                                    $title= trans('invoices.pos');
                                  $inv_no= prefix(10).' # '.$invoice['tid'];
                                  }
                                else {
                                   $title= trans('invoices.invoice');
                                  $inv_no= prefix(1).' # '.$invoice['tid'];
                                }

                                    @endphp

                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                    class="fa fa-print"></i> {{trans('general.print')}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{$link}}">{{trans('general.print')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                               href="{{$link_download}}">{{trans('general.pdf')}}</a>

                                        </div>
                                    </div>
                                    <a href="{{$link_preview}}" class="btn btn-purple mb-1"><i
                                                class="fa fa-globe"></i> {{trans('general.preview')}}
                                    </a>

                                    <a href="#pop_model_1" data-toggle="modal" data-remote="false"
                                       class="btn btn-large btn-cyan mb-1" title="Change Status"
                                    ><span class="fa fa-retweet"></span> {{trans('general.change_status')}}</a>
                                    <a href="#pop_model_2" class="btn btn-danger mb-1" data-toggle="modal"
                                       data-remote="false"><i
                                                class="fa fa-minus-circle"> </i> {{trans('general.cancel')}}
                                    </a>
                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-primary mb-1 btn-min-width dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                    class="icon-anchor"></i> {{trans('general.extra_options')}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{route('biller.invoices.print_document',[$invoice['id'],1])}}">{{trans('general.delivery_note')}}</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                               href="{{route( 'biller.print_bill',[$invoice['id'],3,$valid_token,1])}}">{{trans('general.proforma_invoice')}}</a>

                                        </div>
                                    </div>
                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-vimeo mb-1 btn-md dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                    class="fa fa-print"></i> {{trans('general.pos_print')}}
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{route('biller.print_compact',[$invoice['id'],1,$valid_token,1])}}">{{trans('general.pdf_print')}}</a>
                                        </div>
                                    </div>
                                    @if($invoice['i_class']>1)
                                        <a href="#pop_model_4" data-toggle="modal" data-remote="false"
                                           class="btn btn-large btn-blue-grey mb-1" title="Change Status"
                                        ><span class="fa fa-superscript"></span> {{trans('invoices.subscription')}}</a>

                                    @endif
                                </div>
                            @else
                                <div class="badge text-center white d-block m-1"><span class="bg-danger round p-1">&nbsp;&nbsp;{{trans('payments.'.$invoice['status'])}}&nbsp;&nbsp;</span>
                                </div>
                            @endif
                        </div>
                                              @php

                                             if($invoice['i_class']>1) {
                                    $title= trans('invoices.subscription');
                                  $inv_no= prefix(6).' # '.$invoice['tid'];
                                  } else  if($invoice['i_class']==1) {
                                    $title= trans('invoices.pos');
                                  $inv_no= prefix(10).' # '.$invoice['tid'];
                                  }
                                else {
                                   $title= trans('invoices.invoice');
                                  $inv_no= prefix(1).' # '.$invoice['tid'];
                                }

                                    @endphp
                        @if($invoice['currency'])
                            <div class="badge text-center white d-block m-1"><span class="bg-danger round p-1">&nbsp;&nbsp;{{trans('general.different_currency')}}&nbsp;&nbsp;</span>
                            </div>
                    @endif

                    <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">{{trans('general.our_info')}}
                                <div class="">
                                    <img src="{{ Storage::disk('public')->url('app/public/img/company/' . config('core.logo')) }}"
                                         alt="company logo" class="avatar-100 img-responsive"/>
                                    <div class="media-body"><br>
                                        <ul class="px-0 list-unstyled">
                                            <li class="text-bold-800">{{(config('core.cname'))}}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 text-xs-center text-md-right">

                                <h2>{{$title}}</h2>
                                <p class="pb-1">{{$inv_no}}</p>
                               @if($invoice['order_id'])   <p >{{trans('orders.order')}}: {{$invoice['order_id']}}</p> @endif

                                @if(isset($invoice->market->bill->name))   <p >{{trans('sales_channel.sales_channel')}} : {{$invoice->market->bill->name}}</p> @endif

                                @php
                                    switch ($invoice['i_class']){
                                    case 2: echo '<h4 ><span class="st-sub2">'.trans('payments.active').'</span></h4>';
                                    break;
                                    case 3: echo '<h4 ><span class="st-sub3">'.trans('payments.recurred').'</span></h4>';
                                    break;
                                    case 4: echo '<h4 ><span class="st-sub4">'.trans('payments.stopped').'</span></h4>';
                                    break;
                                    }
                                @endphp

                                <ul class="px-0 list-unstyled">
                                    <li>{{trans('general.total')}}</li>
                                    <li class="lead text-bold-800">{{amountFormat($invoice['total'])}}</li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Invoice Company Details -->

                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-sm-12 text-center text-md-left">
                                <p class="text-muted">{{trans('invoices.bill_to')}}</p>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"><a
                                                href="{{route('biller.customers.show',[$invoice->customer->id])}}">{{$invoice->customer->name}}</a>
                                    </li>
                                    <li>{{$invoice->customer->address}},</li>
                                    <li>{{$invoice->customer->city}},{{$invoice->customer->region}}</li>
                                    <li>{{$invoice->customer->country}}-{{$invoice->customer->postbox}}.</li>
                                    <li>{{$invoice->customer->email}},</li>
                                    <li>{{$invoice->customer->phone}},</li>
                                    {!! custom_fields_view(1,$invoice->customer->id,false) !!}
                                </ul>
                            </div>

                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <p>
                                    <span class="text-muted">{{trans('invoices.invoice_date')}} :</span> {{dateFormat($invoice['invoicedate'])}}
                                </p>

                                <p>
                                    <span class="text-muted">{{trans('invoices.invoice_due_date')}} :</span> {{dateFormat($invoice['invoiceduedate'])}}
                                </p>
                                <div class="row">
                                    <div class="col">

                                        <hr>

                                        <p class=" text-danger">{{$invoice['notes']}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">

                                    <table class="table">
                                        @if($invoice['tax_format']=='exclusive' OR $invoice['tax_format']=='inclusive' )
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('products.product_des')}}</th>
                                                <th class="text-right">{{trans('products.price')}}</th>
                                                <th class="text-right">{{trans('products.qty')}}</th>
                                                <th class="text-right">{{trans('general.tax')}}</th>
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
                                                    <td class="text-right">{{amountFormat($product['total_tax'])}} <span
                                                                class="font-size-xsmall">({{numberFormat($product['product_tax'])}}%)</span>
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['total_discount'])}}</td>
                                                    <td class="text-right">{{amountFormat($product['product_subtotal'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">{!! custom_fields_view(3,$product['product_id'],false) !!}</td>
                                                </tr>
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
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('products.product_des')}}</th>
                                                <th class="text-right">{{trans('products.price')}}</th>
                                                <th class="text-right">{{trans('products.qty')}}</th>
                                                <th class="text-right">{{trans('general.cgst')}}</th>
                                                <th class="text-right">{{trans('general.sgst')}}</th>
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
                                                          <p class="text-muted">{!!$product['product_des'] !!}</p>@if($product['serial']){{$product['serial']}}@endif
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['product_price'])}}</td>
                                                    <td class="text-right">{{numberFormat($product['product_qty'])}} {{$product['unit']}}</td>
                                                    <td class="text-right">{{amountFormat($product['total_tax']/2)}}
                                                        <span class="font-size-xsmall">({{numberFormat($product['product_tax']/2)}}%)</span>
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['total_tax']/2)}}
                                                        <span class="font-size-xsmall">({{numberFormat($product['product_tax']/2)}}%)</span>
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['total_discount'])}}</td>
                                                    <td class="text-right">{{amountFormat($product['product_subtotal'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8">{!! custom_fields_view(3,$product['product_id'],false) !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif

                                        @if($invoice['tax_format']=='igst')
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('products.product_des')}}</th>
                                                <th class="text-right">{{trans('products.price')}}</th>
                                                <th class="text-right">{{trans('products.qty')}}</th>
                                                <th class="text-right">{{trans('general.igst')}}</th>
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
                                                        <p class="text-muted">{!!$product['product_des'] !!}</p>@if($product['serial']){{$product['serial']}}@endif
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['product_price'])}}</td>
                                                    <td class="text-right">{{numberFormat($product['product_qty'])}} {{$product['unit']}}</td>
                                                    <td class="text-right">{{amountFormat($product['total_tax'])}} <span
                                                                class="font-size-xsmall">({{numberFormat($product['product_tax'])}}%)</span>
                                                    </td>
                                                    <td class="text-right">{{amountFormat($product['total_discount'])}}</td>
                                                    <td class="text-right">{{amountFormat($product['product_subtotal'])}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">{!! custom_fields_view(3,$product['product_id'],false) !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif


                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7 col-sm-12 text-center text-md-left">
                                    <p class="lead">{{trans('payments.payment_status')}}:</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-md">
                                                <tbody>
                                                <tr>
                                                    <td>{{trans('payments.payment_status')}}:</td>
                                                    <td id="status"
                                                        class="badge st-{{$invoice['status']}}">{{trans('payments.'.$invoice['status'])}}</td>
                                                </tr>
                                                @if($invoice['pmethod'])
                                                    <tr>
                                                        <td>{{trans('general.payment_method')}}:</td>
                                                        <td id="method">{{$invoice['pmethod']}}</td>
                                                    </tr>
                                                @endif


                                                </tbody>
                                            </table>
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
                                                <td class="text-right">{{amountFormat($invoice['subtotal'])}}</td>
                                            </tr>
                                            @if($invoice['tax']>0)
                                                <tr>
                                                    <td>{{trans('general.tax')}}</td>
                                                    <td class="text-right">{{amountFormat($invoice['tax'])}}</td>
                                                </tr>@endif
                                            @if($invoice['discount']>0)
                                                <tr>
                                                    <td>{{trans('general.discount')}}</td>
                                                    <td class="text-right">{{amountFormat($invoice['discount'])}}</td>
                                                </tr>@endif
                                            @if($invoice['shipping']>0)
                                                <tr>
                                                    <td>{{trans('general.shipping')}}</td>
                                                    <td class="text-right">{{amountFormat($invoice['shipping'])}}</td>
                                                </tr>
                                                @if($invoice['ship_tax']>0)
                                                    <tr>
                                                        <td>{{trans('general.shipping_tax')}}
                                                            ({{trans('general.'.$invoice['ship_tax_type'])}})
                                                        </td>
                                                        <td class="text-right">{{amountFormat($invoice['ship_tax'])}}</td>
                                                    </tr>@endif
                                            @endif
                                            <tr>
                                                <td class="text-bold-800">{{trans('general.total')}}</td>
                                                <td class="text-bold-800 text-right">{{amountFormat($invoice['total'])}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{trans('general.payment_made')}}</td>
                                                <td class="pink text-right">(-) <span
                                                            id="payment_made">{{amountFormat($invoice['pamnt'])}}</span>
                                                </td>
                                            </tr>
                                            <tr class="bg-grey bg-lighten-4">
                                                <td class="text-bold-800">{{trans('general.balance_due')}}</td>
                                                <td class="text-bold-800 text-right"
                                                    id="payment_due"> {{amountFormat($invoice['total']-$invoice['pamnt'])}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <p>{{trans('general.authorized_person')}}</p>
                                        <img src="{{ Storage::disk('public')->url('app/public/img/signs/' . $invoice->user->signature) }}"
                                             alt="signature" class="height-100 m-2"/>
                                        <h6>{{$invoice->user->first_name}} {{$invoice->user->last_name}}</h6>

                                    </div>
                                </div>
                            </div>
                        </div>

                    {!! custom_fields_view(2,$invoice['id']) !!}

                    <!-- Invoice Footer -->
                        <div id="invoice-footer">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <h5>{{trans('general.payment_terms')}}</h5>
                                    <hr>
                                    <h5>{{@$invoice->term->title}}</h5>
                                    <p>{!! @$invoice->term->terms !!}</p>
                                </div>
                                <div class="col-md-5 col-sm-12 text-center">
                                    @if($invoice['status']!='canceled')   <a href="#sendEmail" data-toggle="modal"
                                                                             data-remote="false"
                                                                             data-type="1"
                                                                             data-type1="notification"
                                                                             class="btn btn-primary btn-lg my-1 send_bill"><i
                                                class="fa fa-paper-plane-o"></i> {{trans('general.send')}}
                                    </a>@endif
                                </div>
                            </div>
                        </div>


                        <!--/ Invoice Footer -->
                        <div class="row mt-2">

                            <div class="col-md-12">
                                <p class="lead">{{trans('transactions.transactions')}}</p>
                                <table class="table table-bordered table-md table-striped">
                                    @if(isset($invoice->transactions[0]))
                                        <thead>
                                        <th>#</th>
                                        <th>{{trans('transactions.payment_date')}}</th>
                                        <th class="">{{trans('transactions.method')}}</th>
                                        <th class="text-right">{{trans('transactions.debit')}}</th>
                                        <th class="text-right">{{trans('transactions.credit')}}</th>
                                        <th class="">{{trans('transactions.note')}}</th>
                                        </thead>     @endif
                                    <tbody id="transaction_activity">
                                    @foreach($invoice->transactions as $transaction)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <p class="text-muted"><a
                                                            href="{{route('biller.print_payslip',[$transaction['id'],1,1])}}"
                                                            class="btn btn-blue btn-sm"><span class="fa fa-print"
                                                                                              aria-hidden="true"></span></a> {{$transaction['payment_date']}}
                                                </p>
                                            </td>
                                            <td class="">{{$transaction['method']}}</td>
                                            <td class="text-right">{{amountFormat($transaction['debit'])}}</td>
                                            <td class="text-right">{{numberFormat($transaction['credit'])}}</td>
                                            <td class="">{{$transaction['note']}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-12">
                                <p class="lead">{{trans('general.attachment')}}</p>
                                <pre>{{trans('general.allowed')}}:   {{$features['value1']}} </pre>
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <div class="btn btn-success fileinput-button display-block col-2">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Select files...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" type="file" name="files">
                                </div>
                            </div>
                        </div>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress progress-sm mt-1 mb-0 col-md-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- The container for the uploaded files -->
                        <table id="files" class="files table table-striped mt-2">
                            @foreach($invoice->attachment as $row)
                                <tr>
                                    <td><a data-url="{{route('biller.bill_attachment')}}?op=delete&id={{$row['id']}}"
                                           class="aj_delete red"><i class="btn-sm fa fa-trash"></i></a> <a
                                                href="{{ Storage::disk('public')->url('app/public/files/' . $row['value']) }}"
                                                class="purple"><i class="btn-sm fa fa-eye"></i> {{$row['value']}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <br>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include("focus.modal.payment_model",array('category'=>0))
    @include("focus.modal.email_model",array('category'=>1))
    @include("focus.modal.sms_model",array('category'=>2))
    @include("focus.modal.status_model")
    @include("focus.modal.cancel_model")
    @include("focus.modal.subscription_model")
@endsection
@section('extra-style')
    {!! Html::style('focus/jq_file_upload/css/jquery.fileupload.css') !!}
@endsection
@section('extra-scripts')
    {{ Html::script('focus/jq_file_upload/js/jquery.fileupload.js') }}
    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });
        $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
        $(function () {
            'use strict';
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ],
                popover: {}
            });
            // Change this to the location of your server-side upload handler:
            var url = '{{route('biller.bill_attachment')}}';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                formData: {_token: "{{ csrf_token() }}", id: '{{$invoice['id']}}', 'bill': 1},
                done: function (e, data) {

                    $.each(data.result, function (index, file) {
                        $('#files').append('<tr><td><a data-url="{{route('biller.bill_attachment')}}?op=delete&id= ' + file.id + ' " class="aj_delete red"><i class="btn-sm fa fa-trash"></i></a> ' + file.name + ' </td></tr>');
                    });

                },
                progressall: function (e, data) {

                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );

                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');


            $(document).on('click', ".aj_delete", function (e) {
                e.preventDefault();
                var aurl = $(this).attr('data-url');
                var obj = $(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: aurl,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        obj.closest('tr').remove();
                        obj.remove();
                    }
                });

            });
        });
    </script>

@endsection