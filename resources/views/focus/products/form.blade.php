<div class="form-group">

    <div class='col-lg-10'>
        {{trans('products.general_product_details')}}
    </div>
</div>


<div class="row">
    <div class="col-md-8">

        <div class='form-group'>
            {{ Form::label( 'name', trans('products.name'),['class' => 'col control-label']) }}
            <div class='col'>
                {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('products.name').'*','required'=>'required']) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class='form-group'>
            {{ Form::label( 'taxrate', trans('products.taxrate'),['class' => 'col control-label']) }}
            <div class='col'>
                {{ Form::text('taxrate', numberFormat(@$products['taxrate']), ['class' => 'form-control box-size', 'placeholder' => trans('products.taxrate'),'onkeypress'=>"return isNumber(event)"]) }}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class='form-group'>
            {{ Form::label( 'product_des', trans('products.product_des'),['class' => 'col control-label']) }}
            <div class='col'>
                {{ Form::textarea('product_des', null, ['class' => 'form-control box-size', 'rows'=>2, 'placeholder' => trans('products.product_des')]) }}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class='form-group'>
            {{ Form::label( 'code_type', trans('products.code_type'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="code_type">
                    @if(@$products->code_type)
                        <option value="{{$products->code_type}}" selected>{{$products->code_type}}</option>
                    @endif
                    <option value="EAN13">EAN13 - Default</option>
                    <option value="UPCA">UPC</option>
                    <option value="EAN8">EAN8</option>
                    <option value="ISSN">ISSN</option>
                    <option value="ISBN">ISBN</option>
                    <option value="C128A">C128A</option>
                    <option value="C39">C39</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{ Form::label( 'unit', trans('products.stock_type'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="stock_type">
                    @if(@$products->stock_type==0)
                        <option value="0" selected>-{{trans('products.service')}}-</option> @endif
                    <option value="1">{{trans('products.material')}}</option>
                    <option value="0">{{trans('products.service')}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'productcategory_id', trans('products.productcategory_id'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="productcategory_id" id="product_cat">
                    @foreach($product_category as $item)
                        @if(!$item->c_type)
                            <option value="{{$item->id}}" {{ $item->id == @$products->productcategory_id ? " selected" : "" }}>{{$item->title}}</option>
                        @endif

                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'sub_cat_id', trans('products.sub_cat_id'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="sub_cat_id" id="sub_cat">
                    <option value="0">--{{ trans('products.sub_cat_id')}}--</option>
                    @foreach($product_category as $item)
                        @if($item->c_type AND $product_category->first()['id']==$item->rel_id)
                            <option value="{{$item->id}}" {{ $item->id == @$products->productcategory_id ? " selected" : "" }}>{{$item->title}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'unit', trans('products.unit'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="unit">
                    @foreach($product_variable as $item)
                        @if(!$item->type)
                            <option value="{{$item->code}}" {{ $item->code == @$products->unit ? " selected" : "" }}>{{$item->name}}
                                - {{$item->code}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>


<hr class="mb-5">
<div class="row">

    <div class='col-lg-10'>
        {{trans('products.standard_details')}}
    </div>
</div>

<div id="main_product">
    <div class="product round">

        <div class="row mt-1 mb-1">


            <div class="col-md-12">
                <div class='form-group'>
                    {{ Form::label( 'variation_name', trans('general.description'),['class' => 'col control-label']) }}
                    <div class='col-6'>
                        {{ Form::text('variation_name[]',@$products->standard['name'], ['class' => 'form-control box-size', 'placeholder' => trans('general.description')]) }}
                    </div>

                </div>
            </div>
            <div class="old_id"><input
                        type="hidden" name="v_id[]" value="{{@$products->standard['id']}}"><input
                        type="hidden" name="pv_id" value="{{@$products->standard['id']}}"></div>


        </div>
        <div class="row">
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'price', trans('products.price'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('price[]', numberFormat(@$products->standard['price']), ['class' => 'form-control box-size', 'placeholder' => trans('products.price').'*','required'=>'required','onkeypress'=>"return isNumber(event)"]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'purchase_price', trans('products.purchase_price'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('purchase_price[]', numberFormat(@$products->standard['purchase_price']), ['class' => 'form-control box-size', 'placeholder' => trans('products.purchase_price'),'onkeypress'=>"return isNumber(event)"]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'qty', trans('products.qty'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('qty[]', numberFormat(@$products->standard['qty']), ['class' => 'form-control box-size', 'placeholder' => trans('products.qty'),'onkeypress'=>"return isNumber(event)"]) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label( 'productcategory_id', trans('products.warehouse_id'),['class' => 'col control-label']) }}
                    <div class='col'>
                        <select class="form-control" name="warehouse_id[]">

                            @foreach($warehouses as $item)
                                <option value="{{$item->id}}" {{ $item->id == @$products->warehouse_id ? " selected" : "" }}>{{$item->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'code', trans('products.code'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('code[]', @$products->standard['code'], ['class' => 'form-control box-size', 'placeholder' => trans('products.code')]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'barcode', trans('products.barcode'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('barcode[]', @$products->standard['barcode'], ['class' => 'form-control box-size', 'placeholder' => trans('products.barcode')]) }}
                    </div>
                </div>
            </div>

        </div>


        <div class="row">

            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'disrate', trans('products.disrate'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('disrate[]', numberFormat(@$products->standard['disrate']), ['class' => 'form-control box-size', 'placeholder' => trans('products.disrate'),'onkeypress'=>"return isNumber(event)"]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'alert', trans('products.alert'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {{ Form::text('alert[]', numberFormat(@$products->standard['alert']), ['class' => 'form-control box-size', 'placeholder' => trans('products.alert'),'onkeypress'=>"return isNumber(event)"]) }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class='form-group'>
                    {{ Form::label( 'expiry', trans('products.expiry'),['class' => 'col control-label']) }}
                    <div class='col'>
                        @if(@$products->standard['expiry']!='0000-00-00')
                        {{ Form::text('expiry[]', dateFormat(@$products->standard['expiry']), ['class' => 'form-control box-size', 'placeholder' => trans('products.expiry'),'data-toggle'=>'datepicker','autocomplete'=>'false']) }}
                            @else
                            {{ Form::hidden('expiry[]', '0000-00-00') }} <small class="info">Not Applicable</small>

                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class='form-group'>
                    {{ Form::label( 'image', trans('products.image'),['class' => 'col control-label']) }}
                    <div class='col'>
                        {!! Form::file('image[]', array('class'=>'input' )) !!}
                    </div>
                </div>
            </div>
        </div>
        <span class="col-6 del_b"></span>

        <hr>
    </div>
</div>

@if(isset($products->standard->product_serial))
    @foreach($products->standard->product_serial as $serial)
        <div class="form-group serial"><label for="field_s"
                                              class="col-lg-2 control-label">{{trans('products.product_serial')}}</label>
            <div class="col-lg-10"><input class="form-control box-size"
                                          placeholder="{{trans('products.product_serial')}}"
                                          name="product_serial_e[{{$serial['id']}}]" type="text"
                                          value="{{$serial['value']}}" @if($serial['value2']) readonly="" @endif></div>
        </div>
    @endforeach
@endif
@if(isset($products->variations[0]))
    <h4 class="card-title mt-3">{{trans('products.variation')}}</h4>
    <div id="product_sub">
        @foreach($products->variations as $row)
            <div class="v_product_t border-blue-grey border-lighten-4 round p-1 bg-blue-grey bg-lighten-5"
                 id="pv_{{$row->id}}">

                <input type="hidden" id="" name="v_id[]" value="{{$row->id}}">
                <div class="row mt-3 mb-3">
                    <div class="col-6">{{trans('general.description')}} <input type="text" class="form-control "
                                                                               name="variation_name[]"
                                                                               value="{{$row->name}}"
                                                                               placeholder="{{trans('general.description')}}">

                    </div>
                    <div class="del_b offset-4 col-1" data-vid="{{$row->id}}">
                        <button class="btn btn-danger v_delete m-1 align-content-end"><i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'price', trans('products.price'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('price[]', numberFormat(@$row->price), ['class' => 'form-control box-size', 'placeholder' => trans('products.price'),'onkeypress'=>"return isNumber(event)"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'purchase_price', trans('products.purchase_price'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('purchase_price[]', numberFormat(@$row->purchase_price), ['class' => 'form-control box-size', 'placeholder' => trans('products.purchase_price'),'onkeypress'=>"return isNumber(event)"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'qty', trans('products.qty'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('qty[]', numberFormat(@$row->qty), ['class' => 'form-control box-size', 'placeholder' => trans('products.qty'),'onkeypress'=>"return isNumber(event)"]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label( 'productcategory_id', trans('products.warehouse_id'),['class' => 'col control-label']) }}
                            <div class='col'>
                                <select class="form-control" name="warehouse_id[]">

                                    @foreach($warehouses as $item)
                                        <option value="{{$item->id}}" {{ $item->id == @$row->warehouse_id ? " selected" : "" }}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'code', trans('products.code'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('code[]', @$row->code, ['class' => 'form-control box-size', 'placeholder' => trans('products.code')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'barcode', trans('products.barcode'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('barcode[]', $row->barcode, ['class' => 'form-control box-size', 'placeholder' => trans('products.barcode')]) }}
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'disrate', trans('products.disrate'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('disrate[]', numberFormat(@$row->disrate), ['class' => 'form-control box-size', 'placeholder' => trans('products.disrate'),'onkeypress'=>"return isNumber(event)"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'alert', trans('products.alert'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('alert[]', numberFormat(@$row->alert), ['class' => 'form-control box-size', 'placeholder' => trans('products.alert'),'onkeypress'=>"return isNumber(event)"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class='form-group'>
                            {{ Form::label( 'expiry', trans('products.expiry'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {{ Form::text('expiry[]', dateFormat(@$row->expiry), ['class' => 'form-control box-size', 'placeholder' => trans('products.expiry')]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class='form-group'>
                            {{ Form::label( 'image', trans('products.image'),['class' => 'col control-label']) }}
                            <div class='col'>
                                {!! Form::file('image[]', array('class'=>'input' )) !!}
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        @endforeach
    </div>

@endif

<div id="added_product"></div>
<a href="#" class="card-title "><i class="fa fa-plus-circle"></i> {{trans('products.variation')}}</a>

<button class="btn btn-blue add_more btn-sm m-1">{{trans('general.add_row')}}</button>
<button class="btn btn-pink add_serial btn-sm m-1">{{trans('products.add_serial')}}</button>
<div id="remove_variation">

</div>
@section("after-styles")
    <style>
        #added_product div:nth-child(even) .product {
            background: #FFF
        }

        #added_product div:nth-child(odd) .product {
            background: #eeeeee
        }

        #product_sub div:nth-child(odd) .v_product_t {
            background: #FFF
        }

        #product_sub div:nth-child(even) .v_product_t {
            background: #eeeeee
        }
    </style>
    {!! Html::style('focus/css/select2.min.css') !!}
@endsection
@section("after-scripts")

    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });

        $(document).on('click', ".add_serial", function (e) {
            e.preventDefault();

            $('#added_product').append('<div class="form-group serial"><label for="field_s" class="col-lg-2 control-label">{{trans('products.product_serial')}}</label><div class="col-lg-10"><input class="form-control box-size" placeholder="{{trans('products.product_serial')}}" name="product_serial[]" type="text"  value=""></div><button class="btn-sm btn-purple v_delete_serial m-1 align-content-end"><i class="fa fa-trash"></i> </button></div>');

        });

        $(document).on('click', ".add_more", function (e) {
            e.preventDefault();
            var product_details = $('#main_product').clone().find(".old_id input:hidden").val(0).end();
            product_details.find(".del_b").append('<button class="btn btn-danger v_delete_temp m-1 align-content-end"><i class="fa fa-trash"></i> </button>').end();
            $('#added_product').append(product_details);
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
        });


        $(document).on('click', ".v_delete", function (e) {
            e.preventDefault();
            var p_v = $(this).closest('div').attr('data-vid');
            $('#remove_variation').append("<input type='hidden' name='remove_v[]' value='" + p_v + "'>");
            alert('{{trans('products.alert_removed')}}');
            $('#pv_' + p_v).remove();
        });

        $(document).on('click', ".v_delete_temp", function (e) {
            e.preventDefault();
            $(this).closest('div .product').remove();
        });

        $(document).on('click', ".v_delete_serial", function (e) {
            e.preventDefault();
            $(this).closest('div .serial').remove();
        });


    </script>
    {{ Html::script('focus/js/select2.min.js') }}
    <script type="text/javascript">
        $("#sub_cat").select2();
        $("#product_cat").on('change', function () {
            $("#sub_cat").val('').trigger('change');
            var tips = $('#product_cat :selected').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#sub_cat").select2({
                ajax: {
                    url: '{{route('biller.products.product_sub_load')}}?id=' + tips,
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    params: {'cat_id': tips},
                    data: function (product) {
                        return {
                            product: product
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        });
    </script>
@endsection
