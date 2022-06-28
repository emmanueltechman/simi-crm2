@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management') . ' | ' . trans('labels.backend.hrms.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.hrms.management') }}
        <small>{{ trans('hrms.attendance') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('hrms.attendance') }}</h4>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.hrms.partials.att-header-buttons')
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
                                    <table id="attendance_all-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('hrms.employees') }}</th>
                                            <th>{{ trans('general.date') }}</th>
                                            <th>{{ trans('hrms.entry_time') }}</th>
                                            <th>{{ trans('hrms.exit_time') }}</th>
                                            <th>*</th>
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
    @include('focus.hrms.partials.delete_2')
@endsection


@section("after-scripts")
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">

        $(function () {
            setTimeout(function () {
                attend()
            }, {{config('master.delay')}});
        });

        function attend() {

            var dataTable = $('#attendance_all-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.hrms.attendance_load") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'present', name: 'present'},
                    {data: 't_from', name: 't_from'},
                    {data: 't_to', name: 't_to'},
                    {data: 'remove', name: 'remove'}

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
            $('#attendance_all-table_wrapper').removeClass('form-inline');

        }

        function trigger(data) {
            switch (data.t_type) {
                case 1:
                    $('#a_' + data.meta).closest('tr').remove();
                    break;
            }
        }
    </script>
@endsection