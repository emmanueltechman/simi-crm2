<div class='form-group'>
    {{ Form::label( 'title', trans('customergroups.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control round', 'placeholder' => trans('customergroups.title').'*','required'=>'required']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'summary', trans('customergroups.summary'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('summary', null, ['class' => 'form-control round', 'placeholder' => trans('customergroups.summary')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'disc_rate', trans('customergroups.disc_rate'),['class' => 'col-lg-2 control-label']) }}(%)
    <div class='col-lg-3'>
        {{ Form::text('disc_rate', null, ['class' => 'form-control round', 'placeholder' => trans('customergroups.disc_rate'),'onkeypress'=>"return isNumber(event)"]) }}
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
