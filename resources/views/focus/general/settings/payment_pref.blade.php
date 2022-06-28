@extends ('core.layouts.app')
@section ('title', trans('business.payment_preferences'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.payment_preference_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('business.payment_preferences') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class='row mb-2'>
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
                                    <div class='row mb-2'>
                                        {{ Form::label( 'token', trans('general.payment_methods'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: Bank Transfer,Cheque,Prepaid Card,Other]</small>
                                            <input class="form-control round" name="payment_methods" type="text"
                                                   value="{{$data['payment_methods']}}">
                                        </div>
                                    </div>
                                    <div class='row mb-2'>
                                        {{ Form::label( 'online_payment', trans('payments.online_payment'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red"
                                                               href="{{route('biller.usergatewayentries.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a>

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
