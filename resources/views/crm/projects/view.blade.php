@extends ('crm.layouts.app',['page'=>'class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="horizontal-menu" data-col="content-detached-right-sidebar" '])

@section ('title', $project['name'].'| '.trans('labels.backend.projects.management') )

@section('page-header')
    <h1>
        {{ trans('labels.backend.projects.management') }}
        <small>{{ trans('labels.backend.projects.create') }}</small>
    </h1>
@endsection

@section('content')

    <!-- BEGIN: Content-->
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{trans('projects.project_summary')}}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                            href="{{route('biller.dashboard')}}">{{trans('core.home')}}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                            href="{{route('biller.projects.index')}}">{{trans('projects.projects')}}</a>
                                </li>
                                <li class="breadcrumb-item active">{{trans('projects.project_summary')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">
                        <div class="media-left media-middle">

                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$project['name']}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body" id="pro_tabs">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab_data1"
                                   aria-controls="tab_data1" role="tab" aria-selected="true"><i
                                            class="fa fa-lightbulb-o"></i> {{trans('projects.project_summary')}}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab2" data-toggle="tab" href="#tab_data2"
                                   aria-controls="tab_data2" role="tab" aria-selected="true"><i
                                            class="fa fa-flag-checkered"></i> {{trans('projects.milestones')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab3" data-toggle="tab" href="#tab_data3"
                                   aria-controls="tab_data3" role="tab" aria-selected="true"><i
                                            class="icon-directions"></i> {{trans('tasks.tasks')}}</a>
                            </li>


                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane  active in" id="tab_data1" aria-labelledby="tab1" role="tabpanel">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-header">
                                            <h4 class="card-title">{{$project['name']}}</h4>
                                            <a class="heading-elements-toggle"><i
                                                        class="fa fa-ellipsis-v font-medium-3"></i></a>

                                        </div>

                                        <div class="px-1"><p>{{$project['short_desc']}}</p>
                                            <div class="heading-elements">
                                                @foreach ($project->tags as $row)
                                                    <span class="badge"
                                                          style="background-color:{{$row['color']}}">{{$row['name']}}</span>
                                                @endforeach

                                            </div>
                                            <ul class="list-inline list-inline-pipe text-center p-1 border-bottom-grey border-bottom-lighten-3">

                                                <li>{{trans('projects.owner')}}: <span
                                                            class="text-muted">{{$project->creator->first_name.' '.$project->creator->last_name}}</span>
                                                </li>
                                                <li>{{trans('projects.start_date')}}: <span
                                                            class="text-muted">{{dateTimeFormat($project['start_date'])}}</span>
                                                </li>
                                                <li>{{trans('projects.end_date')}}: <span
                                                            class="text-muted">{{dateTimeFormat($project['end_date'])}}</span>
                                                </li>
                                                <li>{{trans('projects.end_date')}}: <span
                                                            class="text-muted">{{dateTimeFormat($project['end_date'])}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- project-info -->
                                    <div id="project-info" class="card-body row">
                                        <div class="project-info-count col-lg-3 col-md-12">
                                            <div class="project-info-icon">
                                                <h2>{{@count($project->users)}}</h2>
                                                <div class="project-info-sub-icon">
                                                    <span class="fa fa-user-o"></span>
                                                </div>
                                            </div>
                                            <div class="project-info-text pt-1">
                                                <h5>{{trans('projects.users')}}</h5>
                                            </div>
                                        </div>
                                        <div class="project-info-count col-lg-3 col-md-12">
                                            <div class="project-info-icon">
                                                <h2 id="prog">{{@numberFormat($project->progress)}}%</h2>
                                                <div class="project-info-sub-icon">
                                                    <span class="fa fa-rocket"></span>
                                                </div>
                                            </div>
                                            <div class="project-info-text pt-1">
                                                <h5>{{trans('projects.progress')}}</h5>

                                            </div>
                                        </div>
                                        <div class="project-info-count col-lg-3 col-md-12">
                                            <div class="project-info-icon">
                                                <h2>{{@count($project->tasks)}}</h2>
                                                <div class="project-info-sub-icon">
                                                    <span class="fa fa-calendar-check-o"></span>
                                                </div>
                                            </div>
                                            <div class="project-info-text pt-1">
                                                <h5>{{trans('tasks.tasks')}}</h5>
                                            </div>
                                        </div>
                                        <div class="project-info-count col-lg-3 col-md-12">
                                            <div class="project-info-icon">
                                                <h2>{{@count($project->milestones)}}</h2>
                                                <div class="project-info-sub-icon">
                                                    <span class="fa fa-flag-checkered"></span>
                                                </div>
                                            </div>
                                            <div class="project-info-text pt-1">
                                                <h5>{{trans('projects.milestones')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- project-info -->
                                    <div class="card-body">
                                        <div class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                            <span>{{trans('projects.eagle_view')}}</span>
                                        </div>

                                    </div>
                                </div>
                                <section class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">

                                        <!-- Project Overview -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{trans('general.description')}}</h4>
                                                <a class="heading-elements-toggle"><i
                                                            class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                <div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    {!! $project['note']!!}
                                                </div>
                                            </div>
                                        </div>
                                        <!--/ Project Overview -->
                                    </div>
                                    <!--/ Task Progress -->

                                </section>
                            </div>
                            <div class="tab-pane" id="tab_data2" aria-labelledby="tab2" role="tabpanel">

                                <ul class="timeline">
                                    @php
                                        $flag = true;
                                        $total = count($project->milestones);

                                    @endphp

                                    @foreach ($project->milestones as $row)



                                        <li class="@if (!$flag) timeline-inverted @endif " id="m_{{$row['id']}}">
                                            <div class="timeline-badge"
                                                 style="background-color:@if ($row['color']) {{$row['color']}} @else #0b97f4  @endif;">{{$total}}</div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">{{$row['name']}}</h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            [{{trans('general.due_date')}} {{dateTimeFormat($row['due_date'])}}
                                                            ]
                                                        </small>

                                                    </p>
                                                </div>

                                                <small class="text-muted"><i
                                                            class="fa fa-user"></i>
                                                    <strong>{{$row->creator->first_name}}  {{$row->creator->last_name}}</strong>
                                                    <i
                                                            class="fa fa-clock-o"></i> {{trans('general.created')}} {{dateTimeFormat($row['created_at'])}}
                                                </small>
                                            </div>
                                        </li>
                                        @php
                                            $flag = !$flag;
                                          $total--;
                                        @endphp

                                    @endforeach


                                </ul>

                            </div>
                            <div class="tab-pane" id="tab_data3" aria-labelledby="tab3" role="tabpanel">

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
                                        </tr>
                                        </thead>

                                        <tbody></tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab_data4" aria-labelledby="tab4" role="tabpanel">
                                @if(project_client($project->id))
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#AddLogModal">
                                        {{trans('general.new')}}
                                    </button>

                                    <div class="card-body">
                                        <table id="log-table"
                                               class="table table-striped table-bordered zero-configuration"
                                               cellspacing="0"
                                               width="100%">

                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('general.date') }}</th>
                                                <th>{{ trans('projects.users') }}</th>
                                                <th>{{ trans('general.description') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>


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
    @include('focus.projects.modal.milestone_new')
    @include('focus.projects.modal.log_new')
    @include('focus.projects.modal.note_new')
    @if(access()->allow('task-create')) @include('focus.projects.modal.task_new') @endif
    @include('focus.projects.modal.delete_2')
@endsection

@section('after-styles')
    {{ Html::style('core/app-assets/css-'.visual().'/pages/project.css') }}
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}

@endsection

@section('after-scripts')
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('focus/js/select2.min.js') }}
    {{ Html::script(mix('js/dataTable.js')) }}
    {!! Html::style('focus/jq_file_upload/css/jquery.fileupload.css') !!}
    {{ Html::script('focus/jq_file_upload/js/jquery.fileupload.js') }}
    <script>


        $(function () {
            'use strict';
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('project_tab', $(e.target).attr('href'));

                switch ($(e.target).attr('href')) {
                    case '#tab_data3':
                        tasks();
                        break;
                }
            });
            var project_tab = localStorage.getItem('project_tab');
            if (project_tab) {
                $('a[href="' + project_tab + '"]').tab('show');
            }


        });


        function trigger(data) {
            switch (data.t_type) {
                case 1:
                    $('#m_' + data.meta).remove();
                    break;

                case 2:
                    $('.timeline').prepend(data.meta);
                    break;

                case 3:
                    $(data.row).prependTo("#tasks-table tbody");

                    $("#data_form_task").trigger('reset');
                    break;

            }

        }

        function invoices() {
            if ($('#invoices-table_p tbody').is(":empty")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var dataTable = $('#invoices-table_p').dataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    language: {
                        @lang('datatable.strings')
                    },
                    ajax: {
                        url: '{{ route("biller.projects.invoices") }}?project_id={{$project->id}}',
                        type: 'post',
                    },
                    columns: [
                        {data: 'DT_Row_Index', name: 'id'},
                        {data: 'tid', name: 'tid'},
                        {data: 'customer', name: 'customer'},
                        {data: 'invoicedate', name: 'invoicedate'},
                        {data: 'total', name: 'total'},
                        {data: 'status', name: 'status'},
                        {data: 'invoiceduedate', name: 'invoiceduedate'},
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
                $('#invoices-table_p_wrapper').removeClass('form-inline');
            }
        }

        function notes() {
            if ($('#notes-table tbody').is(":empty")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var dataTable = $('#notes-table').dataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    language: {
                        @lang('datatable.strings')
                    },
                    ajax: {
                        url: '{{ route("biller.notes.get") }}?p={{$project->id}}',
                        type: 'post',
                    },
                    columns: [
                        {data: 'DT_Row_Index', name: 'id'},
                        {data: 'title', name: 'title'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'user', name: 'user'},

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
                $('#notes-table_wrapper').removeClass('form-inline');

            }
        }

        function tasks() {
            if ($('#tasks-table tbody').is(":empty")) {
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
                        url: '{{ route("crm.projects.tasks") }}?p_c={{$project->id}}',
                        type: 'post',
                        dataType: 'json'
                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'start', name: 'start'},
                        {data: 'duedate', name: 'duedate'},
                        {data: 'status', name: 'status'},
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
                $('#tasks-table_wrapper').removeClass('form-inline');
            }
        }


    </script>

@endsection