{{ Form::open(['route' => ['biller.import.general_post','products'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'import-data']) }}
<input type="hidden" name="update" value="1">
{!! Form::file('import_file', array('class'=>'form-control input col-md-6 mb-1' )) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'productcategory_id', trans('products.productcategory_id'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="productcategory" id="product_cat">
                    @foreach($data['product_category'] as $item)
                        @if(!$item->c_type)
                            <option value="{{$item->id}}" {{ $item->id == @$products->productcategory_id ? " selected" : "" }}>{{$item->title}}</option>
                        @endif
                    @endforeach

                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'productcategory_id', trans('products.warehouse_id'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="warehouse">

                    @foreach($data['warehouses'] as $item)
                        <option value="{{$item->id}}" {{ $item->id == @$products->warehouse_id ? " selected" : "" }}>{{$item->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
        <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'product_images', trans('en.remote_image'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="image">
                        <option value="0" selected>{{trans('general.no')}}</option>
                        <option value="1">{{trans('general.yes')}}</option>
                </select>
                <small>{{trans('en.remote_image_info')}}</small>
            </div>
        </div>
    </div>
</div>
{{ Form::submit(trans('import.upload_import'), ['class' => 'btn btn-primary btn-md']) }}
{{ Form::close() }}
