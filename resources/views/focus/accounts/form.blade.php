
<div class='form-group'>
    {{ Form::label( 'holder', trans('accounts.holder'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('holder', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.holder').'*','required'=>'required']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'number', trans('accounts.number'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('number', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.number').'*','required'=>'required']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'balance', trans('transactions.credit'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('balance', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.balance'),'onkeypress'=>"return isNumber(event)"]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'balance', trans('transactions.debit'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('debit', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.balance'),'onkeypress'=>"return isNumber(event)"]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'code', trans('accounts.code'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('code', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.code')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'account_type', trans('accounts.account_type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select name="account_type" class='form-control'>
            @foreach($account_types as $row)
                <option value="{{$row}}" @if($row==@$accounts->account_type) selected @endif>{{$row}}</option>
            @endforeach
        </select>

    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'note', trans('accounts.note'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('note', null, ['class' => 'form-control box-size', 'placeholder' => trans('accounts.note')]) }}
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
