<div class='form-group'>
    {{ Form::label( 'title', trans('productcategories.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('productcategories.title').'*','required'=>'required']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'extra', trans('productcategories.extra'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('extra', null, ['class' => 'form-control box-size', 'placeholder' => trans('productcategories.extra')]) }}
    </div>
</div>
@if(!isset($productcategories->id))
    <div class='form-group'>
        {{ Form::label( 'c_type', trans('productcategories.c_type'),['class' => 'col-lg-2 control-label']) }}
        <div class='col-lg-10'>
            <select class="form-control" name="c_type" id="c_type">
                @if(@$productcategory->c_type == 0)
                    <option value="0" selected>-{{trans('productcategories.parent')}}-</option> @endif
                <option value="0">{{trans('productcategories.parent')}}</option>
                <option value="1">{{trans('productcategories.child')}}</option>

            </select>

        </div>
    </div>

    <div class='form-group' id="child" style="display: none">
        {{ Form::label( 'rel_id', trans('productcategories.rel_id'),['class' => 'col-lg-2 control-label']) }}
        <div class='col-lg-10'>
            <select class="form-control" name="rel_id" id="product_cat">
                <option value="0">--{{trans('productcategories.rel_id')}}--</option>
                @foreach($product_category as $item)

                    <option value="{{$item->id}}" {{ $item->id == @$products->productcategory_id ? " selected" : "" }}>{{$item->title}}</option>

                @endforeach

            </select>
        </div>
    </div>
@endif
@section("after-scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $("#c_type").on('change', function () {
                var parent = $('#c_type :selected').val();
                if (parent) {
                    $('#child').toggle();
                } else {
                    $('#product_cat').val(0);
                    $('#child').toggle();
                }
            });
        });
    </script>
@endsection
