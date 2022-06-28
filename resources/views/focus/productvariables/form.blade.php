<div class='form-group'>
    {{ Form::label( 'name', trans('productvariables.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('productvariables.name')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'code', trans('productvariables.code'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('code', null, ['class' => 'form-control round', 'placeholder' => trans('productvariables.code')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'type', trans('productvariables.type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::select('type', array('0'=>trans('productvariables.standard_type'),'1'=>trans('productvariables.multiple_type')), null,['id'=>'c_type','class' => 'form-control round']) }}
    </div>
</div>
<div class='form-group' id="child" style="display: none">
    {{ Form::label( 'val', trans('productvariables.val'),['class' => 'col-lg-6 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('val', null, ['class' => 'form-control round', 'placeholder' => trans('productvariables.val')]) }}
    </div>
</div>
<div class="card-bordered p-1">Standard Type unit can be selected during product creation , while Multiple Unit can be
    selected during billing.<br>
    Standard Type Unit Example is KG<br> Multiple Type Unit Example is Box with value of 50<br>During billing if product
    X has Kg Unit but sub-unit can be Box so KG*BOX=50KG
</div>
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
