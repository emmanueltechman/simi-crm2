@extends ('focus.customers.layout.view')
@section('customer_view')
    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified"
        role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="active-tab1" data-toggle="tab"
               href="#active1" aria-controls="active1" role="tab"
               aria-selected="true">{{ trans('customers.billing_address') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="active-tab2" data-toggle="tab"
               href="#active2" aria-controls="active2"
               role="tab">{{ trans('customers.shipping_address') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="active-tab3" data-toggle="tab"
               href="#active3" aria-controls="active3"
               role="tab">{{ trans('customers.other_data') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="active-tab4" data-toggle="tab"
               href="#active4" aria-controls="active4"
               role="tab">{{ trans('customers.contacts') }}</a>
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
                    <p>{{$customer['name']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.phone')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['phone']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.email')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['email']}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.gid')}}</p>
                </div>
                <div class="col p-1">
                    <p>@foreach ($customer->group as $row)
                            <a class="badge bg-purple"
                               href="{{route('biller.customergroups.show',[$row->group_data->id]) }}"><i
                                        class="fa fa-anchor"></i> {{$row->group_data->title}}
                            </a>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.address')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['address']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.city')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['city']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.region')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['region']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.country')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['country']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.postbox')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['postbox']}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.company')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['company']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.taxid')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['taxid']}}</p>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="active2" aria-labelledby="link-tab2"
             role="tabpanel">
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.name_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['name_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.phone_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['phone_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.email_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['email_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.address_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['address_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.city_s')}}</p>
                </div>
                <div class="col-sm-6">
                    <p>{{$customer['city_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.region_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['region_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.country_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['country_s']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.postbox_s')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['postbox_s']}}</p>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="active3" aria-labelledby="link-tab3"
             role="tabpanel">
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.balance')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{amountFormat($customer['balance'])}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.docid')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['docid']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.custom1')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['custom1']}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-3 border-blue-grey border-lighten-5  p-1">
                    <p>{{trans('customers.discount_c')}}</p>
                </div>
                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <p>{{$customer['discount_c']}}</p>
                </div>
            </div>
            {!! custom_fields_view(1,$customer['id']) !!}
        </div>
        <div class="tab-pane" id="active4" aria-labelledby="link-tab3"
             role="tabpanel">
            <div class="table-responsive">
                <table id="customers-table"
                       class="table table-striped table-bordered zero-configuration font-small-2" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th>{{ trans('customers.name') }}</th>

                        <th>{{ trans('customers.email') }}</th>
                        <th>{{ trans('customers.address') }}</th>

                        <th>{{ trans('general.searchable') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>


                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
