<div class='form-group'>
    {{ Form::label( 'enable', trans('banks.enable'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="enable">
            @php
                switch (@$usergatewayentries['enable']){

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
<div class='form-group'>
    {{ Form::label( 'key1', trans('usergatewayentries.key1'),['class' => 'col-lg-2 control-label','id'=>'key1_l']) }}
    <div class='col-lg-10'>
        {{ Form::text('key1', null, ['class' => 'form-control round', 'placeholder' => trans('usergatewayentries.key1'),'id'=>'key1']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'key2', trans('usergatewayentries.key2'),['class' => 'col-lg-2 control-label','id'=>'key2_l']) }}
    <div class='col-lg-10'>
        {{ Form::text('key2', null, ['class' => 'form-control round', 'placeholder' => trans('usergatewayentries.key2'),'id'=>'key2']) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'currency', trans('usergatewayentries.currency'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('currency', null, ['class' => 'form-control round', 'placeholder' => trans('usergatewayentries.currency')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'dev_mode', trans('usergatewayentries.dev_mode'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="dev_mode">
            @php
                switch (@$usergatewayentries['dev_mode']){

                case 'true' : echo  '<option value="true">--'.trans('general.yes').'--</option>';
                break;
                 case 'false' : echo  '<option value="false">--'.trans('general.no').'--</option>';
                break;
                }
            @endphp

            <option value="true">{{trans('general.yes')}}</option>
            <option value="false">{{trans('general.no')}}</option>

        </select>
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'surcharge', trans('usergatewayentries.surcharge'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('surcharge', null, ['class' => 'form-control round', 'placeholder' => trans('usergatewayentries.surcharge')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'extra', trans('usergatewayentries.extra'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('extra', null, ['class' => 'form-control round', 'placeholder' => trans('usergatewayentries.extra')]) }}
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        $(function () {

            g_fields($("#user_gateway_id").val());

            $("#user_gateway_id").on("change", function (e) {
                g_fields($(this).val());
            });

            function g_fields(c_gateway) {
                switch (c_gateway) {
                    case '1':
                        $("#key1").attr('placeholder', 'Public Key');
                        $("#key1_l").text('Public Key');
                        $("#key2").attr('placeholder', 'Private Key');
                        $("#key2_l").text('Private Key');
                        break;
                    case '2':
                        $("#key1").attr('placeholder', 'MyPayPalClientId');
                        $("#key1_l").text('MyPayPalClientId');
                        $("#key2").attr('placeholder', 'MyPayPalSecret');
                        $("#key2_l").text('MyPayPalSecret');
                        break;
                }
            }
        });
    </script>
@endsection
