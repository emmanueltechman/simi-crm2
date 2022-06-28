<div class='form-group'>
    {{ Form::label( 'name', trans('banks.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('banks.name'),'required'=>'']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'bank', trans('banks.bank'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('bank', null, ['class' => 'form-control round', 'placeholder' => trans('banks.bank'),'required'=>'']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'number', trans('banks.number'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('number', null, ['class' => 'form-control round', 'placeholder' => trans('banks.number'),'required'=>'']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'code', trans('banks.code'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('code', null, ['class' => 'form-control round', 'placeholder' => trans('banks.code')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'note', trans('banks.note'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('note', null, ['class' => 'form-control round', 'placeholder' => trans('banks.note')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'address', trans('banks.address'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('address', null, ['class' => 'form-control round', 'placeholder' => trans('banks.address')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'branch', trans('banks.branch'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('branch', null, ['class' => 'form-control round', 'placeholder' => trans('banks.branch')]) }}
    </div>
</div>

<div class='form-group'>
    {{ Form::label( 'enable', trans('banks.enable'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="enable">
            @php
                switch (@$banks['enable']){

                case 'Yes' : echo  '<option value="yes">--'.trans('general.yes').'--</option>';
                break;
                 case 'No' : echo  '<option value="no">--'.trans('general.no').'--</option>';
                break;
                }
            @endphp

            <option value="Yes">{{trans('general.yes')}}</option>
            <option value="No">{{trans('general.no')}}</option>

        </select>
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
