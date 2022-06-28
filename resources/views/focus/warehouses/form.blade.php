<div class='form-group'>
    {{ Form::label( 'title', trans('warehouses.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('warehouses.title')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'extra', trans('warehouses.extra'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('extra', null, ['class' => 'form-control box-size', 'placeholder' => trans('warehouses.extra')]) }}
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $(document).ready(function () {
            //Everything in here would execute after the DOM is ready to manipulated.
        });
    </script>
@endsection
