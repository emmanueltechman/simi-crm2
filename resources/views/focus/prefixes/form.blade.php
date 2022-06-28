<div class='form-group'>
    {{ Form::label( 'value', trans('prefixes.value'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-2'>
        {{ Form::text('value', null, ['class' => 'form-control round', 'placeholder' => trans('prefixes.value')]) }}
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
