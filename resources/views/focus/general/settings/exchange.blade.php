@extends ('core.layouts.app')
@section ('title', trans('currencies.currency_exchange'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.currency_exchange_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('currencies.currency_exchange') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(!$conf['readonly']) <p>Application has integrated currencylayer.com API. It
                                        offers a real-time currency conversion for your invoices. Accurate Exchange
                                        Rates for 168 World Currencies with data updates ranging from every 60 minutes
                                        down to stunning 60 seconds.</p><p class="mb-4">Please visit currencylayer.com
                                        to get API key and do not forget set the CRON job for automatic base rate
                                        updates in background.</p>
                                    @endif
                                    <div class='row mb-1'>
                                        {{ Form::label( 'enable', trans('currencies.currency_exchange_title'),['class' => 'col-12 control-label']) }}
                                        <div class='col-6'>
                                            <select class="form-control round" name="enable">
                                                {!! $conf['enable']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}
                                                <option value="1">{{trans('general.yes')}}</option>
                                                <option value="0">{{trans('general.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="@if($conf['readonly']) display:none @endif">
                                        <div class='row mb-1'>
                                            {{ Form::label( 'key', trans('currencies.exchange_api'),['class' => 'col-12 control-label']) }}
                                            <div class='col-6'>
                                                <input class="form-control round" name="key" type="text"
                                                       value="{{$conf['key']}}" {{$conf['readonly']}}>
                                            </div>
                                        </div>
                                        <div class='row mb-1'>
                                            {{ Form::label( 'base_currency', trans('currencies.base_currency'),['class' => 'col-12 control-label']) }}
                                            <div class='col-6'>
                                                <input class="form-control round" name="base_currency" type="text"
                                                       value="{{$conf['base_currency']}}" {{$conf['readonly']}}>
                                            </div>
                                        </div>
                                        <div class='row mb-1'>
                                            {{ Form::label( 'api_end_point', trans('currencies.api_end_point'),['class' => 'col-12 control-label']) }}
                                            <div class='col-6'>
                                                <input class="form-control round" name="endpoint" type="text"
                                                       value="{{$conf['endpoint']}}" {{$conf['readonly']}}>
                                            </div>
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
    </div>
@endsection
