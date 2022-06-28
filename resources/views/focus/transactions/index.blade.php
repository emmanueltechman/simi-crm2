@extends ('core.layouts.app')

@section ('title', trans('labels.backend.transactions.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.transactions.management') }}</h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="mb-0">{{ trans('labels.backend.transactions.management') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.transactions.partials.transactions-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($input['rel_type']))
                <div class="card">

                    <div class="card-body">


                        @if($input['rel_type']==0)
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{$words['name']}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{$words['name_data']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('general.description')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{$segment['note']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.debit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('debit'))}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.credit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('credit'))}}</p>
                                </div>
                            </div>
                        @endif
                        @if($input['rel_type']==9)
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{$words['name']}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{$words['name_data']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('accounts.number')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{$segment['number']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.debit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('debit'))}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.credit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('credit'))}}</p>
                                </div>
                            </div>
                        @endif
                        @if($input['rel_type']>0 AND $input['rel_type']<9)
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{$words['name']}} </p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{!! $words['url']!!}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('customers.email')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{$segment['email']}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.debit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('debit'))}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p>{{trans('transactions.credit')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{amountFormat($segment->amount->sum('credit'))}}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    <table id="transactions-table"
                                           class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.backend.transactions.table.id') }}</th>
                                            <th>{{ trans('transactions.account_id') }}</th>
                                            <th>{{ trans('transactions.trans_category_id') }}</th>
                                            <th>{{ trans('transactions.debit') }}</th>
                                            <th>{{ trans('transactions.credit') }}</th>
                                            <th>{{ trans('transactions.payer') }}</th>
                                            <th>{{trans('transactions.payment_date')}}</th>
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

            var dataTable = $('#transactions-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,

                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("biller.transactions.get") }}',
                    type: 'post',
                    @if(isset($input['rel_type'])) data: {
                        p_rel_id: '{{$input['rel_id']}}',
                        p_rel_type: '{{$input['rel_type']}}'
                    },@endif
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'account_id', name: 'account_id'},
                    {data: 'trans_category_id', name: 'trans_category_id'},
                    {data: 'debit', name: 'debit'},
                    {data: 'credit', name: 'credit'},
                    {data: 'payer', name: 'payer'},
                    {data: 'payment_date', name: 'payment_date'},
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
            $('#transactions-table_wrapper').removeClass('form-inline');

        }
    </script>
@endsection
