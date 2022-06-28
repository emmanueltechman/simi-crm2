@extends ('core.layouts.pos_app')

@section ('title', trans('pos.sale'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.invoices.management') }}
        <small>{{ trans('labels.backend.invoices.create') }}</small>
    </h1>
@endsection

@section('content')

    {{ Form::model($invoices, ['id' => 'data_form']) }}
    <div class="pos_panel">
        <div class="rose_wrapper" id="sales_box">
            <div class="rose_wrap_left">
                <div class="invoice_settings">
                    <ul class="choose-section inv_config">
                        <li id="products_tab" class="active"><a
                                    href="javascript:void(false);">{{trans('pos.inventory')}}</a>
                        </li>
                        <li id="invoice_tab">
                            <a href="javascript:void(false);">{{trans('pos.settings')}}</a></li>
                        <li id="drafts">
                            <a href="javascript:void(false);">{{trans('pos.on_hold')}}</a></li>
                    </ul>
                </div>

                <div class="row" id="search_product">
                    <div class="col-9">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control"
                                   placeholder="{{trans('general.search_product')}}"
                                   name="keyword" id="keyword" data-std_holder="{{trans('general.search_product')}}"
                                   data-serial_holder="{{trans('products.search_serial_only')}}" autocomplete="off">
                            <div class="form-control-position">
                                <i class="fa fa-barcode info fa-2x"></i>
                            </div>

                        </fieldset>
                    </div>
                    <div class="col-3">
                        <div class="btn-group" role="group">
                            <a class="btn btn-lighten-3 btn-purple" data-toggle="modal"
                               data-target="#pos_stock"><i
                                        class="ft-package"></i></a>
                            <a class="btn   btn-blue-grey" onclick="return changeStyle();"><i
                                        class="fa fa-eye"></i></a>

                        </div>
                    </div>
                </div>


                <!-- items_load -->
                <div id="items_load">


                    <div id="items_list">

                        <div class="loaded_products" id="product_group">

                            Loading...

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div id="invoice_config">
                    <div class="row m-0">
                        <div class="col-10">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control "
                                       placeholder="{{trans('invoices.search_client')}}" id="customer-box"
                                       name="cst">
                                <div class="form-control-position">
                                    <i class="fa fa-user-circle  fa-2x"></i>
                                </div>
                            </fieldset>

                        </div>
                        <div class="col-2 p-0 m-0">

                            <a class="btn  btn-lighten-2 btn-instagram round" data-toggle="modal"
                                    data-target="#addCustomer"><i
                                        class="ft-plus-circle font-medium-3"></i></a>

                        </div>
                    </div>

                    <div id="customer-box-result"></div>
                    {{ Form::hidden('customer_id', $invoices['customer_id'],['id'=>'customer_id']) }}
                    <div id="customer" style="display: none;">
                        <div class="border p-1">
                            <div class="clientinfo">
                                <div id="customer_name">{{$invoices->customer->name}}</div>
                            </div>

                            <div class="clientinfo">
                                <div id="customer_phone">{{$invoices->customer->phone}}</div>
                            </div>

                            <div id="customer_pass"></div>

                        </div>

                    </div>
                    <hr>
                    <div class="row m-0">
                        <div class="col-6">
                            <strong> {{trans('general.extra_discount')}}</strong><input type="text"
                                                                                        class="form-control  discVal"
                                                                                        onkeypress="return isNumber(event)"
                                                                                        placeholder="Value"
                                                                                        name="discount_rate"
                                                                                        autocomplete="off"
                                                                                        value="{{numberFormat($invoices['discount_rate'])}}"
                                                                                        onkeyup="billUpyog()">
                            <input type="hidden"
                                   name="after_disc" id="after_disc"
                                   value="{{numberFormat($invoices['extra_discount'])}}">
                            ( {{config('currency.symbol')}}
                            <span id="disc_final">{{numberFormat($invoices['extra_discount'])}}</span> )

                        </div>
                        <div class="col-6">
                            <strong>{{trans('general.shipping')}}</strong><input type="text"
                                                                                 class="form-control shipVal"
                                                                                 onkeypress="return isNumber(event)"
                                                                                 placeholder="Value"
                                                                                 name="shipping" autocomplete="off"
                                                                                 onkeyup="billUpyog()">
                            ( {{trans('general.tax')}} {{config('currency.symbol')}}
                            <span id="ship_final">0</span> )
                        </div>
                        <div class="col-12 mt-2"></div>
                        <div class="col-6">{{trans('general.payment_currency_client')}}
                            <small>{{trans('general.based_live_market')}}</small>
                            <select name="currency"
                                    class="selectpicker form-control">
                                <option value="0">Default</option>
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}" {{$currency->id==$invoices['currency'] ? 'selected' : ''}}>{{$currency->symbol}}
                                        - {{$currency->code}}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="col-6">{{trans('general.payment_terms')}} <select name="term_id"
                                                                                      class="selectpicker form-control">
                                @foreach($terms as $term)
                                    <option value="{{$term->id}}" {{$term->id==$invoices['term_id'] ? 'selected' : ''}}>{{$term->title}}</option>
                                @endforeach

                            </select></div>

                    </div>

                    <hr>
                    <div class="col">


                        <div class="row">
                            <div class="col-sm-6"><label for="invocieno"
                                                         class="caption">{{trans('invoices.tid')}}</label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-file-text-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    {{ Form::number('tid', null, ['class' => 'form-control round', 'placeholder' => trans('invoices.tid')]) }}
                                </div>
                            </div>
                            <div class="col-sm-6"><label for="invocieno"
                                                         class="caption">{{trans('general.reference')}}</label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    {{ Form::text('refer', null, ['class' => 'form-control round', 'placeholder' => trans('general.reference')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6"><label for="invociedate"
                                                         class="caption">{{trans('invoices.invoice_date')}}</label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar4"
                                                                         aria-hidden="true"></span>
                                    </div>
                                    {{ Form::text('invoicedate', date_for_database($invoices['invoicedate']), ['class' => 'form-control round required', 'placeholder' => trans('invoices.invoice_date'),'data-toggle'=>'datepicker','autocomplete'=>'false','id'=>'date1']) }}
                                </div>
                            </div>

                            <div class="col-sm-6"><label for="invocieduedate"
                                                         class="caption">{{trans('invoices.invoice_due_date')}}</label>

                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-calendar-o"
                                                                         aria-hidden="true"></span>
                                    </div>

                                    {{ Form::text('invoiceduedate', date_for_database($invoices['invoiceduedate']), ['class' => 'form-control round required', 'placeholder' => trans('invoices.invoice_due_date'),'data-toggle'=>'datepicker','autocomplete'=>'false','id'=>'date2']) }}
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="taxFormat"
                                       class="caption">{{trans('general.tax')}}</label>
                                <select class="form-control round"
                                        onchange="changeTaxFormat()"
                                        id="taxFormat">
                                    @php
                                        $tax_format='exclusive';
                                        $tax_format_id=0;
                                        $tax_format_type='exclusive';
                                        $tax_flag=true;
                                    @endphp
                                    @foreach($additionals as $additional_tax)

                                        @php
                                            if($additional_tax->id == $invoices['tax_id']  && $additional_tax->class == 1 && $tax_flag){
                                             echo '<option value="'.numberFormat($additional_tax->value).'" data-type1="'.$additional_tax->type1.'" data-type2="'.$additional_tax->type2.'" data-type3="'.$additional_tax->type3.'" data-type4="'.$additional_tax->id.'" selected>--'.$additional_tax->name.'--</option>';
                                             $tax_format=$additional_tax->type2;
                                             $tax_flag=false;
                                             $tax_format_type=$additional_tax->type3;
                                              $tax_format_id=$additional_tax->id;

                                            }

                                        @endphp
                                        {!! $additional_tax->class == 1 ? "<option value='".numberFormat($additional_tax->value)."' data-type1='$additional_tax->type1' data-type2='$additional_tax->type2' data-type3='$additional_tax->type3' data-type4='$additional_tax->id'>$additional_tax->name</option>" : "" !!}
                                    @endforeach

                                    <option value="0" data-type1="%" data-type2="off"
                                            data-type3="off" @if(!$tax_format_id) selected @endif>{{trans('general.off')}}</option>
                                </select>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="discountFormat"
                                           class="caption">{{trans('general.discount')}}</label>
                                    <select class="form-control round"
                                            onchange="changeDiscountFormat()"
                                            id="discountFormat">
                                        @php
                                            $discount_format='%';
                                        @endphp
                                        @foreach($additionals as $additional_discount)
                                            @php
                                                if($additional_discount->type1== $invoices['discount_format'] && $additional_discount->class == 2){
                                                 echo '<option value="'.$additional_discount->value.'" data-type1="'.$additional_discount->type1.'" data-type2="'.$additional_discount->type2.'" data-type3="'.$additional_discount->type3.'" selected>--'.$additional_discount->name.'--</option>';
                                                 $discount_format=$additional_discount->type1;
                                                }
                                            @endphp
                                            {!! $additional_discount->class == 2 ? "<option value='$additional_discount->value' data-type1='$additional_discount->type1' data-type2='$additional_discount->type2' data-type3='$additional_discount->type3'>$additional_discount->name</option>" : "" !!}
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-sm-12">
                                <label for="toAddInfo"
                                       class="caption">{{trans('invoices.invoice_note')}}</label>

                                {{ Form::textarea('notes', null, ['class' => 'form-control round', 'placeholder' => trans('invoices.invoice_note'),'rows'=>'2']) }}
                            </div>
                        </div>

                    </div>
                    <div class="clear mt-2"></div>

                </div>
                <div id="drafts_load">

                    <table class="table" id="drafts_list">
                    </table>
                    <div class="clear"></div>
                </div>
            </div>


            <div class="rose_wrap_right">
                <div class="receipt_panel" id="receipt_section">

                    <div class="summary">
                        <span><i class="fa fa-file-text-o"></i> {{trans('pos.order_panel')}}</span>
                    </div>
                    <button id="inventory_view" type="button" class="btn btn-secondary btn-lighten-2 btn-sm round "
                            onclick="return false"><i class="ft-chevrons-left"></i> {{trans('pos.back')}}
                    </button>

                    <div class="selected_items">

                        <div>
                            <div class="p-1 text-bold-600">
                                <div class="float-left"><i
                                            class="fa fa-user-circle"></i> {{trans('customers.customer')}}</div>
                                <div class="float-right">
                                    <a class="view_invoice_config badge badge-primary white "
                                       href="javascript:void(false);"><i
                                                class="fa fa-plus-circle font-size-large"></i></a> <a
                                            class="customer_mobile_view badge badge-danger white"
                                            href="javascript:void(false);"><i
                                                class="fa fa-plus-circle font-size-large"></i></a>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="info_tab display-block">

                                <i id="pos_customer">{{$invoices->customer->name}}</i>


                            </div>
                            <div class="clear"></div>
                        </div>

                        <div>
                            <div class="p-1 text-bold-600 display-block float-left">
                                <div class="float-left"><i
                                            class="fa fa-shopping-cart"></i> {{trans('pos.cart_items')}}</div>
                                <div class="float-right">


                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="info_tab" id="empty_cart" style="display: none;">


                            </div>
                            <div class="clear"></div>
                        </div>
                        @php
                            $total_tax=0;
                        @endphp
                        @foreach($invoices->products as $product)
                            @php
                                $total_tax+=$product['total_tax'];
                            @endphp
                            <div class=item><input type="hidden" name="product_name[]" id="productname-{{$loop->index}}"
                                                   value="{{$product['product_name']}}"><input type="hidden"
                                                                                               class="form-control req prc"
                                                                                               name="product_price[]"
                                                                                               id="price-{{$loop->index}}"
                                                                                               value="{{numberFormat($product['product_price'])}}"><input
                                        type="hidden" class="form-control vat " name="product_tax[]"
                                        id="vat-{{$loop->index}}"
                                        value="{{numberFormat($product['product_tax'])}}"><input type="hidden"
                                                                                                 class="form-control discount"
                                                                                                 name="product_discount[]"
                                                                                                 id="discount-{{$loop->index}}"
                                                                                                 value="{{numberFormat($product['product_discount'])}}"><input
                                        type="hidden" name="total_tax[]" id="taxa-{{$loop->index}}"
                                        value="{{numberFormat($product['total_tax'])}}"><input type="hidden"
                                                                                               name="total_discount[]"
                                                                                               id="disca-{{$loop->index}}"
                                                                                               value="{{numberFormat($product['total_discount'])}}"><input
                                        type="hidden" class="ttInput" name="product_subtotal[]"
                                        id="total-{{$loop->index}}"
                                        value="{{numberFormat($product['product_subtotal'])}}"><input type="hidden"
                                                                                                      class="pdIn"
                                                                                                      name="product_id[]"
                                                                                                      id="pid-{{$loop->index}}"
                                                                                                      value="{{$product['product_id']}}"><input
                                        type="hidden" attr-org="" name="unit[]" id="unit-{{$loop->index}}"
                                        value="{{$product['unit']}}"><input type="hidden" name="unit_m[]"
                                                                            id="unit_m-{{$loop->index}}"
                                                                            value="{{$product['unit_value']}}"><input
                                        type="hidden" name="code[]" id="hsn-{{$loop->index}}"
                                        value="{{$product['code']}}"><input type="hidden" name="serial[]"
                                                                            id="serial-{{$loop->index}}"
                                                                            value="{{$product['serial']}}"><input
                                        type="hidden" id="alert-{{$loop->index}}" value="{{@$product->variation['qty']}}"
                                        name="alert[]">
                                <div class="remove-item"><i class="fa fa-minus-circle"></i></div>
                                <div class="name">
                                    <div class="title">{{$product['product_name']}}</div>
                                    <select class="display-inline form-control form-control-sm unit col-3 mt-1"
                                            data-uid="0" name="u_m[]" style="display: none"> </select></div>
                                <div class="quantity">{{numberFormat($product['product_price'])}}<input type="text"
                                                                                                        class="form-control req amnt display-inline mousetrap mt-1"
                                                                                                        name="product_qty[]"
                                                                                                        id="amount-{{$loop->index}}"
                                                                                                        onkeypress="return isNumber(event)"
                                                                                                        onkeyup="rowTotal({{$loop->index}}), billUpyog()"
                                                                                                        autocomplete="off"
                                                                                                        value="{{numberFormat($product['product_qty'])}}">
                                    <div class="quantity-nav mt-1">
                                        <div class="quantity-button quantity-up">+</div>
                                        <div class="quantity-button quantity-down">-</div>
                                    </div>
                                </div>
                                <div class=clear></div>
                            </div>
                            @php
                                $counter=$loop->index;
                            @endphp
                        @endforeach
                    </div>

                    <div class="bottom-section font-medium-3">
                        <div class="money">
                            {{ Form::hidden('subtotal',null,['id'=>'subttlform']) }}
                            <div class="summary-margin">{{trans('general.total_tax')}}: <span>{{config('currency.symbol')}} <span
                                            id="taxr" class="lightMode">{{numberFormat($total_tax)}}</span></span></div>
                            <div class="summary-margin">{{trans('general.total_discount')}}: <span>{{config('currency.symbol')}}   <span
                                            id="discs"
                                            class="lightMode">{{numberFormat($invoices['discount']-$invoices['extra_discount'])}}</span></span>
                            </div>
                            <div class="summary-margin">{{trans('general.total')}}: <span>{{config('currency.symbol')}} <span
                                            id="bigtotal" class="lightMode">{{numberFormat($invoices['total'])}}</span></span>
                            </div>


                            <div class="clear"></div>
                        </div>

                    </div>

                    <div class="pay_section">
                        <div id="bt_section" class="form-group text-center">
                            <a href="#" class="btn  btn-pink font-medium-5" title="Hold" data-toggle="modal"
                               data-target="#save_draft_modal"><i
                                        class="ft-watch"></i></a>
                            <a href="#" class="btn  btn-success font-medium-5" data-toggle="modal"
                               data-target="#pos_payment"><i class="ft-credit-card inline"
                                                             title="Payment"></i> {{trans('payments.payment')}}</a>
                            <a
                                    href="#" class="view_invoice_config btn btn-info font-medium-5 "
                                    title="Settings"><i
                                        class="ft-eye inline"></i></a><a href="#"
                                                                         class="customer_mobile_view btn btn-info font-medium-5"
                                                                         title="Settings"><i
                                        class="ft-eye inline"></i></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sm-footer">
            <a class="btn btn-primary  btn-block round" id="return_panel"
               onclick="return false">{{trans('pos.review_order')}}<span
                        id="total-item"></span></a>
        </div>
    </div>

    <input type="hidden" value="new_i" id="inv_page">
    <input type="hidden" name="sub" value="{{$sub}}">
    <input type="hidden" name="p" value="{{$p}}">
    <input type="hidden" value="{{$action}}" id="pos_action">
    <input type="hidden" value="{{route('biller.invoices.draft_store')}}" id="pos_action_draft">

    <input type="hidden" value="search" id="billtype">
    <input type="hidden" value="{{$counter+1}}" name="counter" id="ganak">
    <input type="hidden" value="{{$tax_format}}" name="tax_format_static" id="tax_format">
    <input type="hidden" value="{{$tax_format_type}}" name="tax_format" id="tax_format_type">
    <input type="hidden" value="{{$invoices['tax_id']}}" name="tax_id" id="tax_format_id">
    <input type="hidden" value="{{$discount_format}}"
           name="discount_format" id="discount_format">


    <input type='hidden'
           value='{{numberFormat($invoices['ship_tax_rate'])}}'
           name='ship_rate' id='ship_rate'><input
            type='hidden' value='{{$invoices['ship_tax_type']}}' name='ship_tax_type'
            id='ship_taxtype'>

    <input type="hidden" value="{{numberFormat($invoices['ship_tax'])}}" name="ship_tax" id="ship_tax">
    <input type="hidden" value="0" id="custom_discount">
    <input type="hidden" name="total" class="form-control"
           id="invoiceyoghtml" readonly="" value="{{numberFormat($invoices['total'])}}">
    <input type="hidden" value="{{$invoices['id']}}" name="id">
    <input type="hidden" value="{{numberFormat($invoices['pamnt'])}}" name="paid_amount" id="paid_amount">
@include("focus.modal.pos_payment")
    </form>
    @include("focus.modal.pos_save_draft")
    @include("focus.modal.customer")
    @include("focus.modal.pos_stock")
    @include("focus.modal.pos_print")
    @include("focus.modal.pos_register")
    @include("focus.modal.pos_close_register")

@endsection

@section('extra-scripts')

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('#date1').datepicker('setDate', '{{dateFormat($invoices['invoicedate'])}}');
            $('#date2').datepicker('setDate', '{{dateFormat($invoices['invoiceduedate'])}}');
            $('form input').keydown(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });
            $('#keyword').keyup(delay(function (e) {
                if (this.value.length > 2) load_pos($(this).val());
            }, 500));
            if (typeof unit_load === "function") {
                unit_load();
                $('.unit').show();
            }
        });

        $(document).on('click', '.payment_row_add', function (e) {

            $("#amount_row").append($("#payment_row").clone());
            update_pay_pos();

        });
  $(document).on('change', '#s_warehouses', function (e) {
                 load_pos();
                });
                 $(document).on('change', '#s_category', function (e) {
                 load_pos();
                });

        $("#pos_payment").on("show.bs.modal", function (e) {
            var paid_pos = accounting.unformat($('#paid_amount').val(), accounting.settings.number.decimal);
            var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
            var due = parseFloat(ttl_pos - paid_pos).toFixed(two_fixed);
            if (due >= 0) {
                $('.p_amount').val(due);
                $('#mahayog').html(due);
            } else {
                $('.p_amount').val(0);
                $('#mahayog').html(0);
            }

            update_pay_pos();
        });

        function update_pay_pos() {
            var am_pos = 0;
            var paid_pos = accounting.unformat($('#paid_amount').val(), accounting.settings.number.decimal);
            $('.p_amount').each(function () {
                if (this.value > 0) am_pos = am_pos + accounting.unformat(this.value, accounting.settings.number.decimal);
            });

            var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);


                <?php
                $round_off = false;
                if ($round_off == 'PHP_ROUND_HALF_UP') {
                    echo ' ttl_pos=Math.ceil(ttl_pos);';
                } elseif ($round_off == 'PHP_ROUND_HALF_DOWN') {
                    echo ' ttl_pos=Math.floor(ttl_pos);';
                }
                ?>

            var due = parseFloat(ttl_pos - am_pos - paid_pos).toFixed(2);
            if (due >= 0) {
                $('#balance1').val(accounting.formatNumber(due));
                $('#change_p').val(0);
            } else {
                due = due * (-1)
                $('#balance1').val(0);
                $('#change_p').val(accounting.formatNumber(due));
            }

        }

        function trigger(data) {
            @if(!feature(19)->feature_value)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.pos.browser_print')}}',
                dataType: "html",
                method: 'get',
                data: 'id=' + data.d_id,
                success: function (data) {
                    $('#print_section').html(data);
                     $('#pos_print').modal('toggle');
            $("#print_section").printThis({
                //  beforePrint: function (e) {$('#pos_print').modal('hide');},
                afterPrint: null,
                printDelay: 500,
            });
                }
            });

            @endif
        }

        @php
            $pmt= payment_methods();
      array_push($pmt, "Change");
        @endphp
        function loadRegister(show = true) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.register.load')}}',
                dataType: "json",
                method: 'get',
                success: function (data) {
                    $('#register_items').html('@foreach($pmt as $row)<div class="col-6"><div class="form-group  text-bold-600 green"><label for="' + data.pm_{{$loop->iteration}}+ '">{{$row}}</label><input type="text" class="form-control green" id="' + data.pm_{{$loop->iteration}}+ '" value="' + data.pm_{{$loop->iteration}}+ '" readonly="" ></div></div>@endforeach');
                    $('#r_date').html(data.open)
                }
            });

            if (show) $('#pos_register').modal('toggle');
        }

        function print_it() {
            $("#print_section").printThis({
                afterPrint: null
            });
        }
    </script>
@endsection
