@extends ('core.layouts.app')

@section ('title', trans('labels.backend.products.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.products.management') }}</h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.products.management') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.products.partials.products-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            @if($segment)
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <p>@if(request('rel_type') == 2){{trans('warehouses.title')}}@else {{trans('productcategories.title')}} @endif </p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{$segment['title']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{trans('productcategories.extra')}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{$segment['extra']}}</p>
                            </div>
                        </div> @if(!$segment['c_type'])
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('productcategories.total_products')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{numberFormat($segment->products->sum('qty'))}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('productcategories.total_worth')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->products->sum('total_value'))}}</p>
                                </div>
                            </div>

                    </div>
                </div>
            @endif

            @if(isset($segment->subcategories[0]))
                <div class="card p-1 bg-lighten-5">
                    <h4 class="mb-0">{{ trans('productcategories.sub_categories') }}</h4>
                    <table id="productcategories-table"
                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('productcategories.title') }}</th>
                            <th>{{ trans('general.createdat') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            @endif
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    <table id="products-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.backend.products.table.id') }}</th>
                                            <th>{{ trans('products.name') }}</th>
                                            <th>{{ trans('products.productcategory_id') }}</th>
                                            <th>{{ trans('products.warehouse_id') }}</th>

                                            <th>{{ trans('products.qty') }}</th>
                                            <th>{{ trans('products.price') }}</th>
                                            <th>{{ trans('general.createdat') }}</th>
                                             <th>{{ trans('products.code') }}</th>
                                            <th>{{ trans('labels.general.actions') }}</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <tr>
                                            <td colspan="100%" class="text-center text-success font-large-1"><i
                                                        class="fa fa-spinner spinner"></i></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>

        $(function () {
            setTimeout(function () {
                draw_data();
                sub_draw_data();
            }, {{config('master.delay')}});
        });

        function draw_data() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#products-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.products.get") }}',
                    type: 'post',
                    @if($segment) data: {p_rel_id: '{{$segment['id']}}', p_rel_type: '{{$input['rel_type']}}'},@endif },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'category', name: 'category'},
                    {data: 'warehouse', name: 'warehouse'},
                    {data: 'qty', name: 'qty'},
                    {data: 'price', name: 'price'},
                    {data: 'created_at', name: '{{config('module.products.table')}}.created_at'},
                    {data: 'code', name: 'code',visible:false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'Blfrtip',
                buttons: {
                    buttons: [

                        {extend: 'csv', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]}},
                        {extend: 'excel', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]}},
                        {extend: 'print', footer: true, exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]}}
                    ]
                },
            });
            $('#products-table_wrapper').removeClass('form-inline');

        }

         function sub_draw_data() {
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#productcategories-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.productcategories.get") }}',
                    type: 'post',
                      data: {rel_type: '1',rel_id:'{{request('rel_id',0)}}'}
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'created_at', name: '{{config('module.productcategories.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'Blfrtip',
                buttons: {
                    buttons: [

                        {extend: 'csv', footer: true, exportOptions: {columns: [0, 1]}},
                        {extend: 'excel', footer: true, exportOptions: {columns: [0, 1]}},
                        {extend: 'print', footer: true, exportOptions: {columns: [0, 1]}}
                    ]
                }
            });
            $('#productcategories-table_wrapper').removeClass('form-inline');
        }

    </script>
@endsection
