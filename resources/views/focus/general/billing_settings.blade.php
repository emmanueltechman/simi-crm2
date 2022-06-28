@extends ('core.layouts.app')
@section ('title', trans('business.business_settings'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('business.business_settings') }}</h4>

                </div>

            </div>
            <div class="content-body "> {{ Form::open(['route' => 'biller.business.billing_settings_update', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}
                @if($data['section']==1)
                    <div class="row match-height ">
                        <div class="col-xl-6 col-lg-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans('meta.email_alert_settings') }}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body round">
                                        <div class='row mb-1'>
                                            {{ Form::label( 'new_transaction_alert', trans('meta.new_transaction_alert'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>
                                                <select class="form-control round" name="new_transaction_alert">
                                                    {!! $defaults[11][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                    <option value="1">{{trans('general.yes')}}</option>
                                                    <option value="0">{{trans('general.no')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-1'>
                                            {{ Form::label( 'delete_transaction_alert', trans('meta.delete_transaction_alert'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>
                                                <select class="form-control round" name="delete_transaction_alert">
                                                    {!! $defaults[11][0]['value1']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                    <option value="1">{{trans('general.yes')}}</option>
                                                    <option value="0">{{trans('general.no')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row mb-1'>
                                            {{ Form::label( 'delete_invoice_alert', trans('meta.delete_invoice_alert'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>
                                                <select class="form-control round" name="delete_invoice_alert">
                                                    {!! $defaults[12][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                    <option value="1">{{trans('general.yes')}}</option>
                                                    <option value="0">{{trans('general.no')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            {{ Form::label( 'sender', 'Sender',['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>


                                                {{ Form::email('sender', @$defaults[12][0]['value1'], ['class' => 'form-control round', 'placeholder' => 'Sender']) }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @else
                <div class="row match-height">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans('business.billing_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'warehouse', trans('general.tax'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.additionals.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> <i
                                                        class="ft-arrow-right font-medium-1"></i></a>
                                            <select class="form-control round"
                                                    name="tax">
                                                @php
                                                    $tax_format='exclusive';
                                                    $tax_format_id=0;
                                                @endphp
                                                @foreach($data['additionals'] as $additional_tax)
                                                    @php
                                                        if($additional_tax->id == $defaults[4][0]['feature_value']  && $additional_tax->class === 1){
                                                         echo '<option  value="'.$additional_tax->id.'" selected>--'.$additional_tax->name.'--</option>';
                                                         $tax_format=$additional_tax->type2;
                                                         $tax_format_id=$additional_tax->id;
                                                        }

                                                    @endphp
                                                    {!! $additional_tax->class == 1 ? "<option value='$additional_tax->id'>$additional_tax->name</option>" : "" !!}

                                                @endforeach

                                                <option value="0" data-type1="%" data-type2="off"
                                                        data-type3="off">{{trans('general.off')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'discount', trans('general.discount'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.additionals.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>
                                            <select name="discount" class="form-control round">
                                                @php
                                                    $discount_format='%';
                                                @endphp
                                                @foreach($data['additionals'] as $additional_discount)
                                                    @php
                                                        if($defaults[3][0]['feature_value'] == $additional_discount->id && $additional_discount->class === 2){
                                                         echo '<option value='.$additional_tax->id.' selected>--'.$additional_discount->name.'--</option>';
                                                         $discount_format=$additional_discount->type1;
                                                        }

                                                    @endphp
                                                    {!! $additional_discount->class == 2 ? "<option value='$additional_tax->id'>$additional_discount->name</option>" : "" !!}
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        {{ Form::label( 'warehouse', trans('warehouses.warehouse'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.warehouses.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>
                                            <select name="warehouse"
                                                    class="form-control round">

                                                @foreach($data['warehouses'] as $warehouse)
                                                    <option value="0">{{trans('general.all')}}</option>
                                                    {!! $defaults[1][0]['feature_value']  == $warehouse->id ? "<option value='".$warehouse->id."' selected>--".$warehouse->title."--</option>" : "" !!}
                                                    <option value="{{$warehouse->id}}">{{$warehouse->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans('business.payment_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'currency', trans('currencies.currency'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.currencies.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>
                                            <select name="currency"
                                                    class="round form-control">
                                                <option value="0">Default</option>
                                                @foreach($data['currencies'] as $currency)
                                                    <option value="0">{{trans('general.all')}}</option>
                                                    {!! $defaults[2][0]['feature_value']  == $currency->id ? "<option value='".$currency->id."' selected>--".$currency->symbol." (".$currency->code.")--</option>" : "" !!}
                                                    <option value="{{$currency->id}}">{{$currency->symbol}}
                                                        - {{$currency->code}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'online_payment', trans('payments.online_payment'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round" name="online_payment">
                                                {!! $defaults[5][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0" data-type1="%" data-type2="off"
                                                        data-type3="off">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'payment_account', trans('payments.online_payment_account'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.accounts.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>

                                            <select class="form-control round"
                                                    name="payment_account">
                                                @foreach($data['accounts'] as $account)

                                                    {!! $defaults[6][0]['feature_value']  == $account->id ? "<option value='".$account->id."' selected>--".$account->holder." (".$account->number.")--</option>" : "" !!}
                                                    <option value="{{$account->id}}">{{$account->holder}}
                                                        - {{$account->number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('transactioncategories.transactioncategories')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'sales_transaction_category', trans('meta.sales_transaction_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red"
                                                               href="{{route('biller.transactioncategories.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>
                                            <select name="sales_transaction_category"
                                                    class="round form-control">
                                                @foreach($data['transaction_categories'] as $transaction_category)
                                                    <option value="0">{{trans('general.all')}}</option>
                                                    {!! $defaults[8][0]['feature_value']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        {{ Form::label( 'purchase_transaction_category', trans('meta.purchase_transaction_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round"
                                                    name="purchase_transaction_category">
                                                @foreach($data['transaction_categories'] as $transaction_category)
                                                    <option value="0">{{trans('general.all')}}</option>
                                                    {!! $defaults[10][0]['feature_value']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.localization')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'date_format', trans('meta.date_format'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select class="form-control round" name="date_format">
                                                <option value='{{config('core.main_date_format')}}' selected>
                                                    -{{config('core.main_date_format')}}-
                                                </option>
                                                <option value="d-m-Y">d-m-Y ({{trans('meta.day_month_year')}})
                                                </option>
                                                <option value="Y-m-d">Y-m-d ({{trans('meta.year_month_day')}})
                                                </option>
                                                <option value="m-d-Y">m-d-Y ({{trans('meta.month_day_year')}})
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'date_format_user', trans('meta.date_format_user'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select class="form-control round" name="date_format_user">
                                                <option value='{{config('core.user_date_format')}}' selected>
                                                    -{{config('core.user_date_format')}}-
                                                </option>
                                                <option value="DD-MM-YYYY">{{trans('meta.day_month_year')}}</option>
                                                <option value="YYYY-MM-DD">{{trans('meta.year_month_day')}}</option>
                                                <option value="MM-DD-YYYY">{{trans('meta.month_day_year')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'time_zone', trans('meta.time_zone'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select class="form-control round" name="time_zone">
                                                <option value='{{config('core.zone')}}' selected>
                                                    -{{config('core.zone')}}-
                                                </option>
                                                <option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
                                                <option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
                                                <option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
                                                <option value="US/Alaska">(UTC-09:00) Alaska</option>
                                                <option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US
                                                    &amp;
                                                    Canada)
                                                </option>
                                                <option value="America/Tijuana">(UTC-08:00) Tijuana</option>
                                                <option value="US/Arizona">(UTC-07:00) Arizona</option>
                                                <option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
                                                <option value="America/Chihuahua">(UTC-07:00) La Paz</option>
                                                <option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
                                                <option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option value="America/Managua">(UTC-06:00) Central America</option>
                                                <option value="US/Central">(UTC-06:00) Central Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option value="America/Mexico_City">(UTC-06:00) Guadalajara</option>
                                                <option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
                                                <option value="America/Monterrey">(UTC-06:00) Monterrey</option>
                                                <option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan
                                                </option>
                                                <option value="America/Bogota">(UTC-05:00) Bogota</option>
                                                <option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
                                                <option value="America/Lima">(UTC-05:00) Lima</option>
                                                <option value="America/Bogota">(UTC-05:00) Quito</option>
                                                <option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)
                                                </option>
                                                <option value="America/Caracas">(UTC-04:30) Caracas</option>
                                                <option value="America/La_Paz">(UTC-04:00) La Paz</option>
                                                <option value="America/Santiago">(UTC-04:00) Santiago</option>
                                                <option value="Canada/Newfoundland">(UTC-03:30) Newfoundland
                                                </option>
                                                <option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
                                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos
                                                    Aires
                                                </option>
                                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown
                                                </option>
                                                <option value="America/Godthab">(UTC-03:00) Greenland</option>
                                                <option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
                                                <option value="Atlantic/Azores">(UTC-01:00) Azores</option>
                                                <option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.
                                                </option>
                                                <option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
                                                <option value="Europe/London">(UTC+00:00) Edinburgh</option>
                                                <option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin
                                                </option>
                                                <option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
                                                <option value="Europe/London">(UTC+00:00) London</option>
                                                <option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
                                                <option value="UTC">(UTC+00:00) UTC</option>
                                                <option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
                                                <option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
                                                <option value="Europe/Berlin">(UTC+01:00) Berlin</option>
                                                <option value="Europe/Berlin">(UTC+01:00) Bern</option>
                                                <option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
                                                <option value="Europe/Brussels">(UTC+01:00) Brussels</option>
                                                <option value="Europe/Budapest">(UTC+01:00) Budapest</option>
                                                <option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
                                                <option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
                                                <option value="Europe/Madrid">(UTC+01:00) Madrid</option>
                                                <option value="Europe/Paris">(UTC+01:00) Paris</option>
                                                <option value="Europe/Prague">(UTC+01:00) Prague</option>
                                                <option value="Europe/Rome">(UTC+01:00) Rome</option>
                                                <option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
                                                <option value="Europe/Skopje">(UTC+01:00) Skopje</option>
                                                <option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
                                                <option value="Europe/Vienna">(UTC+01:00) Vienna</option>
                                                <option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
                                                <option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
                                                <option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
                                                <option value="Europe/Athens">(UTC+02:00) Athens</option>
                                                <option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
                                                <option value="Africa/Cairo">(UTC+02:00) Cairo</option>
                                                <option value="Africa/Harare">(UTC+02:00) Harare</option>
                                                <option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
                                                <option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
                                                <option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
                                                <option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
                                                <option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
                                                <option value="Europe/Riga">(UTC+02:00) Riga</option>
                                                <option value="Europe/Sofia">(UTC+02:00) Sofia</option>
                                                <option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
                                                <option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
                                                <option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
                                                <option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
                                                <option value="Europe/Minsk">(UTC+03:00) Minsk</option>
                                                <option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
                                                <option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
                                                <option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
                                                <option value="Asia/Tehran">(UTC+03:30) Tehran</option>
                                                <option value="Asia/Muscat">(UTC+04:00) Abu Dhabi</option>
                                                <option value="Asia/Baku">(UTC+04:00) Baku</option>
                                                <option value="Europe/Moscow">(UTC+04:00) Moscow</option>
                                                <option value="Asia/Muscat">(UTC+04:00) Muscat</option>
                                                <option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
                                                <option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
                                                <option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
                                                <option value="Asia/Kabul">(UTC+04:30) Kabul</option>
                                                <option value="Asia/Karachi">(UTC+05:00) Islamabad</option>
                                                <option value="Asia/Karachi">(UTC+05:00) Karachi</option>
                                                <option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Chennai</option>
                                                <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Mumbai</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) New Delhi</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
                                                <option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
                                                <option value="Asia/Almaty">(UTC+06:00) Almaty</option>
                                                <option value="Asia/Dhaka">(UTC+06:00) Astana</option>
                                                <option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
                                                <option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
                                                <option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
                                                <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
                                                <option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
                                                <option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
                                                <option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
                                                <option value="Asia/Hong_Kong">(UTC+08:00) Beijing</option>
                                                <option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
                                                <option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
                                                <option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
                                                <option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
                                                <option value="Australia/Perth">(UTC+08:00) Perth</option>
                                                <option value="Asia/Singapore">(UTC+08:00) Singapore</option>
                                                <option value="Asia/Taipei">(UTC+08:00) Taipei</option>
                                                <option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
                                                <option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
                                                <option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Osaka</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Sapporo</option>
                                                <option value="Asia/Seoul">(UTC+09:00) Seoul</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
                                                <option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
                                                <option value="Australia/Darwin">(UTC+09:30) Darwin</option>
                                                <option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
                                                <option value="Australia/Canberra">(UTC+10:00) Canberra</option>
                                                <option value="Pacific/Guam">(UTC+10:00) Guam</option>
                                                <option value="Australia/Hobart">(UTC+10:00) Hobart</option>
                                                <option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
                                                <option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby
                                                </option>
                                                <option value="Australia/Sydney">(UTC+10:00) Sydney</option>
                                                <option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
                                                <option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
                                                <option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
                                                <option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
                                                <option value="Pacific/Kwajalein">(UTC+12:00) International Date Line
                                                    West
                                                </option>
                                                <option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
                                                <option value="Asia/Magadan">(UTC+12:00) Magadan</option>
                                                <option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
                                                <option value="Asia/Magadan">(UTC+12:00) New Caledonia</option>
                                                <option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
                                                <option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
                                                <option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.dual_entry')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'token', trans('meta.dual_entry'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round" name="dual_entry">
                                                {!! $defaults[13][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'payment_account', trans('payments.sales_payment_account'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.accounts.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>

                                            <select class="form-control round"
                                                    name="sales_payment_account">
                                                @foreach($data['accounts'] as $account)

                                                    {!! $defaults[13][0]['value1']  == $account->id ? "<option value='".$account->id."' selected>--".$account->holder." (".$account->number.")--</option>" : "" !!}
                                                    <option value="{{$account->id}}">{{$account->holder}}
                                                        - {{$account->number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'payment_account', trans('payments.purchase_payment_account'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red" href="{{route('biller.accounts.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>

                                            <select class="form-control round"
                                                    name="purchase_payment_account">
                                                @foreach($data['accounts'] as $account)

                                                    {!! $defaults[13][0]['value2']  == $account->id ? "<option value='".$account->id."' selected>--".$account->holder." (".$account->number.")--</option>" : "" !!}
                                                    <option value="{{$account->id}}">{{$account->holder}}
                                                        - {{$account->number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'token', trans('accounts.account_types'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: Basic,Assets,Income,Expenses</small>
                                            <input class="form-control round" name="account_type" type="text"
                                                   value="{{$account_types}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.auto_sms_email')}}</h4>
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
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.theme_direction')}}
                                    & {{trans('meta.file_upload')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'token', trans('meta.file_format'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: jpeg,gif,png,pdf,xls</small>
                                            <input class="form-control round" name="file_format" type="text"
                                                   value="{{$defaults[9][0]['value1']}}">
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'theme_direction', trans('meta.theme_direction'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select name="theme_direction"
                                                    class="round form-control">
                                                {!! $defaults[15][0]['value1']  == 'ltr' ? "<option value='ltr' selected>--".trans('meta.ltr')."--</option>" : "<option value='rtl' selected>--".trans('meta.rtl')."--</option>" !!}
                                                <option value="ltr">{{trans('meta.ltr')}}</option>
                                                <option value="rtl">{{trans('meta.rtl')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.default_status')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {{trans('meta.default_status_info')}}
                                    <div class='row mb-1'>
                                        {{ Form::label( 'default_done_status', trans('meta.default_done_status'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select class="form-control round" name="default_done_status">
                                                @foreach($data['status'] as $status)
                                                    @php
                                                        if($defaults[16][0]['feature_value'] == $status->id){
                                                         echo '<option value='.$status->id.' selected>--'.$status->name.'--</option>';

                                                        }
echo '<option value='.$status->id.' >'.$status->name.'</option>';
                                                    @endphp

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'default_cancelled_status', trans('meta.default_cancelled_status'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select class="form-control round" name="default_cancelled_status">
                                                @foreach($data['status'] as $status)
                                                    @php
                                                        if($defaults[16][0]['value1'] == $status->id){
                                                         echo '<option value='.$status->id.' selected>--'.$status->name.'--</option>';

                                                        }
echo '<option value='.$status->id.' >'.$status->name.'</option>';
                                                    @endphp

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
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
                                        <div class='col-12'>
                                            <select name="url_shorten_enable"
                                                    class="round form-control">
                                                {!! $defaults[7][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}
                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        {{ Form::label( 'token', trans('meta.token'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <input class="form-control round" name="url_token" type="text"
                                                   value="{{$defaults[7][0]['value2']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card" style="">
                            <div class="card-header">
                                <h4 class="card-title">{{trans('meta.notification_email')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body"><p>{{trans('meta.notification_email_info')}}</p>
                                    <div class='row'>

                                        <div class='col-12'>
                                            <input type="email" class="form-control round" name="notification_mail"
                                                   value="{{ $defaults[1][0]['value2']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            <div class="card-body">
                {{ link_to_route('biller.dashboard', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                <div class="clearfix"></div>
                <!--edit-form-btn-->{{ Form::close() }}
            </div>
        </div>
    </div>

@endsection
