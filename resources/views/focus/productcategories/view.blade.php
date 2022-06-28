@extends ('core.layouts.app')

@section ('title', trans('labels.backend.productcategories.management') . ' | ' . trans('labels.backend.productcategories.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.productcategories.management') }}
        <small>{{ trans('labels.backend.productcategories.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="mb-0">{{ trans('labels.backend.productcategories.view') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.productcategories.partials.productcategories-header-buttons')
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
                                            <p>{{trans('productcategories.title')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$productcategory->title}} <a class="btn btn-purple round"
                                                                                 href="{{route('biller.products.index')}}?rel_type={{$productcategory->c_type}}&rel_id={{$productcategory->id}}"
                                                                                 title="List"><i class="fa fa-list"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('productcategories.extra')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$productcategory->extra}}</p>
                                        </div>
                                    </div>
                                    @if(!$productcategory['c_type'])
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{trans('productcategories.total_products')}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>{{numberFormat($productcategory->products->sum('qty'))}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{trans('productcategories.total_worth')}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>{{amountFormat($productcategory->products->sum('total_value'))}}</p>
                                            </div>
                                        </div> @endif


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
