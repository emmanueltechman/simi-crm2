@extends ('core.layouts.app',['page'=>'class="horizontal-layout horizontal-menu content-detached-left-sidebar app-contacts " data-open="click" data-menu="horizontal-menu" data-col="content-detached-left-sidebar"'])

@section ('title', trans('labels.backend.hrms.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.hrms.management') }}
        <small>{{ trans('labels.backend.hrms.management') }}</small>
    </h1>
@endsection
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-detached content-right">
                <div class="content-body">
                    <div class="content-overlay"></div>


                    <section class="row all-contacts">
                        <div class="col-12">
                            <div class="card">


                                <div class="card-content">
                                    <div class="card-body">

                                        <a href="{{route('biller.hrms.edit',[$hrm->id])}}"
                                           class="btn btn-blue btn-outline-accent-5 btn-sm float-right"><i
                                                    class="fa fa-pencil"></i> {{trans('buttons.general.crud.edit')}}</a>
                                        <div class="card-body">

                                            <ul class="nav nav-tabs nav-top-border no-hover-bg"
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="active-tab1" data-toggle="tab"
                                                       href="#active1" aria-controls="active1" role="tab"
                                                       aria-selected="true">{{ trans('hrms.employee_details') }}</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link " id="active-tab2" data-toggle="tab"
                                                       href="#active2" aria-controls="active2"
                                                       role="tab">{{ trans('customers.other_data') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="active-tab4" data-toggle="tab"
                                                       href="#active4" aria-controls="active4"
                                                       role="tab">{{ trans('hrms.hrms') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="active-tab3" data-toggle="tab"
                                                       href="#active3" aria-controls="active3"
                                                       role="tab">{{ trans('hrms.permissions') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " id="active-tab7" data-toggle="tab"
                                                       href="#active7" aria-controls="active7"
                                                       role="tab">{{ trans('hrms.attendance') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <span class="badge bg-purple badge-pill float-right">{{$hrm->amount->count('id')}}</span>
                                                    <a class="nav-link " id="active-tab4"
                                                       href="{{route('biller.transactions.index')}}?rel_type=2&rel_id={{$hrm->id}}">
                                                        {{trans('transactions.transactions')}}</a>
                                                </li>

                                                <li class="nav-item">
                                                    <span class="badge bg-pink badge-pill float-right">{{$hrm->payroll->count('id')}}</span>
                                                    <a class="nav-link " id="active-tab4"
                                                       href="{{route('biller.transactions.index')}}?rel_type=3&rel_id={{$hrm->id}}">
                                                        {{trans('hrms.payroll')}}</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content px-1 pt-1">
                                                <div class="tab-pane active in" id="active1"
                                                     aria-labelledby="active-tab1" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.employee')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm['first_name'].' '.$hrm['last_name']}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.company')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['company']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.phone')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['contact']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.email')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm['email']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.status')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>@if($hrm['status'])<span
                                                                        class="badge badge-success round"><i
                                                                            class="font-medium-2  fa fa-check-circle"></i></span>@else
                                                                    <span class="badge badge-danger round"><i
                                                                                class="font-medium-2  fa fa-close"></i></span> @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.confirmed')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">

                                                            <p>@if($hrm['confirmed'])<span
                                                                        class="badge badge-success round"><i
                                                                            class="font-medium-2  fa fa-check-circle"></i></span>@else
                                                                    <span class="badge badge-danger round"><i
                                                                                class="font-medium-2  fa fa-close"></i></span> @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.created_by')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>@if(@$hrm['created_by']) {{ @$hrm->created_by_user['first_name'].' '.@$hrm->created_by_user['last_name'] }}@else
                                                                    <span class="badge badge-danger round"><i
                                                                                class="font-medium-2  fa fa-close"></i></span> @endif
                                                            </p>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tab-pane" id="active2" aria-labelledby="link-tab2"
                                                     role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.address_1')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['address_1'].' '.$hrm->profile['address_2']}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.city')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['city']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.state')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['state']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.country')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['country']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.postal')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['postal']}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.tax_id')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->profile['taxid']}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="active3" aria-labelledby="link-tab3"
                                                     role="tabpanel">
                                                    <h5 class="title m-2"><small
                                                                class="purple">{{trans('hrms.available_permissions')}}</small> {{$hrm->role['name']}}
                                                    </h5>
                                                    <div class="row">
                                                        @php
                                                            $i=0;
                                                        @endphp
                                                        @foreach($permissions_all as $row)





                                                            <div class="col-md-6 mb-1">           @if(in_array_r($row['id'],@$permissions))
                                                                    <div class="per_active icheckbox_flat-blue checked"
                                                                         data-pid="{{$row['id']}}"
                                                                         data-uid="{{$hrm->id}}" data-active="1"></div>
                                                                @else
                                                                    <div class="per_active icheckbox_flat-aero"
                                                                         data-pid="{{$row['id']}}"
                                                                         data-uid="{{$hrm->id}}" data-active="0"></div>
                                                                @endif {{trans('permissions.'.$row['name'])}}


                                                            </div>


                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="active4" aria-labelledby="link-tab4"
                                                     role="tabpanel">


                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.salary')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{numberFormat($hrm->meta['salary'])}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.hra')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{numberFormat($hrm->meta['hra'])}}%</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.entry_time')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->meta['entry_time']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.exit_time')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$hrm->meta['exit_time']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('hrms.sales_commission')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{numberFormat($hrm->meta['commission'])}}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="active7" aria-labelledby="link-tab7"
                                                     role="tabpanel">

                                                    <table id="attendance-table"
                                                           class="table table-striped table-bordered zero-configuration"
                                                           cellspacing="0"
                                                           width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ trans('hrms.employees') }}</th>
                                                            <th>{{ trans('general.date') }}</th>
                                                            <th>{{ trans('hrms.entry_time') }}</th>
                                                            <th>{{ trans('hrms.exit_time') }}</th>

                                                        </tr>
                                                        </thead>


                                                        <tbody></tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="sidebar-detached sidebar-left">
                <div class="sidebar">
                    <div class="bug-list-sidebar-content">
                        <!-- Predefined Views -->
                        <div class="card">
                            <div class="card-head">
                                <div class="media-body media p-1">
                                    <div class="media-middle pr-1"><span
                                                class="avatar avatar-lg rounded-circle ml-2"><img
                                                    src="{{Storage::disk('public')->url('app/public/img/users/' . $hrm->picture)}}"
                                                    alt="avatar"><i></i></span></div>

                                </div>
                                <div class="media-body media-middle p-1">
                                    <h5 class="media-heading">{{$hrm['first_name'].' '.$hrm['last_name']}} </h5>
                                    ({{$hrm->role['name']}})
                                </div>
                                <div class="media-middle pr-1"><span
                                            class="avatar avatar-lg rounded-circle ml-2"><img
                                                src="{{Storage::disk('public')->url('app/public/img/signs/' . $hrm->signature)}}"
                                                alt="sign"><i></i></span></div>
                            </div>

                            <div class="card-body">
                                <p class="lead"> {{trans('general.related')}}</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="badge badge-primary badge-pill float-right">{{$hrm->invoices->count('id')}}</span>
                                        <a href="{{route('biller.invoices.index')}}?rel_type=2&rel_id={{$hrm->id}}">
                                            {{trans('invoices.invoices_c')}}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="badge bg-purple badge-pill float-right">{{$hrm->amount->count('id')}}</span>
                                        <a href="{{route('biller.transactions.index')}}?rel_type=2&rel_id={{$hrm->id}}">
                                            {{trans('transactions.transactions')}}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="badge bg-purple badge-pill float-right">{{$hrm->payroll->count('id')}}</span>
                                        <a href="{{route('biller.transactions.index')}}?rel_type=3&rel_id={{$hrm->id}}">
                                            {{trans('hrms.payroll')}}</a>
                                    </li>

                                </ul>
                            </div>
                            <!--/ Groups-->


                        </div>
                        <!--/ Predefined Views -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script>

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', ".per_active", function (e) {
                var pid = $(this).attr('data-pid');
                var uid = $(this).attr('data-uid');
                var active = $(this).attr('data-active');
                if (active == 1) {
                    $(this).removeClass('checked');
                    $(this).attr('data-active', 0);
                } else {
                    $(this).addClass('checked');
                    $(this).attr('data-active', 1);
                }

                $.ajax({
                    url: '{{ route("biller.hrms.set_permission") }}',
                    type: 'post',
                    data: {'pid': pid, 'uid': uid, 'active': active}
                });
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('hrm_tab', $(e.target).attr('href'));
                switch ($(e.target).attr('href')) {
                    case '#active7':
                        attend();
                        break;
                }
            });
            var project_tab = localStorage.getItem('hrm_tab');
            if (project_tab) {
                $('a[href="' + project_tab + '"]').tab('show');
            }


        });

        function attend() {
            if ($('#attendance-table tbody').is(":empty")) {
                var dataTable = $('#attendance-table').dataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    language: {
                        @lang('datatable.strings')
                    },
                    ajax: {
                        url: '{{ route("biller.hrms.attendance_load") }}',
                        type: 'post',
                        data: {rel_id:{{$hrm->id}}}
                    },
                    columns: [
                        {data: 'DT_Row_Index', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'present', name: 'present'},
                        {data: 't_from', name: 't_from'},
                        {data: 't_to', name: 't_to'}

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
                $('#attendance-table_wrapper').removeClass('form-inline');
            }
        }
    </script>
@endsection