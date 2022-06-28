<div class="form-group">
    {{ Form::label( 'module_id', trans('customfields.module_id'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="module_id">
            @php
                switch (@$customfields['module_id']){
                case 1 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('customers.customer').'--</option>';
                break;
                 case 2 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('invoices.invoice').'--</option>';
                break;
                 case 3 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('products.product').'--</option>';
                break;
                 case 4 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('quotes.quotes').'--</option>';
                break;
                 case 5 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('orders.credit_notes').'--</option>';
                break;
                  case 6 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('major.company').'--</option>';
                break;
                }
            @endphp
            <option value="1">{{trans('customers.customer')}}</option>
            <option value="2">{{trans('invoices.invoice')}}</option>
            <option value="3">{{trans('products.products')}}</option>
            <option value="4">{{trans('quotes.quotes')}}</option>
            <option value="5">{{trans('orders.credit_notes')}}</option>
            <option value="6">{{trans('major.company')}}</option>

        </select>
    </div>
</div>
<div class="form-group">
    {{ Form::label( 'field_type', trans('customfields.field_type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="field_type">
            <option value="text">{{trans('customfields.text')}}</option>
        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'name', trans('customfields.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('customfields.name')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'placeholder', trans('customfields.placeholder'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('placeholder', null, ['class' => 'form-control round', 'placeholder' => trans('customfields.placeholder')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'default_data', trans('customfields.default_data'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('default_data', null, ['class' => 'form-control round', 'placeholder' => trans('customfields.default_data')]) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label( 'field_view', trans('customfields.field_view'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="field_view">
            @php
                switch (@$customfields['field_view']){
                case 1 : echo  '<option value="'.$customfields['field_view'].'">--'.trans('customfields.public').'--</option>';
                break;
                 case 2 : echo  '<option value="'.$customfields['module_id'].'">--'.trans('customfields.private').'--</option>';
                break;

                }
            @endphp
            <option value="1">{{trans('customfields.public')}}</option>
            <option value="2">{{trans('customfields.private')}}</option>
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
