<div class='form-group'>
    {{ Form::label( 'code', trans('currencies.code'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('code', null, ['class' => 'form-control round', 'placeholder' => trans('currencies.code'),'maxlength '=>3]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'symbol', trans('currencies.symbol'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        {{ Form::text('symbol', null, ['class' => 'form-control round', 'placeholder' => trans('currencies.symbol'),'maxlength '=>3]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'rate', trans('currencies.rate'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        @if(isset($currencies))
            {{ Form::text('rate', null, ['class' => 'form-control round', 'placeholder' => trans('currencies.rate'),'onkeypress'=>"return isNumber(event)",'maxlength '=>10]) }}
        @else
            {{ Form::text('rate', 1, ['class' => 'form-control round', 'placeholder' => trans('currencies.rate'),'onkeypress'=>"return isNumber(event)",'maxlength '=>10]) }}
        @endif
        <small>{{trans('currencies.rate_info')}}</small>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'thousand_sep', trans('currencies.thousand_sep'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>

        <select name="thousand_sep" class="form-control round">
            @if(isset($currencies))

                <option value="{{$currencies->thousand_sep}}"> {{ $currencies->thousand_sep }} </option>
            @endif
            <option value=",">, (Comma)</option>
            <option value=".">. (Dot)</option>
        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'decimal_sep', trans('currencies.decimal_sep'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        <select name="decimal_sep" class="form-control round">
            @if(isset($currencies))
                <option value="{{$currencies->decimal_sep}}"> {{ $currencies->decimal_sep }} </option>
            @endif
            <option value=".">. (Dot)</option>
            <option value=",">, (Comma)</option>

        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'precision_point', trans('currencies.precision_point'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>

        <select name="precision_point" class="form-control round">
            @if(isset($currencies))
                <option value="{{$currencies->precision_point}}">--{{ $currencies->precision_point }}--</option>
            @endif
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'symbol_position', trans('currencies.symbol_position'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-3'>
        <select name="symbol_position" class="form-control round">
            @if(isset($currencies))
                <option value="{{$currencies->symbol_position}}">
                    --{{ ($currencies->symbol_position==1) ? trans('currencies.left') : trans('currencies.right') }}--
                </option>
            @endif
            <option value="1">{{trans('currencies.left')}}</option>
            <option value="0">{{trans('currencies.right')}}</option>
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
