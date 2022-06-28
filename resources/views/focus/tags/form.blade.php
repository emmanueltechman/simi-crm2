<div class='form-group'>
    {{ Form::label( 'name', trans('tags.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('tags.name')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'color', trans('tags.color'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('color', null, ['class' => 'form-control round', 'placeholder' => trans('tags.color'),'id'=>'color','autocomplete'=>'off']) }}
    </div>
</div>
@section("after-styles")
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}
@endsection
@section("after-scripts")
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#color').colorpicker();
        });
    </script>
@endsection
