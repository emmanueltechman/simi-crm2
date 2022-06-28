@extends ('core.layouts.app')
@section ('title', trans('meta.notification_email'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.notification_email_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}


                <div class="row">
                    <div class="col-xl-12 col-lg-12 ">
                        <div class="card">
                            <div class="card-header  border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('meta.email_alert_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body round"><p class="alert alert-info">Please, do not enable these
                                        alerts unnecessarily, it may slow the invoice and transactions creation process
                                        as the application will connect to email and SMS server. For multiple addresses <strong class="ml-1">mail1@email.com<strong>+</strong>mail2@email.com</strong></p>
                                    <div class='row'>
                                        {{ Form::label( 'sender', trans('meta.alert_address'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            {{ Form::text('sender', $email, ['class' => 'form-control round', 'placeholder' => 'Sender']) }}
                                            <small class="ml-2">mail1@email.com<strong class="danger">+</strong>mail2@email.com</small> </div>
                                    </div>
                                    <hr class="mb-3">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'new_trans', trans('meta.new_transaction_alert'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="new_trans">
                                                {!! $data['new_trans']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'del_trans', trans('meta.delete_transaction_alert'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="del_trans">
                                                {!! $data['del_trans']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="mb-3">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'new_invoice', trans('meta.new_invoice_alert'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="new_invoice">
                                                {!! $data['new_invoice']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class='row mb-1'>
                                        {{ Form::label( 'del_invoice', trans('meta.delete_invoice_alert'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="del_invoice">
                                                {!! $data['del_invoice']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="mb-3">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'cust_new_invoice', trans('meta.customer_new_invoice_alert'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="cust_new_invoice">
                                                {!! $data['cust_new_invoice']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'sms_new_invoice', trans('meta.customer_new_invoice_sms'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="sms_new_invoice">
                                                {!! $data['sms_new_invoice']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="mb-3">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'task_new', trans('tasks.new_task'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>

                                            <select class="form-control round" name="task_new">
                                                {!! $data['task_new']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class=''>
                                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-bottom-blue-grey">
                        <h4 class="card-title">{{ trans('meta.notification_email') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body"><p>{{trans('meta.notification_email_info')}}</p>
                            <div class='row'>

                                <div class='col-md-6'>
                                    <input type="text" class="form-control round" name="notification_mail"
                                           value="{{feature(1)->value2}}" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=''>
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                    </div>
                </div>


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
