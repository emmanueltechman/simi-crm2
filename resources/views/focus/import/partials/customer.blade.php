{{ Form::open(['route' => ['biller.import.general_post','customer'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'import-data']) }}
<input type="hidden" name="update" value="1">
{!! Form::file('import_file', array('class'=>'form-control input col-md-6 mb-1' )) !!}
<div class='row mb-1'>
    {{ Form::label( 'customer_password_type', trans('import.customer_password'),['class' => 'col-md-12 control-label']) }}
    <div class='col-md-4'>
        <select class="form-control round" name="customer_password_type">
            <option value="0">{{trans('import.customer_password_auto')}}</option>
            <option value="1">{{trans('import.customer_password_manual')}}</option>
        </select>
    </div>
</div>
<div class='row mb-1'>
    {{ Form::label( 'customer_password', trans('import.customer_password'),['class' => 'col-md-12 control-label']) }}
    <div class='col-md-4'>
        {{ Form::text('customer_password', null,['class' => 'form-control box-size round', 'placeholder' => trans('import.customer_password')]) }}
    </div>
</div>
{{ Form::submit(trans('import.upload_import'), ['class' => 'btn btn-primary btn-md']) }}
{{ Form::close() }}
