@extends ('core.layouts.app')

@section ('title', $words['title'])

@section('page-header')
    <h1>
        {{ trans('labels.backend.orders.management') }}
        <small>{{ trans('labels.backend.orders.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form method="post" id="data_form">
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
                                                    {{ Form::text('cst', null, ['class' => 'form-control round user-box', 'placeholder' =>$words['enter_person'], 'data-section'=>$words['section_person'],'id'=>$words['section_person'].'-box','autocomplete'=>'off']) }}
                                                    <div id="{{$words['section_person']}}-box-result"></div>
                                                </div>
                                            </div>
                                            <div id="customer">
                                                <div class="clientinfo">{{$words['person_details']}}
                                                    <hr>
                                                    <div id="customer_name"></div>
                                                </div>
                                                <div class="clientinfo">
                                                    <div id="customer_address1"></div>
                                                </div>
                                                <div class="clientinfo">
                                                    <div id="customer_phone"></div>
                                                </div>
                                                <hr>
                                                <div id="customer_pass"></div>
                                                <hr>
                                            </div>{{trans('warehouses.warehouse')}}<select
                                                    id="s_warehouses"
                                                    class="form-control round mt-1">
                                                <option value="0">{{trans('general.all')}}</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{$warehouse->id}}" {{$warehouse->id==@$defaults[1][0]['feature_value'] ? 'selected' : ''}}>{{$warehouse->title}}</option>
                                                @endforeach
                                            </select>

                                            {{ Form::hidden('customer_id', '0',['id'=>'customer_id']) }}
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
                                                        <div class="input-group-addon"><span class="fa fa-list"
                                                                                             aria-hidden="true"></span>
                                                        </div>

                                                        {{ Form::number('tid', @$last_invoice->tid+1, ['class' => 'form-control round', 'placeholder' => trans('general.serial_no')]) }}
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
                                                        {{ Form::text('invoicedate', null, ['class' => 'form-control round required', 'placeholder' => trans('general.date'),'data-toggle'=>'datepicker','autocomplete'=>'false']) }}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6"><label for="invocieduedate"
                                                                             class="caption">{{trans('general.due_date')}}</label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>

                                                        {{ Form::text('invoiceduedate', null, ['class' => 'form-control round required', 'placeholder' => trans('general.due_date'),'data-toggle'=>'datepicker','autocomplete'=>'false']) }}
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
                                                        @endphp
                                                        @foreach($additionals as $additional_tax)

                                                            @php
                                                                if($additional_tax->id == @$defaults[4][0]['feature_value']  && $additional_tax->class == 1){
                                                                 echo '<option value="'.numberFormat($additional_tax->value).'" data-type1="'.$additional_tax->type1.'" data-type2="'.$additional_tax->type2.'" data-type3="'.$additional_tax->type3.'" data-type4="'.$additional_tax->id.'" selected>--'.$additional_tax->name.'--</option>';
                                                                 $tax_format=$additional_tax->type2;
                                                                 $tax_format_id=$additional_tax->id;
                                                                   $tax_format_type=$additional_tax->type3;
                                                                }

                                                            @endphp
                                                            {!! $additional_tax->class == 1 ? "<option value='".numberFormat($additional_tax->value)."' data-type1='$additional_tax->type1' data-type2='$additional_tax->type2' data-type3='$additional_tax->type3' data-type4='$additional_tax->id'>$additional_tax->name</option>" : "" !!}
                                                        @endforeach

                                                        <option value="0" data-type1="%" data-type2="off"
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
                                                                    if(@$defaults[3][0]['feature_value'] == $additional_discount->id && $additional_discount->class == 2){
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
                                        <tr>
                                            <td><input type="text" class="form-control" name="product_name[]"
                                                       placeholder="{{trans('general.enter_product')}}"
                                                       id='productname-0'>
                                            </td>
                                            <td><input type="text" class="form-control req amnt" name="product_qty[]"
                                                       id="amount-0"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('0'), billUpyog()"
                                                       autocomplete="off" value="1"><input type="hidden" id="alert-0"
                                                                                           value=""
                                                                                           name="alert[]"></td>
                                            <td><input type="text" class="form-control req prc" name="product_price[]"
                                                       id="price-0"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('0'), billUpyog()"
                                                       autocomplete="off"></td>
                                            <td><input type="text" class="form-control vat " name="product_tax[]"
                                                       id="vat-0"
                                                       onkeypress="return isNumber(event)"
                                                       onkeyup="rowTotal('0'), billUpyog()"
                                                       autocomplete="off"></td>
                                            <td class="text-center" id="texttaxa-0">0</td>
                                            <td><input type="text" class="form-control discount"
                                                       name="product_discount[]"
                                                       onkeypress="return isNumber(event)" id="discount-0"
                                                       onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                            <td><span class="currenty">{{config('currency.symbol')}}</span>
                                                <strong><span class='ttlText' id="result-0">0</span></strong></td>
                                            <td class="text-center">

                                            </td>
                                            <input type="hidden" name="total_tax[]" id="taxa-0" value="0">
                                            <input type="hidden" name="total_discount[]" id="disca-0" value="0">
                                            <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0"
                                                   value="0">
                                            <input type="hidden" class="pdIn" name="product_id[]" id="pid-0" value="0">
                                            <input type="hidden" name="unit[]" id="unit-0" value="">
                                            <input type="hidden" name="code[]" id="hsn-0" value="">
                                            <input type="hidden" name="type_bill" value="{{$words['m_id']}}">
                                        </tr>
                                        <tr>
                                            <td colspan="6"><textarea id="dpid-0" class="form-control html_editor"
                                                                      name="product_description[]"
                                                                      placeholder="{{trans('general.enter_description')}} (Optional)"
                                                                      autocomplete="off"></textarea><br></td>
                                            <td colspan="2"><select class="form-control unit" data-uid="0" name="u_m[]"
                                                                    style="display: none">

                                                </select></td>
                                        </tr>

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
                                                align="right">{{ Form::hidden('subtotal','0',['id'=>'subttlform']) }}
                                                <strong>{{trans('general.total_tax')}}</strong>
                                            </td>
                                            <td align="left" colspan="2"><span
                                                        class="currenty lightMode">{{config('currency.symbol')}}</span>
                                                <span id="taxr" class="lightMode">0</span></td>
                                        </tr>
                                        <tr class="sub_c" style="display: table-row;">
                                            <td colspan="6" align="right">
                                                <strong>{{trans('general.total_discount')}}</strong></td>
                                            <td align="left" colspan="2"><span
                                                        class="currenty lightMode"></span>
                                                <span id="discs" class="lightMode">0</span></td>
                                        </tr>

                                        <tr class="sub_c" style="display: table-row;">
                                            <td colspan="6" align="right">
                                                <strong>{{trans('general.shipping')}}</strong></td>
                                            <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                                onkeypress="return isNumber(event)"
                                                                                placeholder="Value"
                                                                                name="shipping" autocomplete="off"
                                                                                onkeyup="billUpyog()">
                                                ( {{trans('general.tax')}} {{config('currency.symbol')}}
                                                <span id="ship_final">0</span> )
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
                                                                                value="0"
                                                                                onkeyup="billUpyog()">
                                                <input type="hidden"
                                                       name="after_disc" id="after_disc" value="0">
                                                ( {{config('currency.symbol')}}
                                                <span id="disc_final">0</span> )
                                            </td>
                                        </tr>


                                        <tr class="sub_c" style="display: table-row;">
                                            <td colspan="2">{{trans('general.payment_currency_client')}}
                                                <small>{{trans('general.based_live_market')}}</small>
                                                <select name="currency"
                                                        class="selectpicker form-control">
                                                    <option value="0">Default</option>
                                                    @foreach($currencies as $currency)
                                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                                            - {{$currency->code}}</option>
                                                    @endforeach

                                                </select></td>
                                            <td colspan="4" align="right"><strong>{{trans('general.grand_total')}}
                                                    (<span
                                                            class="currenty lightMode">{{config('currency.symbol')}}</span>)</strong>
                                            </td>
                                            <td align="left" colspan="2"><input type="text" name="total"
                                                                                class="form-control"
                                                                                id="invoiceyoghtml" readonly="">

                                            </td>
                                        </tr>
                                        <tr class="sub_c" style="display: table-row;">
                                            <td colspan="2">{{trans('general.payment_terms')}} <select name="term_id"
                                                                                                       class="selectpicker form-control">
                                                    @foreach($terms as $term)
                                                        <option value="{{$term->id}}">{{$term->title}}</option>
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
                                        <div class="col-12">{!! $fields !!}</div>
                                    </div>
                                </div>

                                <input type="hidden" value="new_i" id="inv_page">
                                <input type="hidden" value="{{route('biller.orders.store')}}" id="action-url">
                                <input type="hidden" value="search" id="billtype">
                                <input type="hidden" value="0" name="counter" id="ganak">
                                <input type="hidden" value="{{$tax_format}}" name="tax_format_static" id="tax_format">
                                <input type="hidden" value="{{$tax_format_type}}" name="tax_format"
                                       id="tax_format_type">
                                <input type="hidden" value="{{$tax_format_id}}" name="tax_id" id="tax_format_id">
                                <input type="hidden" value="{{$discount_format}}"
                                       name="discount_format" id="discount_format">

                                @if(@$defaults[4][0]->ship_tax['id']>0) <input type='hidden'
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

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($words['m_id']==2 )
        @include("focus.modal.customer")
    @else
        @include("focus.modal.supplier")
    @endif
@endsection
@section('extra-scripts')
    <script type="text/javascript">

           $(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
            editor();
        });
    </script>
@endsection
