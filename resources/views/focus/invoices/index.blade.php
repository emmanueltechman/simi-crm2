@extends ('core.layouts.app')
@section ('title', trans('labels.backend.invoices.management'))
@section('page-header')
    <h1>{{ trans('labels.backend.invoices.management') }}</h1>
@endsection

@section('content')


    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ $input['title'] }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">

                            @include('focus.invoices.partials.invoices-header-buttons',$input)
                        </div>
                    </div>
                </div>
            </div>
            @if($segment)
                @php
                    $total=$segment->invoices->sum('total');
                    $paid=$segment->invoices->sum('pamnt');
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
                                    <table id="invoices-table_{{$input['meta']}}"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('invoices.invoice')}} #{{prefix($input['pre'])}}</th>
                                            <th>{{ trans('customers.customer') }}</th>
                                            <th>{{ trans('invoices.invoice_date') }}</th>
                                            <th>{{ trans('general.amount') }}</th>
                                            <th>{{ trans('general.status') }}</th>
                                            <th>{{ trans('invoices.invoice_due_date') }}</th>
                                           <th>{{ trans('orders.order') }}</th>
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
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
            setTimeout(function () {
                draw_data()
            }, {{config('master.delay')}});


            $('#search').click(function () {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                if (start_date != '' && end_date != '') {
                    $('#invoices-table_{{$input['meta']}}').DataTable().destroy();
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

            var dataTable = $('#invoices-table_{{$input['meta']}}').dataTable({
                    processing: true,
                    stateSave: true,
                    serverSide: true,
                    responsive: true,
                    "deferRender": true,

                    language: {
                        @lang('datatable.strings')
                    },
                    ajax: {
                        url: '{{ route("biller.invoices.get") }}',
                        type: 'post',
                        data: {
                            @if($segment) i_rel_id: '{{$segment['id']}}',
                            i_rel_type: '{{$input['rel_type']}}',@endif {!! $input['sub_json'] !!},
                        start_date: start_date,
                        end_date: end_date
                    },
                },
                columns
        :
            [
                {data: 'DT_Row_Index', name: 'id'},
                {data: 'tid', name: 'tid'},
                {data: 'customer', name: 'customer'},
                {data: 'invoicedate', name: 'invoicedate'},
                {data: 'total', name: 'total'},
                {data: 'status', name: 'status'},
                {data: 'invoiceduedate', name: 'invoiceduedate'},

               {data: 'order_id', name: 'order_id',visible:false},
                {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ],
                orderBy
        :
            [[1, "desc"]],
                searchDelay
        :
            500,
                dom
        :
            'Blfrtip',



                buttons
        :
            {
                buttons: [
                    {extend: 'csv', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}},
                    {extend: 'excel', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}},
                    {extend: 'print', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}}
                ]
            }
        })
            ;
            $('#invoices-table_{{$input['meta']}}_wrapper').removeClass('form-inline');
        }
    </script>
@endsection
