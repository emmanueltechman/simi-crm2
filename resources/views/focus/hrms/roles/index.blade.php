@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.access.roles.management') }}</h1>
@endsection

@section('content')

    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.access.roles.management') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.hrms.partials.role-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    <table id="roles-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.backend.access.roles.table.role') }}</th>
                                            <th>{{ trans('labels.backend.access.roles.table.permissions') }}</th>
                                            <th>{{ trans('labels.general.actions') }}</th>
                                        </tr>
                                        </thead>

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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#roles-table').dataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: '{{ route("biller.role.get") }}',
                    type: 'post',
                },
                columns: [
                    {data: 'name', name: '{{config('access.roles_table')}}.name'},
                    {data: 'permissions', name: '{{config('access.permissions_table')}}.display_name', sortable: false},


                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [

                        {extend: 'csv', className: 'csvButton', exportOptions: {columns: [0, 1]}},
                        {extend: 'excel', className: 'excelButton', exportOptions: {columns: [0, 1]}},

                        {extend: 'print', className: 'printButton', exportOptions: {columns: [0, 1]}}
                    ]
                },
                language: {
                    @lang('datatable.strings')
                }
            });


        });
    </script>
@endsection

