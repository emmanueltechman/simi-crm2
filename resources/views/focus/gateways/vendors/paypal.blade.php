@extends ('core.layouts.public_app')
@section('content')

    <?php
    $rming = $invoice['total'] - $invoice['pamnt'];
    if ($invoice['status'] == 'due') {
        $rming = $invoice['total'];
    }
    $surcharge_t = false;

    $row = $gateway->config;

    $title = $gateway['name'];
    if ($row['surcharge'] > 0) {
        $surcharge_t = true;
        $fee = '( ' . amountFormat($rming, $invoice['currency']) . '+' . amountFormat($row['surcharge']) . ' %)';
    } else {
        $fee = '';


    }
    ?>
    <section class="card">
        <div class="card-header">
            <h4 class="card-title  text-center">{{trans('payments.secure_checkout')}}
                ({{$general['bill_type']}} #{{$invoice['tid']}})</h4>
        </div>
        <div class="card-body center">

            <?php
            $attributes = array('class' => 'row justify-content-md-center', 'id' => 'login_form');
            // echo form_open('billing/gateway_process', $attributes);
            ?>

            <?php echo '<input type="hidden" class="form-control" name="id" value="' . $invoice['id'] . '"/><input type="hidden" class="form-control" name="type" value="1"/>
                <input type="hidden" class="form-control" name="token" value="' . $token . '"/>'; ?>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <h5><?php


                            $rming = $invoice['total'] - $invoice['pamnt'];

                            $surcharge_t = false;
                            $row = $gateway;
                            $cid = $row['id'];
                            $title = $row['name'];
                            $fee = '';

                            echo $title . ' ' . $fee ?></h5><img class="bg-white round mt-1"
                                                                 style="max-width:30rem;max-height:6rem"
                                                                 src="{{ Storage::disk('public')->url('app/public/img/gateway_logo/' . $row->config['user_gateway_id'].'.png') }}">
                        <input type="hidden" class="form-control" name="gateway" value="<?= $cid ?>">
                    </div>
                    <div class="form-group">
                        <label for="cardNumber">{{$general['bill_type']}}
                            #{{$invoice['tid']}} {{trans('general.total')}}</label>
                        <input name="total_amount"
                               value="<?php echo amountFormat($invoice['total'], $invoice['currency']) ?>"
                               type="text"
                               class="form-control"


                               readonly/> <input name="amount"
                                                 value="<?php echo numberClean($invoice['total']) ?>"
                                                 type="hidden"
                                                 class="form-control"


                                                 readonly/>


                    </div>
                    <div class="form-group">
                        <label for="cardNumber">{{trans('general.balance_due')}}   </label>
                        <input name="total_amount"
                               value="<?php
                               echo amountFormat($rming, $invoice['currency']); ?>"
                               type="text"
                               class="form-control"
                               readonly/>
                    </div>

                    <div class="row">
                        <div class="col-12">  <div id="paypal-button-container"></div>

                        </div>
                          <div class="col-12">  <div id="paypal-processing" class="alert alert-purple" style="display: none;"><span class="text-white"><i class="ft-refresh-ccw spinner"></i> Payment processing , please do NOT press any key or button.....</span></div>
                              <div id="paypal-done" class="alert alert-purple" style="display: none;"><span class="text-white"><i class="ft-check-circle"></i> {{trans('templates.invoice_payment_received')}}. <a href="{{route( 'biller.view_bill',[$invoice['id'],1,$token,0])}}" class="btn btn-success"><i class="ft-eye"></i>  View Invoice</a></span></div>

                        </div>
                    </div>
                    @if($row->config['surcharge'])
                        <div class="form-group info alert">
                            {{$row->config['surcharge']}}% {{trans('usergatewayentries.surcharge_applicable')}}
                        </div>
                    @endif
                    <div class="row" style="display:none;">
                        <div class="col">
                            <p class="payment-errors"></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <script src="https://www.paypal.com/sdk/js?client-id={{$gateway->config['key1']}}&disable-funding=credit,card"></script>
    <script>
        // Render the PayPal button into #paypal-button-container
       // X-CSRF-TOKEN is also required to add in request, otherwise you will not be able to access the createorder url
        paypal.Buttons({
            // Call your server to set up the transaction
            createOrder: function(data, actions) {
                var _token = "{{ csrf_token() }}";
                return fetch('{{route( 'biller.process_card',[$invoice['id'],1,$token,2,$invoice['ins']])}}', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': _token,
                        'Content-Type': 'application/json',
                    },
                }).then(function(res) {
                     document.getElementById('paypal-processing').style.display = 'block';
                     document.getElementById('paypal-button-container').style.display = 'none';
                    return res.json();
                }).then(function(orderData) {

                    return orderData.result.id;
                });
            },
            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                var _token = "{{ csrf_token() }}";

                return fetch('{{route('biller.index')}}/paypal_capture/' + data.orderID + '/capture', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': _token,
                        'Content-Type': 'application/json',
                    },
                }).then(function(res) {

                    return res.json();
                }).then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show a success / thank you message
                    // Your server defines the structure of 'orderData', which may differ
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];
                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        // Recoverable state, see: "Handle Funding Failures"
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                     document.getElementById('paypal-processing').style.display = 'none';
                     document.getElementById('paypal-button-container').style.display = 'block';
                        return actions.restart();
                    }
                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        // Show a failure message
                     document.getElementById('paypal-processing').style.display = 'none';
                     document.getElementById('paypal-button-container').style.display = 'block';
                        return alert(msg);
                    }
                    // Show a success message to the buyer
                    document.getElementById('paypal-processing').style.display = 'none';
                    document.getElementById('paypal-done').style.display = 'block';
                  //  alert('Transaction completed by ' + orderData.result.payer.name.given_name);
                });
            },
            onCancel : function () {
                     document.getElementById('paypal-processing').style.display = 'none';
                     document.getElementById('paypal-button-container').style.display = 'block';
            }

        }).render('#paypal-button-container');
    </script>

@endsection
