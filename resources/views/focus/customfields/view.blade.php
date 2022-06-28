@extends ('core.layouts.app')

@section ('title', trans('labels.backend.customfields.management') . ' | ' . trans('labels.backend.customfields.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.customfields.management') }}
        <small>{{ trans('labels.backend.customfields.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ trans('labels.backend.customfields.view') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.customfields.partials.customfields-header-buttons')
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

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.name')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$customfield['name']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.module_id')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>
                                                @php  switch ($customfield['module_id']){
                     case 1:  echo trans('customers.customer');
                     break;
                     case 2: echo trans('invoices.invoice');
                     break;
                     case 3: echo trans('products.product');
                     break;
                     case 4 : echo trans('quotes.quotes');
                     break;
                     case 5 : echo trans('orders.credit_notes');
                     break;
                 }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.field_type')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$customfield['field_type']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.placeholder')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$customfield['placeholder']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.default_data')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$customfield['default_data']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('customfields.field_view')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>
                                                @php  switch ($customfield['field_view']){
                     case 1:  echo trans('customfields.public');
                     break;
                     case 2: echo trans('customfields.private');
                     break;

                 }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
