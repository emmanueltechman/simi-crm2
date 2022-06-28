@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.hrms.management') }}</h1>
@endsection

@section('content')

    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ $title }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.hrms.partials.hrms-header-buttons')
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
                                    <table id="hrms-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('hrms.employees') }}</th>
                                            <th>{{ trans('hrms.role') }}</th>
                                            <th>{{ trans('hrms.email') }}</th>
                                            <th>{{ trans('hrms.picture') }}</th>
                                            @if($flag)
                                                <th>{{ trans('hrms.status') }}</th>
                                                <th>{{ trans('labels.backend.hrms.table.createdat') }}</th>
                                                <th>{{ trans('labels.general.actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <tr>
                                            <td colspan="8" class="text-center text-success font-large-1"><i
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
                draw_data()
            }, {{config('master.delay')}});
        });

        function draw_data() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', ".user_active", function (e) {
                var cid = $(this).attr('data-cid');
                var active = $(this).attr('data-active');
                if (active == 1) {
                    $(this).removeClass('checked');
                    $(this).attr('data-active', 0);
                } else {
                    $(this).addClass('checked');
                    $(this).attr('data-active', 1);
                }



                $.ajax({
                    url: '{{ route("biller.hrms.active") }}',
                    type: 'post',
                    data: {'cid': cid, 'active': active}
                });
            });

            var dataTable = $('#hrms-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.hrms.get") }}',
                    type: 'post'
                    @if(request('rel_type')>0) ,
                    data: {rel_type:{{request('rel_type')}}, rel_id:{{request('rel_id',0)}}} @endif
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'email', name: 'email'},
                    {data: 'picture', name: 'picture'},
                        @if($flag)             {data: 'active', name: 'active'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                    @endif
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
            $('#hrms-table_wrapper').removeClass('form-inline');

        }
    </script>
@endsection
