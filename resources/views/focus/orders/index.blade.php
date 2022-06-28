@extends ('core.layouts.app')

@section ('title', $words['title'])

@section('page-header')
    <h1>{{ trans('labels.backend.orders.management') }}</h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ $words['title'] }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.orders.partials.orders-header-buttons',$words)
                        </div>
                    </div>
                </div>
            </div>
            @if($segment)
                @php
                    $total=$segment->orders->sum('total');
                    $paid=$segment->orders->sum('pamnt');
                    $due=$total-$paid;
                @endphp
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{$words['name']}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{$words['name_data']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{trans('customers.email')}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{$segment->email}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{trans('general.total_amount')}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{amountFormat($total)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{trans('payments.paid_amount')}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{amountFormat($paid)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>{{trans('general.balance_due')}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p>{{amountFormat($due)}}</p>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-2">{{ trans('general.search_date')}} </div>
                                        <div class="col-md-2">
                                            <input type="text" name="start_date" id="start_date"
                                                   data-toggle="datepicker"
                                                   class="date30 form-control form-control-sm" autocomplete="off"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="end_date" id="end_date"
                                                   class="form-control form-control-sm"
                                                   data-toggle="datepicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="button" name="search" id="search" value="Search"
                                                   class="btn btn-info btn-sm"/>
                                        </div>

                                    </div>
                                    <hr>
                                    <table id="orders-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('orders.order')}} #{{$words['prefix']}}</th>
                                            <th>{{$words['person']}}</th>
                                            <th>{{ trans('orders.invoicedate') }}</th>
                                            <th>{{ trans('general.amount') }}</th>
                                            <th>{{ trans('general.status') }}</th>
                                            <th>{{ trans('labels.general.actions') }}</th>

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

            $('#search').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                if (start_date != '' && end_date != '') {
                    $('#orders-table').DataTable().destroy();
                    draw_data(start_date, end_date);
                } else {
                    alert("Date range is Required");
                }
            });
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');

        });

        function draw_data(start_date = '', end_date = '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#orders-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.orders.get") }}',
                    type: 'post',
                    data: {
                        @if($segment) i_rel_id: '{{$segment['id']}}',
                        i_rel_type: '{{$input['rel_type']}},'
                        @endif 'section': '{{$words['section']}}', start_date: start_date, end_date: end_date
                    },
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'tid', name: 'tid'},
                    {data: 'customer', name: 'customer'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[1, "asc"]],
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
            $('#orders-table_wrapper').removeClass('form-inline');

        }
    </script>
@endsection
