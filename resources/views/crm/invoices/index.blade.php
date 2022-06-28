@extends ('crm.layouts.app')

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

            </div>

            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">

                                    <hr>
                                    <table id="invoices-table_{{$input['meta']}}"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('invoices.invoice')}} </th>
                                            <th>{{ trans('customers.customer') }}</th>
                                            <th>{{ trans('invoices.invoice_date') }}</th>
                                            <th>{{ trans('general.amount') }}</th>
                                            <th>{{ trans('general.status') }}</th>
                                            <th>{{ trans('invoices.invoice_due_date') }}</th>

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
    </div>
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
            draw_data();

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
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("crm.invoices.get") }}',
                    type: 'post'

                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'tid', name: 'tid'},
                    {data: 'customer', name: 'customer'},
                    {data: 'invoicedate', name: 'invoicedate'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'invoiceduedate', name: 'invoiceduedate'},

                ],
                orderBy: [[1, "desc"]],
                searchDelay: 500,
                dom: 'Blfrtip',
                buttons: {
                    buttons: [

                        {extend: 'csv', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}},
                        {extend: 'excel', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}},
                        {extend: 'print', footer: true, exportOptions: {columns: [1, 2, 3, 4, 5]}}
                    ]
                }
            });
            $('#invoices-table_{{$input['meta']}}_wrapper').removeClass('form-inline');
        }
    </script>
@endsection
