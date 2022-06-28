@extends ('core.layouts.app')

@section ('title', $words['title'])

@section('page-header')
    <h1>
        {{ trans('labels.backend.invoices.management') }}
        <small>{{ trans('labels.backend.invoices.edit') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            {{ Form::model($orders, [ 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT', 'id' => 'data_form','files'=>true]) }}

                            <div class="row">
                                <div class="col-sm-6 cmp-pnl">
                                    <div id="customerpanel" class="inner-cmp-pnl">
                                        <div class="form-group row">
                                            <div class="fcol-sm-12">
                                                <h3 class="title">{{$words['bill_to_from']}} <a href='#'
                                                                                                class="btn btn-primary btn-sm round"
                                                                                                data-toggle="modal"
                                                                                                data-target="#addCustomer">
                                                        {{$words['add_person']}}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="frmSearch col-sm-12">
                                                {{ Form::label( 'cst',$words['search_person'],['class' => 'caption']) }}
                                                {{ Form::text('cst', null, ['class' => 'form-control round', 'placeholder' =>trans('invoices.enter_customer'), 'id'=>'customer-box','autocomplete'=>'off']) }}
                                                <div id="customer-box-result"></div>
                                            </div>
                                        </div>
                                        <div id="customer">
                                            <div class="clientinfo">{{$words['person_details']}}
                                                <hr>
                                                <div id="customer_name">{{$orders->customer->name}}</div>
                                            </div>
                                            <div class="clientinfo">
                                                <div id="customer_address1">{{$orders->customer->address}}
                                                    , {{$orders->customer->city}}</div>
                                            </div>
                                            <div class="clientinfo">
                                                <div id="customer_phone">{{$orders->customer->phone}}</div>
                                            </div>
                                            <hr>
                                            <div id="customer_pass"></div>
                                            <hr>
                                        </div>{{trans('warehouses.warehouse')}}<select
                                                id="s_warehouses"
                                                class="form-control round mt-1">
                                            <option value="0">{{trans('general.all')}}</option>
                                            @foreach($warehouses as $warehouses)
                                                <option value="{{$warehouses->id}}" {{$warehouses->id==@$defaults[1][0]['feature_value'] ? 'selected' : ''}}>{{$warehouses->title}}</option>
                                            @endforeach
                                        </select>

                                        {{ Form::hidden('customer_id', $orders['customer_id'],['id'=>'customer_id']) }}
                                    </div>
                                </div>
                                <div class="col-sm-6 cmp-pnl">
                                    <div class="inner-cmp-pnl">


                                        <div class="form-group row">

                                            <div class="col-sm-12"><h3
                                                        class="title">{{$words['properties']}}</h3>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6"><label for="invocieno"
                                                                         class="caption">{{trans('general.serial_no')}}
                                                    #{{$words['prefix']}}</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                         aria-hidden="true"></span>
                                                    </div>

                                                    {{ Form::number('tid',null, ['class' => 'form-control round', 'placeholder' => trans('general.serial_no'),'readonly'=>'']) }}
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
                                        <div class="form-group row">

                                            <div class="col-sm-6"><label for="invociedate"
                                                                         class="caption">{{trans('general.date')}}</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-calendar4"
                                                                                         aria-hidden="true"></span>
                                                    </div>
                                                    {{ Form::text('invoicedate','', ['class' => 'form-control round required', 'placeholder' => trans('general.date'),'data-toggle'=>'datepicker','autocomplete'=>'false','id'=>'date1']) }}
                                                </div>
                                            </div>
                                            <div class="col-sm-6"><label for="invocieduedate"
                                                                         class="caption">{{trans('general.due_date')}}</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                         aria-hidden="true"></span>
                                                    </div>

                                                    {{ Form::text('invoiceduedate', date_for_database($orders['invoiceduedate']), ['class' => 'form-control round required', 'placeholder' => trans('general.due_date'),'data-toggle'=>'datepicker','autocomplete'=>'false','id'=>'date2']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
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
                                                            if($additional_tax->id == $orders['tax_id']  && $additional_tax->class == 1 && $tax_flag){
                                                             echo '<option value="'.numberFormat($additional_tax->value).'" data-type1="'.$additional_tax->type1.'" data-type2="'.$additional_tax->type2.'" data-type3="'.$additional_tax->type3.'" data-type4="'.$additional_tax->id.'" selected>--'.$additional_tax->name.'--</option>';
                                                             $tax_format=$additional_tax->type2;
                                                             $tax_flag=false;
                                                             $tax_format_type=$additional_tax->type3;

                                                            }

                                                        @endphp
                                                        {!! $additional_tax->class == 1 ? "<option value='".numberFormat($additional_tax->value)."' data-type1='$additional_tax->type1' data-type2='$additional_tax->type2' data-type3='$additional_tax->type3' data-type4='$additional_tax->id'>$additional_tax->name</option>" : "" !!}
                                                    @endforeach

                                                    <option value="0.0000" data-type1="%" data-type2="off"
                                                            data-type3="off">{{trans('general.off')}}</option>
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
                                                                if($additional_discount->type1== $orders['discount_format'] && $additional_discount->class == 2){
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
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="toAddInfo"
                                                       class="caption">{{trans('general.note')}}</label>

                                                {{ Form::textarea('notes', null, ['class' => 'form-control round', 'placeholder' => trans('general.note'),'rows'=>'2']) }}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div id="saman-row">
                                <table class="table-responsive tfr my_stripe">

                                    <thead>
                                    <tr class="item_header bg-gradient-directional-blue white">
                                        <th width="30%" class="text-center">{{trans('general.item_name')}}</th>
                                        <th width="8%" class="text-center">{{trans('general.quantity')}}</th>
                                        <th width="10%" class="text-center">{{trans('general.rate')}}</th>
                                        <th width="10%" class="text-center">{{trans('general.tax_p')}}</th>
                                        <th width="10%" class="text-center">{{trans('general.tax')}}</th>
                                        <th width="7%" class="text-center">{{trans('general.discount')}}</th>
                                        <th width="10%" class="text-center">{{trans('general.amount')}}
                                            ({{config('currency.symbol')}})
                                        </th>
                                        <th width="5%" class="text-center">{{trans('general.action')}}</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @php
                                        $total_tax=0;
                                    @endphp
                                    @foreach($orders->products as $product)

                                        @php
                                            $total_tax+=$product['total_tax'];
                                        @endphp
                                        <tr data-re="1">
                                            <td><input type="text" class="form-control" name="product_name[]"
                                                       placeholder="{{trans('general.enter_product')}}"
                                                       id='productname-{{$loop->index}}'
                                                       value="{{$product['product_name']}}">
                                            </td>
                                            <td><input type="text" class="form-control req amnt" name="product_qty[]"
                                                       id="amount-{{$loop->index}}"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('{{$loop->index}}'), billUpyog()"
                                                       autocomplete="off"
                                                       value="{{numberFormat($product['product_qty'])}}"><input
                                                        type="hidden" id="alert-{{$loop->index}}"
                                                        value="{{@$product->product['alert']}}"
                                                        name="alert[]"><input type="hidden"
                                                                              id="amount_old-{{$loop->index}}"
                                                                              value="{{numberFormat($product['product_qty'])}}"
                                                                              name="old_product_qty[]"></td>
                                            <td><input type="text" class="form-control req prc" name="product_price[]"
                                                       id="price-{{$loop->index}}"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('{{$loop->index}}'), billUpyog()"
                                                       autocomplete="off"
                                                       value="{{numberFormat($product['product_price'])}}"></td>
                                            <td><input type="text" class="form-control vat " name="product_tax[]"
                                                       id="vat-{{$loop->index}}"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('{{$loop->index}}'), billUpyog()"
                                                       autocomplete="off"
                                                       value="{{numberFormat($product['product_tax'])}}"></td>
                                            <td class="text-center"
                                                id="texttaxa-{{$loop->index}}">{{numberFormat($product['total_tax'])}}</td>
                                            <td><input type="text" class="form-control discount"
                                                       name="product_discount[]"
                                                       onkeypress="return isNumber(event)"
                                                       id="discount-{{$loop->index}}"
                                                       onkeyup="rowTotal('{{$loop->index}}'), billUpyog()"
                                                       autocomplete="off"
                                                       value="{{numberFormat($product['product_discount'])}}"></td>
                                            <td><span class="currenty">{{config('currency.symbol')}}</span>
                                                <strong><span class='ttlText'
                                                              id="result-{{$loop->index}}">{{numberFormat($product['product_subtotal'])}}</span></strong>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" data-rowid="{{$loop->index}}"
                                                        class="btn btn-danger removeProd" title="Remove"><i
                                                            class="fa fa-minus-square"></i></button>
                                            </td>
                                            <input type="hidden" name="total_tax[]" id="taxa-{{$loop->index}}"
                                                   value="{{numberFormat($product['total_tax'])}}">
                                            <input type="hidden" name="total_discount[]" id="disca-{{$loop->index}}"
                                                   value="{{numberFormat($product['total_discount'])}}">
                                            <input type="hidden" class="ttInput" name="product_subtotal[]"
                                                   id="total-{{$loop->index}}"
                                                   value="{{numberFormat($product['product_subtotal'])}}">
                                            <input type="hidden" class="pdIn" name="product_id[]"
                                                   id="pid-{{$loop->index}}" value="{{$product['product_id']}}">
                                            <input type="hidden" name="unit[]" id="unit-{{$loop->index}}"
                                                   value="{{$product['unit']}}">
                                            <input type="hidden" name="code[]" id="hsn-{{$loop->index}}"
                                                   value="{{$product['code']}}">
                                        </tr>

                                        <tr>
                                            <td colspan="8"><textarea id="dpid-{{$loop->index}}" class="form-control"
                                                                      name="product_description[]"
                                                                      placeholder="{{trans('general.enter_description')}} (Optional)"
                                                                      autocomplete="off">{{$product['product_des']}}</textarea><br>
                                            </td>
                                        </tr>
                                        @php
                                            $counter=$loop->index;
                                        @endphp
                                    @endforeach
                                    <tr class="last-item-row sub_c">
                                        <td class="add-row">
                                            <button type="button" class="btn btn-success" aria-label="Left Align"
                                                    id="addproduct">
                                                <i class="fa fa-plus-square"></i> {{trans('general.add_row')}}
                                            </button>
                                        </td>
                                        <td colspan="7"></td>
                                    </tr>

                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="6"
                                            align="right">{{ Form::hidden('subtotal',null,['id'=>'subttlform']) }}
                                            <strong>{{trans('general.total_tax')}}</strong>
                                        </td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode">{{config('currency.symbol')}}</span>
                                            <span id="taxr" class="lightMode">{{numberFormat($total_tax)}}</span></td>
                                    </tr>
                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="6" align="right">
                                            <strong>{{trans('general.total_discount')}}</strong></td>
                                        <td align="left" colspan="2"><span
                                                    class="currenty lightMode"></span>
                                            <span id="discs"
                                                  class="lightMode">{{numberFormat($orders['discount']-$orders['extra_discount'])}}</span>
                                        </td>
                                    </tr>

                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="6" align="right">
                                            <strong>{{trans('general.shipping')}}</strong></td>
                                        <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                            onkeypress="return isNumber(event)"
                                                                            placeholder="Value"
                                                                            name="shipping" autocomplete="off"
                                                                            onkeyup="billUpyog()"
                                                                            value="{{numberFormat($orders['shipping'])}}">
                                            ( {{trans('general.tax')}} {{config('currency.symbol')}}
                                            <span id="ship_final">{{numberFormat($orders['ship_tax'])}}</span> )
                                        </td>
                                    </tr>
                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="6" align="right">
                                            <strong> {{trans('general.extra_discount')}}</strong>
                                        </td>
                                        <td align="left" colspan="2"><input type="text"
                                                                            class="form-control form-control-sm discVal"
                                                                            onkeypress="return isNumber(event)"
                                                                            placeholder="Value"
                                                                            name="discount_rate" autocomplete="off"
                                                                            value="{{numberFormat($orders['discount_rate'])}}"
                                                                            onkeyup="billUpyog()">
                                            <input type="hidden"
                                                   name="after_disc" id="after_disc"
                                                   value="{{numberFormat($orders['extra_discount'])}}">
                                            ( {{config('currency.symbol')}}
                                            <span id="disc_final">{{numberFormat($orders['extra_discount'])}}</span> )
                                        </td>
                                    </tr>


                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="2">{{trans('general.payment_currency_client')}}
                                            <small>{{trans('general.based_live_market')}}</small>
                                            <select name="currency"
                                                    class="selectpicker form-control">
                                                <option value="0">Default</option>
                                                @foreach($currencies as $currency)
                                                    <option value="{{$currency->id}}" {{$currency->id==$orders['currency'] ? 'selected' : ''}}>{{$currency->symbol}}
                                                        - {{$currency->code}}</option>
                                                @endforeach

                                            </select></td>
                                        <td colspan="4" align="right"><strong>{{trans('general.grand_total')}}
                                                (<span
                                                        class="currenty lightMode">{{config('currency.symbol')}}</span>)</strong>
                                        </td>
                                        <td align="left" colspan="2"><input type="text" name="total"
                                                                            class="form-control"
                                                                            value="{{numberFormat($orders['total'])}}"
                                                                            id="invoiceyoghtml" readonly="">

                                        </td>
                                    </tr>
                                    <tr class="sub_c" style="display: table-row;">
                                        <td colspan="2">{{trans('general.payment_terms')}} <select name="term_id"
                                                                                                   class="selectpicker form-control">
                                                @foreach($terms as $term)
                                                    <option value="{{$term->id}}" {{$term->id==$orders['term_id'] ? 'selected' : ''}} >
                                                        --{{$term->title}}--
                                                    </option>
                                                @endforeach

                                            </select></td>
                                        <td align="right" colspan="6"><input type="submit"
                                                                             class="btn btn-success sub-btn btn-lg"
                                                                             value="{{trans('general.generate')}}"
                                                                             id="submit-data"
                                                                             data-loading-text="Creating...">

                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-12">{!! $fields_data !!}</div>
                                </div>
                            </div>
                            <input type="hidden" value="new_i" id="inv_page">
                            <input type="hidden" value="{{route('biller.orders.update',$orders['id'])}}"
                                   id="action-url">
                            <input type="hidden" value="search" id="billtype">
                            <input type="hidden" value="{{$counter}}" name="counter" id="ganak">
                            <input type="hidden" value="{{$tax_format}}" name="tax_format_static" id="tax_format">
                            <input type="hidden" value="{{$tax_format_type}}" name="tax_format" id="tax_format_type">
                            <input type="hidden" value="{{$orders['tax_id']}}" name="tax_id" id="tax_format_id">
                            <input type="hidden" value="{{$discount_format}}" name="discount_format"
                                   id="discount_format">

                            <input type='hidden' value='{{numberFormat($orders['ship_tax_rate'])}}'
                                   name='ship_rate' id='ship_rate'><input
                                    type='hidden' value='{{$orders['ship_tax_type']}}' name='ship_tax_type'
                                    id='ship_taxtype'>
                            <input type="hidden" value="0" id="custom_discount">
                            <input type="hidden" value="{{numberFormat($orders['ship_tax'])}}" name="ship_tax"
                                   id="ship_tax">
                            <input type="hidden" value="{{$orders['id']}}" name="id">

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    @include("focus.modal.customer")
@section('extra-scripts')
    <script type="text/javascript">
  $(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('#date1').datepicker('setDate', '{{dateFormat($orders['invoicedate'])}}');
            $('#date2').datepicker('setDate', '{{dateFormat($orders['invoiceduedate'])}}');
            editor();
        });
    </script>
@endsection
@endsection
