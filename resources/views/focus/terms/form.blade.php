<div class='form-group'>
    {{ Form::label( 'title', trans('terms.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control round', 'placeholder' => trans('terms.title')]) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label( 'type', trans('terms.type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="type">
            @php
                switch (@$terms['type']){
                case 1 : echo  '<option value="'.$terms['type'].'">--'.trans('invoices.invoices').'--</option>';
                break;
                 case 2 : echo  '<option value="'.$terms['type'].'">--'.trans('quotes.quote').'--</option>';
                break;
                 case 3 : echo  '<option value="'.$terms['type'].'">--'.trans('orders.general_bills').'--</option>';
                break;
                default : echo  '<option value="0">--'.trans('general.all').'--</option>';


                }
            @endphp
            <option value="1">{{trans('invoices.invoices')}}</option>
            <option value="2">{{trans('quotes.quotes')}}</option>
            <option value="3">{{trans('orders.general_bills')}}</option>
            <option value="0">{{trans('general.all')}}</option>
        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'terms', trans('terms.terms'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::textarea('terms', null, ['class' => 'form-control round', 'placeholder' => trans('terms.terms')]) }}
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
