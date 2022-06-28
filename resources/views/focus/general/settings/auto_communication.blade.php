@extends ('core.layouts.app')
@section ('title', trans('meta.auto_communication'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.auto_communication', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('meta.auto_sms_email') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row'>
                                        {{ Form::label( 'tokenc', trans('meta.auto_sms_email'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12 mb-1'>
                                            <p>Send automatic Email and SMS during invoice creation to you customer.
                                                Please do not enable this feature unnecessarily, it may slow the invoice
                                                creation process as the application will connect to email and SMS
                                                server.</p>
                                            {{ Form::label( 'auto_email', trans('general.email'),['class' => 'col-12 control-label']) }}
                                            <select class="form-control round" name="auto_email">
                                                {!! $defaults[14][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                        {{ Form::label( 'auto_sms', trans('general.sms'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round" name="auto_sms">
                                                {!! $defaults[14][0]['value1']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

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


                        <!--edit-form-btn-->

                    </div>


                </div>


                {{ Form::close() }}
            </div>
        </div>

@endsection
