@extends ('core.layouts.app')

@section ('title', trans('labels.backend.warehouses.management') . ' | ' . trans('labels.backend.warehouses.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.warehouses.management') }}
        <small>{{ trans('labels.backend.warehouses.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ trans('labels.backend.warehouses.view') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.warehouses.partials.warehouses-header-buttons')
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
                                            <p>{{trans('warehouses.title')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$warehouse->title}} <a class="btn btn-purple round"
                                                                           href="{{route('biller.products.index')}}?rel_type=2&rel_id={{$warehouse->id}}"
                                                                           title="List"><i class="fa fa-list"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('warehouses.extra')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$warehouse->extra}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('productcategories.total_products')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{numberFormat($warehouse->products->sum('qty'))}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('productcategories.total_worth')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{amountFormat($warehouse->products->sum('total_value'))}}</p>
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
