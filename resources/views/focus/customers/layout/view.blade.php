@extends ('core.layouts.app',['page'=>'class="horizontal-layout horizontal-menu content-detached-left-sidebar app-contacts " data-open="click" data-menu="horizontal-menu" data-col="content-detached-left-sidebar"'])

@section ('title', trans('labels.backend.customers.management') . ' | ' . trans('labels.backend.customers.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.customers.management') }}
        <small>{{ trans('labels.backend.customers.create') }}</small>
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
                                        <!-- Task List table --><span class=" float-right m-1">

<a href="{{route('biller.customers.show',[$customer->id])}}" class="btn btn-blue btn-outline-accent-5 btn-sm"><i
            class="fa fa-eye"></i> {{trans('hrms.profile')}}</a>
                                      @if(access()->allow('wallet')) <a class="btn btn-pink btn-outline-accent-5 btn-sm"
                                                                        href="{{route('biller.customers.wallet')}}?rel_id={{$customer->id}}">
                                           <span class="icon-wallet"></span> {{trans('customers.wallet')}} </a>@endif
                                            @if(access()->allow('make-payment'))         <a href="#modal_bill_payment_1"
                                                                                            data-toggle="modal"
                                                                                            data-remote="false"
                                                                                            data-type="reminder"
                                                                                            class="btn btn-purple btn-outline-accent-5 btn-sm"
                                                                                            title="Partial Payment"><span
                                                        class="fa fa-money"></span> {{trans('general.make_payment')}} </a>
                                            @endif


                                            <a href="#sendEmailCustomer" data-toggle="modal"
                                               data-remote="false"
                                               class="btn btn-pink btn-outline-accent-5 btn-sm"><i
                                                        class="fa fa-paper-plane-o"></i> {{trans('general.email')}}
                                    </a>
 @if(access()->allow('edit-customer')) <a href="{{route('biller.customers.edit',[$customer->id])}}"
                                          class="btn btn-blue btn-outline-accent-5 btn-sm"><i
                                                        class="fa fa-pencil"></i> {{trans('buttons.general.crud.edit')}}</a> @endif  </span>
                                        <div class="card-body">

                                            @yield('customer_view')
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
                                                    src="{{Storage::disk('public')->url('app/public/img/customer/' . $customer->picture)}}"
                                                    alt="avatar"><i></i></span></div>

                                </div>
                                <div class="media-body media-middle p-1">
                                    <h5 class="media-heading">{{$customer['name']}} </h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <p class="lead"> {{trans('general.related')}}</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="badge badge-primary badge-pill float-right">{{numberFormat($customer->invoices->count('id'))}}</span>
                                        <a href="{{route('biller.invoices.index')}}?rel_type=1&rel_id={{$customer->id}}">
                                            {{trans('invoices.invoices_c')}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="badge bg-purple badge-pill float-right">{{numberFormat($customer->amount->count('id'))}}</span>
                                        <a href="{{route('biller.transactions.index')}}?rel_type=1&rel_id={{$customer->id}}">
                                            {{trans('transactions.transactions')}}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="badge bg-purple badge-pill float-right">{{amountFormat($customer->balance)}}</span>
                                        <a @if(access()->allow('wallet'))   href="{{route('biller.customers.wallet')}}?rel_id={{$customer->id}}" @endif>
                                            {{trans('customers.wallet')}} </a>
                                    </li>

                                </ul>
                            </div>
                            <!--/ Groups-->

                            <!-- contacts view -->
                            <div class="card-body border-top-blue-grey border-top-lighten-5">
                                <div class="list-group">

                                    <a href="{{route('biller.customers.create')}}?rel_type=1&rel_id={{$customer->id}}"
                                       class="list-group-item list-group-item-action "><i
                                                class="fa fa-plug"></i> {{trans('customers.add_contact')}}</a> <a
                                            class="list-group-item nav-link " id="active-tab4" data-toggle="tab"
                                            href="#active4" aria-controls="active1"
                                            role="tab"><i
                                                class="fa fa-address-book"></i> {{ trans('customers.contacts') }}</a>

                                </div>
                            </div>

                            <!-- Groups-->


                        </div>
                        <!--/ Predefined Views -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("focus.modal.customer_email_model")
    @include("focus.customers.modal.bulk_payment_model")
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
            $(document).on('click', ".customer_active", function (e) {
                var cid = $(this).attr('data-cid');
                var active = $(this).attr('data-active');
                if (active == 1) {
                    $(this).removeClass('checked');
                    $(this).attr('data-active', 0);
                } else {
                    $(this).addClass('checked');
                    $(this).attr('data-active', 1);
                }

         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                $.ajax({
                    url: '{{ route("biller.customers.active") }}',
                    type: 'post',
                    data: {'cid': cid, 'active': active}
                });
            });


            var dataTable = $('#customers-table').dataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("biller.customers.get") }}',
                    type: 'post',
                    data: {g_rel_id: '{{$customer['id']}}', g_rel_type: '1'},
                },
                columns: [

                    {data: 'name', name: 'name'},

                    {data: 'email', name: 'email'},
                    {data: 'address', name: 'address'},

                    {data: 'created_at', name: 'created_at'},
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
            $('#customers-table_wrapper').removeClass('form-inline');

            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ],
                popover: {}
            });

        });
    </script>
@endsection