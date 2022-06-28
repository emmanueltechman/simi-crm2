@extends ('core.layouts.app',['page'=>'class="horizontal-layout horizontal-menu content-left-sidebar todo " data-open="click" data-menu="horizontal-menu" '])

@section ('title', trans('labels.backend.tasks.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.tasks.management') }}</h1>
@endsection
@section('content')
    <div class="">
        <div class="sidebar-left">
            <div class="sidebar">
                <div class="sidebar-content sidebar-todo">
                    <div class="card">
                        <div class="card-body">
                            @permission('task-create')
                            <div class="form-group form-group-compose text-center">
                                <button type="button" class="btn btn-info btn-block" id="addt" data-toggle="modal"
                                        data-target="#AddTaskModal">
                                    {{trans('tasks.new_task')}}
                                </button>
                            </div>
                            @endauth
                            <div class="sidebar-todo-container">
                                <h6 class="text-muted text-bold-500 my-1"></h6>
                                <div class="list-group list-group-messages">
                                    <a href="{{route('biller.dashboard')}}"
                                       class="list-group-item list-group-item-action border-0">
                                        <i class="icon-home mr-1"></i>
                                        <span>{{trans('navs.frontend.dashboard')}}</span>
                                    </a>
                                    <a href="{{route('biller.todo')}}"
                                       class="list-group-item list-group-item-action border-0">
                                        <i class="icon-list mr-1"></i>
                                        <span>{{trans('general.tasks')}}</span><span
                                                class="badge badge-secondary badge-pill float-right"></span>
                                    </a>
                                    <a href="{{route('biller.messages')}}"
                                       class="list-group-item list-group-item-action border-0">
                                        <i class="icon-bell mr-1"></i>
                                        <span>{{trans('general.messages')}}</span>
                                        <span class="badge badge-danger badge-pill float-right">{{Auth::user()->newThreadsCount()}}</span>
                                    </a>

                                </div>

                                @permission('misc-manage')
                                <h6 class="text-muted text-bold-500 my-1">{{trans('general.tags')}}</h6>
                                <div class="list-group list-group-messages">
                                    @foreach($mics->where('section','=',1) as $row)

                                        <a href="#" class="list-group-item list-group-item-action border-0">
                                            <i class="ft-circle mr-1" style="color: {{$row['color']}}"></i>
                                            <span> {{$row['name']}} </span>
                                        </a>
                                    @endforeach
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-overlay"></div>
                    <!-- Modal -->
                    @include('focus.projects.modal.task_new')
                    <div class="card todo-details rounded-0">
                        <div class="sidebar-toggle d-block d-lg-none info"><i class="ft-menu font-large-1"></i></div>
                        <div class="search">

                        </div>

                        <div class="card-body">
                            <table id="tasks-table"
                                   class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                   width="100%">

                                <thead>
                                <tr>
                                    <th>{{ trans('tasks.task') }}</th>
                                    <th>{{ trans('tasks.start') }}</th>
                                    <th>{{ trans('tasks.duedate') }}</th>
                                    <th>{{ trans('tasks.status') }}</th>

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
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <input type="hidden" id="loader_url" value="{{route('biller.tasks.load')}}">
    @include('focus.projects.modal.task_view')
@endsection
@section('after-styles')
    {{ Html::style('core/app-assets/css-'.visual().'/pages/app-todo.css') }}
    {{ Html::style('core/app-assets/css-'.visual().'/plugins/forms/checkboxes-radios.css') }}
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}
@endsection
@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    {{ Html::script('core/app-assets/vendors/js/extensions/moment.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/fullcalendar.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/dragula.min.js') }}
    {{ Html::script('core/app-assets/js/scripts/pages/app-todo.js') }}
    {{ Html::script('focus/js/select2.min.js') }}
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}

    <script type="text/javascript">
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

            var dataTable = $('#tasks-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.tasks.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'tags', name: 'tags'},
                    {data: 'start', name: 'start'},
                    {data: 'duedate', name: 'duedate'},
                    {data: 'status', name: 'status'},

                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "desc"]],
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
            $('#tasks-table_wrapper').removeClass('form-inline');

            @include('focus.projects.adt.new_task_js')

        }

        function trigger(data) {

            $(data.row).prependTo("table > tbody");

            $("#data_form_task").trigger('reset');

        }


    </script>
@endsection