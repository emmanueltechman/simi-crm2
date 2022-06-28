@extends ('core.layouts.app')
@section ('title', trans('business.accounts_settings'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.accounts_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('business.accounts_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'sales_transaction_category', trans('meta.sales_transaction_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'><a class="red"
                                                               href="{{route('biller.transactioncategories.index')}}"
                                                               target="_blank"><i
                                                        class="ft-plus-circle font-medium-1"></i> </a> <small>Use
                                                different categories to filter data properly.</small>
                                            <select name="sales_transaction_category"
                                                    class="round form-control">

                                                @foreach($data['transaction_categories'] as $transaction_category)
                                                    {!! $defaults[8][0]['feature_value']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-2'>
                                        {{ Form::label( 'purchase_transaction_category', trans('meta.purchase_transaction_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round"
                                                    name="purchase_transaction_category">

                                                @foreach($data['transaction_categories'] as $transaction_category)

                                                    {!! $defaults[10][0]['feature_value']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>       <div class='row mb-2'>
                                        {{ Form::label( 'income_transaction_category', trans('en.income_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round"
                                                    name="income_transaction_category">

                                                @foreach($data['transaction_categories'] as $transaction_category)

                                                    {!! $defaults[8][0]['value1']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>       <div class='row mb-5'>
                                        {{ Form::label( 'income_transaction_category', trans('en.expenses_category'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>

                                            <select class="form-control round"
                                                    name="expenses_transaction_category">

                                                @foreach($data['transaction_categories'] as $transaction_category)

                                                    {!! $defaults[10][0]['value1']  == $transaction_category->id ? "<option value='".$transaction_category->id."' selected>--".$transaction_category->name."--</option>" : "" !!}
                                                    <option value="{{$transaction_category->id}}">{{$transaction_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class='row mb-5'>
                                        {{ Form::label( 'token', trans('accounts.account_types'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: Basic,Assets,Income,Expenses</small>
                                            <input class="form-control round" name="account_type" type="text"
                                                   value="{{$account_types}}">
                                        </div>
                                    </div>
                                    <div class='row mb-5'>
                                        {{ Form::label( 'token', trans('general.payment_methods'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: Bank Transfer,Cheque,Prepaid Card,Other]</small>
                                            <input class="form-control round" name="payment_methods" type="text"
                                                   value="{{$payment_methods}}">
                                        </div>
                                    </div>
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
                                        {{ Form::label( 'payment_account', trans('payments.sales_payment_account').' - '.trans('meta.dual_entry'),['class' => 'col-12 control-label']) }}
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
                                        {{ Form::label( 'payment_account', trans('payments.purchase_payment_account').' - '.trans('meta.dual_entry'),['class' => 'col-12 control-label']) }}
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
