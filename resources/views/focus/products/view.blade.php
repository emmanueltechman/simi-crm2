@extends ('core.layouts.app')

@section ('title', trans('labels.backend.products.management') . ' | ' . trans('labels.backend.products.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.products.management') }}
        <small>{{ trans('labels.backend.products.create') }}</small>
    </h1>
@endsection


@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-header">
                                    <h4 class="card-title">{{trans('products.general_product_details')}} <a
                                                href="{{route('biller.products.edit',[$product['id']])}}"
                                                class="btn btn-blue btn-outline-accent-5 btn-sm"><i
                                                    class="fa fa-pencil"></i> {{trans('buttons.general.crud.edit')}}</a>
                                    </h4>


                                </div>
                                <div class="card-body">

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.name')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">@if(!$product->stock_type)
                                                    ({{trans('products.service')}}) : @endif {{$product['name']}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><a
                                                        href="{{Storage::disk('public')->url('app/public/img/products/' .@$product->standard->image)}}"><img
                                                            class="media-object img-xl m-1 border"
                                                            src="{{Storage::disk('public')->url('app/public/img/products/' .@$product->standard->image)}}"
                                                            alt="Product Image"></a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.taxrate')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($product['taxrate'])}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.product_des')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{!!$product['product_des'] !!}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.productcategory_id')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold"><a
                                                        href="{{route('biller.products.index')}}?rel_type=0&rel_id={{$product->category->id}}">{{$product->category->title}}</a>
                                                - ({{@$product->subcategory->title}})
                                            </div>
                                        </div>
                                        <div class="row pb-3">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.unit')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$product['unit']}}</div>
                                        </div>
                                        <h4 class="card-title">{{trans('products.standard_details')}}</h4>
                                        <div class="row mt-3">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.warehouse_id')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold"><a
                                                        href="{{route('biller.warehouses.show',[$product->standard->warehouse['id']])}}">{{$product->standard->warehouse['title']}}</a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.price')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{amountFormat($product->standard['price'])}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.disrate')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($product->standard['disrate'])}}
                                                %
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.purchase_price')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{amountFormat($product->standard['purchase_price'])}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.qty')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($product->standard['qty'])}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.alert')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($product->standard['alert'])}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.code')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$product->standard['code']}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.barcode')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$product->standard['barcode']}}
                                                <span class="font-size-xsmall purple">({{$product['code_type']}})</span>
                                            </div>
                                        </div>

                                        @if(strtotime($product->standard['expiry']))
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.expiry')}}</div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{dateFormat($product->standard['expiry'])}}</div>
                                        </div>
                                        @endif
                                        @if(isset($product->variations[0]))

                                            <h4 class="card-title mt-3">{{trans('products.variation')}}</h4>

                                            @foreach($product->variations as $row)
                                                <div class="row  mt-3 fill_back">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.variations')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$row->name}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col"><a
                                                                href="{{Storage::disk('public')->url('app/public/img/products/' .$row->image)}}"><img
                                                                    class="media-object img-xl m-1 border"
                                                                    src="{{Storage::disk('public')->url('app/public/img/products/' .$row->image)}}"
                                                                    alt="Product Image"></a></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.warehouse_id')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                        <a href="{{route('biller.warehouses.show',[$row->warehouse['id']])}}">{{$row->warehouse['title']}}</a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.price')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{amountFormat($row->price)}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.disrate')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($row->disrate)}}
                                                        %
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.purchase_price')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{amountFormat($row->purchase_price)}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.qty')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($row->qty)}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.alert')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{numberFormat($row->alert)}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.code')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$row->code}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.barcode')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{$row->barcode}}
                                                        <span class="font-size-xsmall purple">({{$product['code_type']}})</span>
                                                    </div>
                                                </div>

                                               @if(strtotime($row->expiry))
                                                <div class="row">
                                                    <div class="col-3 border-blue-grey border-lighten-5  p-1">{{trans('products.expiry')}}</div>
                                                    <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">{{dateFormat($row->expiry)}}</div>
                                                </div>
                                                @endif
                                            @endforeach


                                        @endif

                                        {!! custom_fields_view(3,$product['id']) !!}

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
