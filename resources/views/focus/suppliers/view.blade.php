@extends ('core.layouts.app',['page'=>'class="horizontal-layout horizontal-menu content-detached-left-sidebar app-contacts " data-open="click" data-menu="horizontal-menu" data-col="content-detached-left-sidebar"'])

@section ('title', trans('labels.backend.suppliers.management') . ' | ' . trans('labels.backend.customers.create'))

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
                                        <!-- Task List table -->
                                        <a href="{{route('biller.suppliers.edit',[$supplier->id])}}"
                                           class="btn btn-blue btn-outline-accent-5 btn-sm float-right"><i
                                                    class="fa fa-pencil"></i> {{trans('buttons.general.crud.edit')}}</a>
                                        <div class="card-body">

                                            <ul class="nav nav-tabs nav-top-border no-hover-bg "
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="active-tab1" data-toggle="tab"
                                                       href="#active1" aria-controls="active1" role="tab"
                                                       aria-selected="true">{{ trans('customers.billing_address') }}</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link " id="active-tab3" data-toggle="tab"
                                                       href="#active3" aria-controls="active3"
                                                       role="tab">{{ trans('customers.other_data') }}</a>
                                                </li>


                                            </ul>
                                            <div class="tab-content px-1 pt-1">
                                                <div class="tab-pane active in" id="active1"
                                                     aria-labelledby="active-tab1" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.name')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['name']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.phone')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['phone']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.email')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['email']}}</p>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.address')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['address']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.city')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['city']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.region')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['region']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.country')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['country']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.postbox')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['postbox']}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.company')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['company']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.taxid')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['taxid']}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="active3" aria-labelledby="link-tab3"
                                                     role="tabpanel">

                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.docid')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['docid']}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                            <p>{{trans('customers.custom1')}}</p>
                                                        </div>
                                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                            <p>{{$supplier['custom1']}}</p>
                                                        </div>
                                                    </div>


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
                                                    src="{{Storage::disk('public')->url('app/public/img/supplier/' . $supplier->picture)}}"
                                                    alt="avatar"><i></i></span></div>

                                </div>
                                <div class="media-body media-middle p-1">

                                    <h5 class="media-heading">{{$supplier['name']}} </h5>
                                    <h5 class="info"> {{trans('suppliers.supplier')}}</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <p class="lead"> {{trans('general.related')}}</p>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="badge badge-primary badge-pill float-right">{{$supplier->invoices->count('id')}}</span>
                                        <a href="{{route('biller.purchaseorders.index')}}?rel_type=1&rel_id={{$supplier->id}}">
                                            {{trans('purchaseorders.purchaseorder')}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="badge bg-purple badge-pill float-right">{{$supplier->amount->count('id')}}</span>
                                        <a href="{{route('biller.transactions.index')}}?rel_type=4&rel_id={{$supplier->id}}">
                                            {{trans('transactions.transactions')}}</a>
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
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
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



        });
    </script>
@endsection