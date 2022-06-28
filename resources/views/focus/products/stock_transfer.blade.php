@extends ('core.layouts.app')
@section ('title', trans('labels.backend.products.management') . ' | ' . trans('products.stock_transfer'))

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
                        <h5> {{trans('products.stock_transfer') }}</h5>
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
                            {{ Form::open(['route' => 'biller.products.stock_transfer_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'create-transfer']) }}
                            <div class="form-group row">


                                <div class="col-sm-4"><label class="col-form-label"
                                                             for="product_cat">{{trans('products.stock_transfer_from') }}</label>
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

                                <div class="col-sm-4"><label class="col-form-label"
                                                             for="product_cat">{{trans('products.stock_transfer_to') }}</label>
                                    <select id="wto" name="to_warehouse" class="form-control">
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
                                <div class="col-sm-4"><label class="col-form-label"
                                                             for="product_cat">{{trans('products.existing_product') }}</label>
                                    <select id="wto" name="merger" class="form-control">
                                        <option value='1'
                                                selected>{{trans('products.merge_only_if_code_match')}}</option>
                                        <option value='0'>{{trans('products.not_applicable')}}</option>
                                        <option value='2'>{{trans('products.merge_if_code_is_empty')}}</option>

                                    </select>


                                </div>


                                <div class="col-sm-8"><label class="col-form-label"
                                                             for="pay_cat">{{trans('products.product') }}</label>
                                    <select id="products_l" name="products_l[]" class="form-control required select-box"
                                            multiple="multiple">

                                    </select>


                                </div>
                            </div>

                            <div class="form-group row">


                                <div class="col-8"><label class="col-form-label"
                                                          for="width">  {{trans('products.qty') }}</label>
                                    <input name="qty" class="form-control required" type="text" value="1">
                                    <small>{{trans('products.use_comma')}}</small>

                                </div>

                            </div>


                            <div class="form-group row">


                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-success margin-bottom"
                                           value="{{trans('products.stock_transfer')}}"
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
                ajax: {
                    url: '{{route('biller.products.product_search_post',['label'])}}',
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (product) {

                        return {
                            keyword: product,
                            wid: tips

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
