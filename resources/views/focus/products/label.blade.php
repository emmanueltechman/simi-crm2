@extends ('core.layouts.app')
@section ('title', trans('labels.backend.products.management') . ' | ' . trans('products.label_print_settings'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.products.management') }}
        <small>{{ trans('labels.backend.products.create') }}</small>
    </h1>
@endsection
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h5> {{trans('products.product_label_print') }}</h5>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'biller.products.product_label_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'create-product','target'=>"_blank"]) }}
                            <input type="hidden" name="act" value="add_product">
                            <div class="form-group row">


                                <div class="col-sm-4"><label class="col-form-label"
                                                             for="product_cat">{{trans('warehouses.warehouse') }}</label>
                                    <select id="wfrom" name="from_warehouse" class="form-control">
                                        <option value='0'>Select</option>
                                        <?php
                                        foreach ($warehouses as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>


                                <div class="col-sm-8"><label class="col-form-label"
                                                             for="pay_cat">{{trans('products.product') }}</label>
                                    <select id="products_l" name="products_l[]" class="form-control required select-box"
                                            multiple="multiple">
                                    </select>


                                </div>
                            </div>
                            <hr>
                            {{trans('products.label_print_settings') }}
                            <hr>
                            <div class="form-group row">


                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="width">  {{trans('products.label_width') }}</label>
                                    <input name="width" class="form-control required" type="number" value="100">
                                    <small>in MM</small>

                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="width">{{trans('products.label_height') }}</label>
                                    <input name="height" class="form-control required" type="number" value="70">
                                    <small>in MM</small>

                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="padding">{{trans('products.label_padding') }}</label>
                                    <input name="padding" class="form-control required" type="number" value="10">
                                    <small>in PX</small>

                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="store_name">{{trans('business.company_name') }}</label>
                                    <select class="form-control" name="store_name">
                                        <option value="1">{{trans('general.yes') }}</option>
                                        <option value="0">{{trans('general.no') }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="store_name">{{trans('warehouses.warehouse') }}</label>
                                    <select class="form-control" name="warehouse_name">
                                        <option value="1">{{trans('general.yes') }}</option>
                                        <option value="0">{{trans('general.no') }}</option>
                                    </select>

                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="product_price">{{trans('products.price') }}</label>
                                    <select class="form-control" name="product_price">
                                        <option value="1">{{trans('general.yes') }}</option>
                                        <option value="0">{{trans('general.no') }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="product_code">{{trans('products.code') }}</label>
                                    <select class="form-control" name="product_code">
                                        <option value="1">{{trans('general.yes') }}</option>
                                        <option value="0">{{trans('general.no') }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="width">{{trans('products.barcode_height') }}</label>
                                    <select class="form-control" name="bar_height">
                                         <option value="0">0</option>
                                        <option value=".5">50%</option>
                                        <option value=".6" selected>60%</option>
                                        <option value=".7">70%</option>
                                        <option value=".8">80%</option>
                                        <option value=".9">90%</option>
                                        <option value="1">100%</option>
                                    </select>
                                </div>


                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="width">Total Rows</label>
                                    <select class="form-control" name="total_rows">
                                        <option value="0">1</option>
                                        <option value="1">2</option>
                                        <option value="2">3</option>
                                        <option value="3">4</option>
                                        <option value="4">5</option>
                                        <option value="5">6</option>
                                        <option value="6">7</option>
                                        <option value="7">8</option>
                                        <option value="8">9</option>
                                        <option value="9">10</option>
                                        <option value="19">20</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><label class="col-form-label"
                                                             for="width">Total Cols</label>
                                    <select class="form-control" name="items_per_row">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">


                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-success margin-bottom"
                                           value="{{trans('general.print')}}"
                                           data-loading-text="Adding...">

                                </div>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    {{ Html::script('focus/js/select2.min.js') }}
    <script type="text/javascript">
        $("#products_l").select2();
        $("#wfrom").on('change', function () {
            var tips = $('#wfrom').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#products_l").select2({
                tags: [],
                minimumInputLength: 3,
                ajax: {
                    url: '{{route('biller.products.product_search_post',['label'])}}?wid=' + $('#wfrom option:selected').val(),
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (product) {
                        return {
                            product: product
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
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
