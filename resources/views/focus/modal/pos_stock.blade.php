<div class="modal fade" id="pos_stock" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <!-- Modal Header -->
            <div class="modal-header bg-gradient-directional-purple white">

                <h4 class="modal-title" id="myModalLabel">{{trans('pos.stock_search')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{trans('pos.pos')}}</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        {{trans('warehouses.warehouses')}}<select
                                id="s_warehouses"
                                class="form-control round">
                            <option value="0">{{trans('general.all')}}</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}" {{$warehouse->id==$defaults[1][0]['feature_value'] ? 'selected' : ''}}>{{$warehouse->title}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row mt-1">
                    <div class="col-md-12">
                        {{trans('productcategories.productcategories')}}<select
                                id="s_category"
                                class="form-control round">
                            <option value="0">{{trans('general.all')}}</option>
                            @foreach($product_category as $warehouse)
                                <option value="{{$warehouse->id}}" >{{$warehouse->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12  mt-2">
                        <label for="serial_mode" class="form-check-label"><input type="checkbox"
                                                                                 value="1"
                                                                                 class="form-check-inline"
                                                                                 name="serial_mode"
                                                                                 id="serial_mode">
                            {{trans('products.search_serial_only')}}</label></div>
                    <div class="col-md-12  mt-2">
                        <label for="serial_mode">
                            {{trans('products.search_limit')}}<select
                                    id="search_limit"
                                    class="form-control form-control-sm round mt-1">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="80">80</option>
                                <option value="100">100</option>
                            </select></label></div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-dismiss="modal">{{trans('general.close')}}</button>

            </div>

        </div>
    </div>
</div>