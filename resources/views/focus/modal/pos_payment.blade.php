<div class="modal fade" id="pos_payment" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <!-- Modal Header -->
            <div class="modal-header bg-gradient-directional-blue white">

                <h4 class="modal-title" id="myModalLabel">{{trans('pos.payment')}} ({{config('currency.symbol')}})</h4>
                <button type="button" class="close btn-danger" data-dismiss="modal" title="{{trans('general.close')}}">
                    <span>&times;</span>
                    <span class="sr-only">{{trans('pos.payment')}}</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">


                <div class="text-center">
                    <h1 id="mahayog">0.00</h1></div>
                <a class="payment_row_add btn btn-info btn-sm  float-right"><i class="fa fa-plus-circle"></i></a>
                <div id="amount_row">
                    <div id="payment_row" class="row payment_row">
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber">{{trans('general.amount')}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control  text-bold-600 blue-grey p_amount"
                                           name="p_amount[]" placeholder="Amount" onkeypress="return isNumber(e)"
                                           onkeyup="update_pay_pos()" inputMode="numeric">
                                    <span class="input-group-addon"><i class="icon icon-cash"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber">{{trans('general.payment_method')}}</label>
                                <select class="form-control" name="p_method[]">
                                    @foreach(payment_methods() as $payment_method)
                                        <option value="{{$payment_method}}">{{$payment_method}}</option>
                                    @endforeach
                                    <option value="Card">Card</option>
                                    <option value="Wallet">Wallet {{trans('payments.wallet_balance')}}</option>
                                </select></div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 red">
                            <label for="amount">{{trans('general.balance_due')}}</label>
                            <input type="text" class="form-control red" name="amount" id="balance1"
                                   onkeypress="return isNumber(e)" value="0.00" required="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group text-bold-600 text-g">
                            <label for="b_change">{{trans('pos.change')}}</label>
                            <input type="text" onkeypress="return isNumber(e)" class="form-control green"
                                   name="b_change" id="change_p" value="0">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group text-bold-600 text-g">
                        <label for="account_p">{{trans('accounts.account')}}</label>

                        <select name="p_account" id="p_account" class="form-control">
                            @foreach($accounts as $account)
                                <option value="{{$account['id']}}">{{$account['number']}}
                                    - {{$account['holder']}}</option>
                            @endforeach       </select></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-success btn-lg btn-block mb-1" type="submit" id="pos_basic_pay"
                                data-type="4"><i class="fa fa-arrow-circle-o-right"></i> {{trans('payments.pay_now')}}
                        + {{trans('general.print')}}</button> <button class="pos_basic_pay btn btn-info btn-lg btn-block mb-1" type="submit" id="pos_basic_pay_no"
                                          data-type="4" data-print_no="0"><i class="fa fa-arrow-circle-o-right"></i> {{trans('payments.pay_now')}}
                        </button>

                    </div>
                </div>

                <div class="row" style="display:none;">
                    <div class="col-xs-12">
                        <p class="payment-errors"></p>
                    </div>
                </div>


                <!-- shipping -->


            </div>


        </div>
    </div>
</div>
