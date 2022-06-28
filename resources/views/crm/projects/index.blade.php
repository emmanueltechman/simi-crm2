@extends ('crm.layouts.app')

@section ('title', trans('labels.backend.projects.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.projects.management') }}</h1>
@endsection
@section('content')
    <div class="">


        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="content-overlay"></div>
                <!-- Modal -->
                @include('focus.projects.modal.project_new')
                <div class="card todo-details rounded-0">
                    <div class="sidebar-toggle d-block d-lg-none info"><i class="ft-menu font-large-1"></i></div>
                    <div class="search">

                    </div>

                    <div class="card-body">
                        <table id="projects-table"
                               class="table table-striped table-bordered zero-configuration" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('projects.project') }}</th>
                                <th>{{ trans('projects.priority') }}</th>
                                <th>{{ trans('projects.status') }}</th>
                                <th>{{ trans('projects.end_date') }}</th>

                            </tr>
                            </thead>


                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <input type="hidden" id="loader_url" value="{{route('biller.projects.load')}}">
    @include('focus.projects.modal.project_view')
@endsection
@section('after-styles')
    {{ Html::style('core/app-assets/css-'.visual().'/pages/app-todo.css') }}
    {{ Html::style('core/app-assets/css-'.visual().'/plugins/forms/checkboxes-radios.css') }}
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}
@endsection
@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    {{ Html::script('core/app-assets/vendors/js/extensions/moment.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/fullcalendar.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/dragula.min.js') }}
    {{ Html::script('core/app-assets/js/scripts/pages/app-todo.js') }}
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('focus/js/select2.min.js') }}
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var dataTable = $('#projects-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("crm.projects.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'priority', name: 'priority'},
                    {data: 'progress', name: 'progress'},
                    {data: 'deadline', name: 'deadline'},
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
            $('#projects-table_wrapper').removeClass('form-inline');

        });


        function trigger(data) {

            $(data.row).prependTo("table > tbody");

            $("#data_form_project").trigger('reset');

        }

        $(document).on('click', ".view_project", function (e) {

            var did = $(this).attr('data-item');
            $.ajax({
                url: $('#loader_url').val(),
                type: 'POST',
                dataType: 'json',
                data: {'project_id': did},
                success: function (data) {
                    $('#p_id').val(data.id);
                    $('#p_name').text(data.name);
                    $('#ps_description').text(data.short_desc);
                    $('#p_description').text(data.note);
                    $('#p_start').text(data.start_date);
                    $('#p_end').text(data.end_date);
                    $('#p_creator').text(data.creator);
                    $('#p_assigned').text(data.assigned);
                    $('#p_status').html(data.status);
                    $('#p_status_list').empty();
                    $('#p_status_list').append(data.status_list);
                    $('#d_view').attr('href', data.view);
                }
            });
        });

    </script>
@endsection
