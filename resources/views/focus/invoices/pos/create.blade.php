@extends ('core.layouts.pos_app')

@section ('title', trans('pos.sale'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.invoices.management') }}
        <small>{{ trans('labels.backend.invoices.create') }}</small>
    </h1>
@endsection

@section('content')
    <form id="data_form">
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
                                <div class="text-center blue font-large-2" id="p_loader"><i
                                            class="fa fa-cube spinner"></i></div>
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

                                <a class="btn  btn-lighten-2 btn-red round" data-toggle="modal"
                                        data-target="#addCustomer"><i
                                            class="ft-plus-circle font-medium-3"></i></a>

                            </div>
                        </div>

                        <div id="customer-box-result"></div>
                        {{ Form::hidden('customer_id', @$customer->id,['id'=>'customer_id']) }}
                        <div id="customer" style="display: none;">
                            <div class="border p-1">
                                <div class="clientinfo">
                                    <div id="customer_name"></div>
                                </div>

                                <div class="clientinfo">
                                    <div id="customer_phone"></div>
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
                                                                                            value="0"
                                                                                            onkeyup="billUpyog()">
                                <input type="hidden"
                                       name="after_disc" id="after_disc" value="0">
                                ( {{config('currency.symbol')}}
                                <span id="disc_final">0</span> )

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
                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                            - {{$currency->code}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="col-6">   @if(isset($employees[0])) {{trans('general.employee')}}
                                <select name="user_id"
                                                            class="selectpicker form-control">
                                                        <option value="{{$logged_in_user->id}}">{{$logged_in_user->first_name}}</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->id}}">{{$employee->first_name}}
                                                                {{$employee->last_name}}</option>
                                                        @endforeach

                                                    </select>
                         @endif   </div>  <div class="col-12 mt-2"></div><div class="col-6">{{trans('general.payment_terms')}} <select name="term_id"
                                                                                          class="selectpicker form-control">
                                    @foreach($terms as $term)
                                        <option value="{{$term->id}}">{{$term->title}}</option>
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
                                        {{ Form::number('tid', @$last_invoice->tid+1, ['class' => 'form-control round', 'placeholder' => trans('invoices.tid')]) }}
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
                                        {{ Form::text('invoicedate', null, ['class' => 'form-control round required', 'placeholder' => trans('invoices.invoice_date'),'data-toggle'=>'datepicker','autocomplete'=>'false']) }}
                                    </div>
                                </div>

                                <div class="col-sm-6"><label for="invocieduedate"
                                                             class="caption">{{trans('invoices.invoice_due_date')}}</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                             aria-hidden="true"></span>
                                        </div>

                                        {{ Form::text('invoiceduedate', null, ['class' => 'form-control round required', 'placeholder' => trans('invoices.invoice_due_date'),'data-toggle'=>'datepicker','autocomplete'=>'false']) }}
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
                                        @endphp
                                        @foreach($additionals as $additional_tax)

                                            @php
                                                if($additional_tax->id == $defaults[4][0]['feature_value']  && $additional_tax->class == 1){
                                                 echo '<option value="'.numberFormat($additional_tax->value).'" data-type1="'.$additional_tax->type1.'" data-type2="'.$additional_tax->type2.'" data-type3="'.$additional_tax->type3.'" data-type4="'.$additional_tax->id.'" selected>--'.$additional_tax->name.'--</option>';
                                                 $tax_format=$additional_tax->type2;
                                                 $tax_format_id=$additional_tax->id;
                                                 $tax_format_type=$additional_tax->type3;
                                                }

                                            @endphp
                                            {!! $additional_tax->class == 1 ? "<option value='".numberFormat($additional_tax->value)."' data-type1='$additional_tax->type1' data-type2='$additional_tax->type2' data-type3='$additional_tax->type3' data-type4='$additional_tax->id'>$additional_tax->name</option>" : "" !!}
                                        @endforeach

                                        <option value="0" data-type1="%" data-type2="off"
                                                data-type3="off"  @if(!$tax_format_id) selected @endif>{{trans('general.off')}}</option>
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
                                                    if($defaults[3][0]['feature_value'] == $additional_discount->id && $additional_discount->class == 2){
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
                                        ><i
                                                    class="fa fa-plus-circle font-size-large"></i></a> <a
                                                class="customer_mobile_view badge badge-danger white"
                                                href="javascript:void(false);"><i
                                                    class="fa fa-plus-circle font-size-large"></i></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="info_tab display-block">

                                    <i id="pos_customer">{{trans('business.default')}} - {{$customer->name}}</i>


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
                                <div class="info_tab" id="empty_cart">

                                    <i>{{trans('pos.empty_cart')}}</i>


                                </div>
                                <div class="clear"></div>
                            </div>


                        </div>

                        <div class="bottom-section font-medium-3">
                            <div class="money">
                                {{ Form::hidden('subtotal','0',['id'=>'subttlform']) }}
                                <div class="summary-margin">{{trans('general.total_tax')}}: <span>{{config('currency.symbol')}} <span
                                                id="taxr" class="lightMode">0</span></span></div>
                                <div class="summary-margin">{{trans('general.total_discount')}}: <span>{{config('currency.symbol')}}   <span
                                                id="discs" class="lightMode">0</span></span></div>
                                <div class="summary-margin">{{trans('general.total')}}: <span>{{config('currency.symbol')}} <span
                                                id="bigtotal" class="lightMode">0</span></span></div>


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
        <input type="hidden" value="{{route('biller.invoices.pos_store')}}" id="pos_action">
        <input type="hidden" value="{{route('biller.invoices.draft_store')}}" id="pos_action_draft">
        <input type="hidden" value="search" id="billtype">
        <input type="hidden" value="0" name="counter" id="ganak">
        <input type="hidden" value="{{$tax_format}}" name="tax_format_static" id="tax_format">
        <input type="hidden" value="{{$tax_format_type}}" name="tax_format" id="tax_format_type">
        <input type="hidden" value="{{$tax_format_id}}" name="tax_id" id="tax_format_id">
        <input type="hidden" value="{{$discount_format}}"
               name="discount_format" id="discount_format">

        @if(isset($defaults[4][0]->ship_tax['id']) && $defaults[4][0]->ship_tax['id']>0) <input type='hidden'
                                                      value='{{numberFormat($defaults[4][0]->ship_tax['value'])}}'
                                                      name='ship_rate' id='ship_rate'><input
                type='hidden' value='{{$defaults[4][0]->ship_tax['type2']}}'
                name='ship_tax_type'
                id='ship_taxtype'>
        @else
            <input type='hidden'
                   value='{{numberFormat(0)}}'
                   name='ship_rate' id='ship_rate'><input
                    type='hidden' value='none' name='ship_tax_type'
                    id='ship_taxtype'>
        @endif
        <input type="hidden" value="0" name="ship_tax" id="ship_tax">
        <input type="hidden" value="0" id="custom_discount">
        <input type="hidden" name="total" class="form-control"
               id="invoiceyoghtml" readonly="">
        <input type="hidden" value="0" name="paid_amount" id="paid_amount">
        <audio id="beep" src="{{route('biller.index')}}/core/beep.mp3" autoplay="false"></audio>
        @include("focus.modal.pos_payment")
        {{ Form::close() }}
        @include("focus.modal.customer")
        @include("focus.modal.pos_stock")
        @include("focus.modal.pos_print")
        @include("focus.modal.pos_register")
        @include("focus.modal.pos_close_register")
        @include("focus.modal.pos_save_draft")
        @endsection
        @section('extra-scripts')
            <script type="text/javascript">
                $(function () {

                    $('#pos_basic_pay_no').on("click", function (e) {
                        e.preventDefault();
                        if ($("#notify").length == 0) {
                            $("#c_body").html('<div id="notify" class="alert m-1" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
                        }
                        $('#pos_payment').modal('toggle');
                        $("#notify .message").html("<strong>Processing</strong>: .....");
                        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
                        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
                        var o_data = [];
                        o_data['form'] = $("#data_form").serialize();
                        o_data['url'] = $('#pos_action').val();
                        addObject(o_data);
                    });





                    $('[data-toggle="datepicker"]').datepicker({
                        autoHide: true,
                        format: '{{config('core.user_date_format')}}'
                    });
                    $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
                    $('form input').keydown(function (e) {
                        if (e.keyCode == 13) {
                            e.preventDefault();
                            return false;
                        }
                    });
                    $('#keyword').keyup(delay(function (e) {
                        if (this.value.length > 2) load_pos($(this).val());
                    }, 500));
                    var sound = document.getElementById("beep");
                    sound.play();
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
                    $('.p_amount').val($('#invoiceyoghtml').val());
                    update_pay_pos();
                });

                $("#save_draft").on("show.bs.modal", function (e) {

                });

                function update_pay_pos() {
                    var am_pos = 0;
                    $('.p_amount').each(function () {
                        var p_v=accounting.unformat(this.value, accounting.settings.number.decimal)
                        if (p_v > 0) am_pos = am_pos + p_v;
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
                    var due = ttl_pos - am_pos
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
                    check = $("#no_print").val();

                    if(check) {

                    } else {

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
                                    printDelay: 500,
                                    afterPrint: null
                                });
                            }
                        });
                    }

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
                        printDelay: 333,
                        afterPrint: null,
                    });
                }
            </script>
@endsection
