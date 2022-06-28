@extends ('core.layouts.app')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('meta.email_settings') }}</h4>

                </div>

            </div>
            <div class="content-body"> {{ Form::open(['route' => 'biller.business.email_settings_update', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="">

                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        <div class='col-md-6'>
                                            {{ Form::label( 'host',trans('meta.email_system'),['class' => 'col control-label']) }}
                                            <div class='col'>
                                                <select name="active"
                                                        class="round form-control change_smtp" id="active">
                                                    {!! $smtp['active']  == 0 ? "<option value='0' selected>--".trans('meta.default_server')."--</option>" : "<option value='1' selected>--".trans('meta.custom_server')."--</option>" !!}
                                                    <option value="0">{{trans('meta.default_server')}}</option>
                                                    <option value="1">{{trans('meta.custom_server')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row mb-1' id="mail_config"
                                         @if(!$smtp['active']) style="display: none;" @endif>

                                        <div class='col-6'>
                                            <div class='form-group'>
                                                {{ Form::label( 'host', 'SMTP Host',['class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('host', @$smtp['host'], ['class' => 'form-control box-size', 'placeholder' => 'SMTP Host']) }}
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                {{ Form::label( 'port', 'Port',['class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('port', @$smtp['port'], ['class' => 'form-control box-size', 'placeholder' => 'Port']) }}
                                                </div>
                                            </div>
                                            <div class='form-group'>

                                                {{ Form::label( 'auth', 'Auth',['class' => 'col control-label']) }}
                                                <div class='col-6'>

                                                    <select name="auth"
                                                            class="round form-control">
                                                        {!! $smtp['auth']  == true ? "<option value='true' selected>--".trans('general.yes')."--</option>" : "<option value='false' selected>--".trans('general.no')."--</option>" !!}
                                                        <option value="true">{{trans('general.yes')}}</option>
                                                        <option value="false">{{trans('general.no')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                {{ Form::label( 'auth_type', 'Auth Type',['class' => 'col control-label']) }}
                                                <div class='col-6'>
                                                    <select name="auth_type"
                                                            class="round form-control">

                                                        <option value="{{$smtp['auth_type']}}">-{{$smtp['auth_type']}}
                                                            -
                                                        </option>
                                                        <option value="none">None</option>
                                                        <option value="ssl">SSL</option>
                                                        <option value="tls">TLS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class='form-group'>
                                                {{ Form::label( 'username', 'Username',['class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('username', @$smtp['username'], ['class' => 'form-control box-size', 'placeholder' => 'Username']) }}
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                {{ Form::label( 'password', 'Password',['class' => 'col control-label']) }}
                                                <div class='col'>
                                                    <input type="password" value="{{@$smtp['password']}}"
                                                           class="form-control box-size" placeholder="Password" name="password">
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                {{ Form::label( 'sender', 'Sender',['class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::email('sender', @$smtp['sender'], ['class' => 'form-control box-size', 'placeholder' => 'Sender']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="edit-form-btn">
                                        {{ link_to_route('biller.dashboard', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                        <div class="clearfix"></div>
                                        <!--edit-form-btn-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--sms-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        <div class='col-md-6'>
                                            {{ Form::label( 'host',trans('meta.sms_gateway'),['class' => 'col control-label']) }}
                                            <div class='col'>
                                                <select name="sms_active"
                                                        class="round form-control custom_gateway" id="custom_gateway">
                                                    {!! $sms['active']  == 0 ? "<option value='0' selected>--".trans('meta.default_server')."--</option>" : "<option value='1' selected>--".trans('meta.custom_gateway')."--</option>" !!}
                                                    <option value="0">{{trans('meta.default_server')}}</option>
                                                    <option value="1">{{trans('meta.custom_gateway')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row mb-1' id="custom_gateway_config"
                                         @if(!$sms['active']) style="display: none;" @endif>
                                        <div class='col-md-12'>
                                            {{ Form::label( 'host',trans('meta.sms_gateway'),['class' => 'col control-label']) }}
                                            <div class='col-md-6'>
                                                <select name="s_driver_id"
                                                        class="round form-control custom_gateway" id="driver_id">


                                                    <option value="1"
                                                            data-c_fields='{"s_username":"Account SID","s_password":"Twilio Token","s_sender":"Twilio phone number"}'
                                                            @if($sms['driver_id']==1) selected @endif>Twilio
                                                    </option>
                                                    <option value="2"
                                                            data-c_fields='{"s_username":"Api Key","s_sender":"Sender ID"}'
                                                            @if($sms['driver_id']==2) selected @endif>TextLocal
                                                    </option>
                                                    <option value="3"
                                                            data-c_fields='{"s_username":"Api Key","s_sender":"Sender ID"}'
                                                            @if($sms['driver_id']==3) selected @endif>Clockwork
                                                    </option>
                                                    <option value="4"
                                                            data-c_fields='{"s_username":"Api Key","s_sender":"Sender ID"}'
                                                            @if($sms['driver_id']==4) selected @endif>msg91
                                                    </option>
                                                    <option value="5"
                                                            data-c_fields='{"s_username":"Username","s_password":"Password","s_sender":"Sender ID"}'
                                                            @if($sms['driver_id']==5) selected @endif>BulkSMS Gateway
                                                        (bulksms.in)
                                                    </option>
                                                    <option value="7"
                                                            data-c_fields='{"s_username":"Data"}'
                                                            @if($sms['driver_id']==7) selected @endif>{{trans('meta.generic')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                {{ Form::label( 's_username', 's_username',['id'=>'s_username','class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('s_username', @$sms['username'], ['class' => 'form-control box-size', 'placeholder' => '']) }}
                                                </div>
                                            </div>
                                            <div class='form-group' id="pass_section">
                                                {{ Form::label( 's_password', 's_password',['id'=>'s_password','class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('s_password', @$sms['password'], ['class' => 'form-control box-size', 'placeholder' => '']) }}
                                                </div>
                                            </div>
                                            <div class='form-group' id="sender_section">
                                                {{ Form::label( 's_sender', 's_sender',['id'=>'s_sender','class' => 'col control-label']) }}
                                                <div class='col'>
                                                    {{ Form::text('s_sender', @$sms['sender'], ['class' => 'form-control box-size', 'placeholder' => '']) }}
                                                </div>
                                            </div>
                                            <div class="form-group alert alert-info" id="generic_api"
                                                 style="display: none">
                                                <div class='col-md-12 message'>
                                                    Generic SMS Format : <br><strong>send_field_name=</strong><i>{to_mobile}</i>,<strong>message_field_name=</strong><i>{to_message}</i>,<strong>METHOD=POST</strong>,<strong>URL=</strong><i>http://api.example.com/xyz,field1=abc,field2=YYY</i>
                                                </div>
                                            </div>


                                            <input type="hidden" name="s_driver" id="driver"
                                                   value="{{@$sms['driver']}}">


                                        </div>
                                    </div>
                                    <div class="edit-form-btn">
                                        {{ link_to_route('biller.dashboard', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.url_shorten')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p class="warning">You can enable shorten URLs in your SMS to shrink the total
                                        size
                                        of a message. Please get your bit.ly token from your bit.ly developer
                                        section</p>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'url_shorten', trans('meta.url_shorten_enable'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select name="url_shorten_enable"
                                                    class="round form-control">
                                                {!! $url_short['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}
                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'token', trans('meta.token'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>

                                            <input class="form-control round" name="url_token" type="text"
                                                   value="{{$url_short['value2']}}">
                                        </div>
                                    </div>
                                    <div class="edit-form-btn">
                                        {{ link_to_route('biller.dashboard', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                        <div class="clearfix"></div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    <script>
        $(function () {

            load_sms_fields();


        });

        $("#active").on("change", function (e) {
            if ($(this).val() == 0) {
                $("#mail_config").hide();
            } else {
                $("#mail_config").show();
            }
        });

        $("#custom_gateway").on("change", function (e) {
            if ($(this).val() == 0) {
                $("#custom_gateway_config").hide();
            } else {
                $("#custom_gateway_config").show();
            }
        });

        $("#driver_id").on("change", function (e) {

            load_sms_fields();
        });


        function load_sms_fields() {
            if ($("#driver_id :selected").val() == 1 || $("#driver_id :selected").val() == 5) {
                $("#pass_section").show();
            } else {
                $("#pass_section").hide();
            }
            if ($("#driver_id :selected").val() == 7) {
                $("#sender_section").hide();
                $("#generic_api").show();

            } else {
                $("#sender_section").show();
            }
            $("#driver").val($("#driver_id :selected").text());

            var gateway = $("#driver_id :selected").attr('data-c_fields');
            var fields = $.parseJSON(gateway);

            $.each(fields, function (k, v) {
                $("#" + k).text(v);
            });
        }
    </script>
@endsection