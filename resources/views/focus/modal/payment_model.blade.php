<!-- Modal HTML -->
<div id="modal_bill_payment_1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">{{trans('general.payment_confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment" id="bill_payment_1">
                    <div class="row">
                        <div class="col">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control required"
                                       placeholder="{{trans('general.total_amount')}}" name="amount"
                                       id="remains"
                                       value="{{numberFormat($invoice['total']-$invoice['pamnt'])}}"
                                       inputMode="numeric">
                                <div class="form-control-position font-small-2 blue"><span
                                            class="fa fa-credit-card "></span> {{config('currency.symbol')}}
                                </div>

                            </fieldset>


                        </div>
                        <div class="col">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control required"
                                       placeholder="{{trans('general.payment_date')}}" name="payment_date"
                                       data-toggle="datepicker">
                                <div class="form-control-position">
                      <span class="fa fa-calendar"
                            aria-hidden="true"></span>
                                </div>

                            </fieldset>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="method">{{trans('general.payment_method')}}</label>
                            <select name="method" class="form-control mb-1">
                                @foreach(payment_methods() as $payment_method)
                                    <option value="{{$payment_method}}">{{$payment_method}}</option>
                                @endforeach
                                <option value="Card">Card</option>
                                <option value="Wallet">Wallet {{trans('payments.wallet_balance')}}</option>
                            </select>
                            <label for="account_id">{{trans('accounts.account')}}</label>

                            <select name="account_id" class="form-control">
                                @foreach($accounts as $account)
                                    <option value="{{$account['id']}}">{{$account['number']}}
                                        - {{$account['holder']}}</option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="note">{{trans('general.note')}}</label>
                            <input type="text" class="form-control"
                                   name="note" placeholder="{{trans('general.note')}}"
                                   value="{{ $words['pay_note']}}"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="bill_id" id="invoiceid" value="{{$invoice['id']}}">
                        <button type="button" class="btn btn-warning"
                                data-dismiss="modal">{{trans('general.close')}}</button>
                        <input type="hidden" name="cid" value="{{$invoice['customer_id']}}">
                        <button type="button" class="btn btn-primary actionTransaction"
                                data-form="1">{{trans('general.make_payment')}}</button>
                        <input type="hidden" id="modal_error_message_1" value="{{trans('payments.payment_error')}}">
                        <input type="hidden" id="action_url_1" value="{{ route( 'biller.bill_payment' ) }}">
                        <input type="hidden" name="relation_id" value="{{$category}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>