@extends ('crm.layouts.app')

@section ('title', trans('labels.backend.quotes.management'))


@section('content')


    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h4 class="content-header-title mb-0">{{ trans('labels.backend.quotes.management') }}</h4>

            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">

                    <div class="media-body media-right text-right">
                        @include('focus.quotes.partials.quotes-header-buttons')
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

                                <hr>
                                <table id="quotes-table"
                                       class="table table-striped table-bordered zero-configuration" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('quotes.quote')}} </th>
                                        <th>{{ trans('customers.customer') }}</th>
                                        <th>{{ trans('quotes.invoicedate') }}</th>
                                        <th>{{ trans('general.amount') }}</th>
                                        <th>{{ trans('general.status') }}</th>


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
    <div id="action_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('payments.approve')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>{{trans('payments.quote_approve')}}</p>
                </div>
                <div class="modal-footer">
                    <form id="approve_form">
                        <input type="hidden" id="object-id" value="">
                        <input type="hidden" id="action-url" value="{{route('crm.quotes.approve')}}">

                        <a href="" id="confirm_url" class="btn btn-success"
                        >{{trans('payments.approve')}}</a>
                        <button type="button" data-dismiss="modal"
                                class="btn">{{trans('general.cancel')}}</button>
                    </form>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#quotes-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave: true,
                language: {
                    @lang('datatable.strings')
                },
                ajax: {
                    url: '{{ route("crm.quotes.get") }}',
                    type: 'post',


                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id'},
                    {data: 'tid', name: 'tid'},
                    {data: 'customer', name: 'customer'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'}

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
            $('#quotes-table_wrapper').removeClass('form-inline');
        });

        function approve(id) {
            $('#object-id').val(id);
            $('#confirm_url').attr('href', '{{route('crm.quotes.approve')}}/' + id);
            $('#action_model').modal('toggle');

        }


    </script>
@endsection
