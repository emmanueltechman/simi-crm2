@extends ('core.layouts.public_app')
@section('after-styles')
    {!! Html::style('stripe/css/global.css') !!}
    {!! Html::style('stripe/css/normalize.css') !!}
@endsection
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
    <div class=" container-fluid">
        <div class="content-wrapper">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('payments.secure_checkout')}}
                        ({{$general['bill_type']}} #{{$invoice['tid']}})</h4>
                </div>
                <div class="card-body m-2">
                    <div class="row">
                        <div class="col-md-6"><span class="display-block text-center"><img class="bg-white round "
                                                                                           style="max-width:30rem;max-height:10rem"
                                                                                           src="{{ Storage::disk('public')->url('app/public/img/gateway_logo/' . $row['user_gateway_id'].'.png') }}"></span>
                            <div class="form-group">
                                <label for="cardNumber"> {{$general['bill_type']}}
                                    #{{$invoice['tid']}} {{trans('general.total')}}</label>
                                <input name="total_amount"
                                       value="<?php echo amountFormat($invoice['total'], $invoice['currency']) ?>"
                                       type="text"
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

                        </div>

                        <div id="p_form" class="col-md-6 ">

                            <section>
                                <div class="sr-root">
                                    <div class="sr-main">
                                        <form id="payment-form" class="sr-payment-form">
                                            <div class="sr-combo-inputs-row">
                                                <div class="sr-input sr-card-element" id="card-element"></div>
                                            </div>
                                            <div class="sr-field-error" id="card-errors" role="alert"></div>
                                            <button id="submit">
                                                <div class="spinner hidden" id="spinner"></div>
                                                <span id="button-text">{{trans('payments.pay_now')}}</span><span
                                                        id="order-amount"></span>
                                            </button>
                                        </form>

                                        <div class="sr-result hidden">
                                            <p>{{  trans('payments.completed') }} <br/><a
                                                        href="{{ $link['preview'] }}"
                                                        class="btn btn-blue">
                                                    <i class="fas fa-tachometer-alt mr-2"></i>{{  trans('payments.view_bill') }}
                                                </a></p>
                                            <pre>
            <code></code>
          </pre>
                                        </div>
                                    </div>
                                </div>

                            </section>
                        </div>@if($row['surcharge'])
                            <div class="form-group info alert">
                                {{$row['surcharge']}}% {{trans('usergatewayentries.surcharge_applicable')}}
                            </div>
                        @endif
                    </div>
                </div>
            </section>
            <section class="card">

                <div class="card-body bg-white"><img class="img-responsive pull-right"
                                                     src="{{ Storage::disk('public')->url('app/public/img/gateway_logo/ssl-seal.png') }}">
                </div>
            </section>

        </div>
    </div>

@endsection
@section('after-scripts')
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">

        // A reference to Stripe.js
        var stripe;

        var orderData = {
            items: [{id: "{{$invoice['tid']}}"}],
            currency: "{{$row['currency']}}"
        };

        // Disable the button until we have Stripe set up on the page
        document.querySelector("button").disabled = true;

        fetch("{{route('biller.stripe_api_request')}}?id={{$invoice['ins']}}", {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .then(function (result) {
                return result.json();
            })
            .then(function (data) {
                return setupElements(data);
            })
            .then(function ({stripe, card, clientSecret}) {
                document.querySelector("button").disabled = false;
                var form = document.getElementById("payment-form");
                form.addEventListener("submit", function (event) {
                    event.preventDefault();
                    pay(stripe, card, clientSecret);
                });
            });

        var setupElements = function (data) {
            stripe = Stripe(data.publishableKey);
            /* ------- Set up Stripe Elements to use in checkout form ------- */
            var elements = stripe.elements();
            var style = {
                base: {
                    color: "#32325d",
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: "antialiased",
                    fontSize: "16px",
                    "::placeholder": {color: "#aab7c4"}
                },
                invalid: {
                    color: "#fa755a",
                    iconColor: "#fa755a"
                }
            };

            var card = elements.create("card", {style: style});
            card.mount("#card-element");

            return {
                stripe: stripe,
                card: card,
                clientSecret: data.clientSecret
            };
        };

        var handleAction = function (clientSecret) {
            stripe.handleCardAction(clientSecret).then(function (data) {
                if (data.error) {
                    showError("Your card was not authenticated, please try again");
                } else if (data.paymentIntent.status === "requires_confirmation") {

                    fetch("{{route( 'biller.process_card',[$invoice['id'],1,$token,1,$invoice['ins']])}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            paymentIntentId: data.paymentIntent.id,
                            c_type: 'inv'
                        })
                    })
                        .then(function (result) {
                            return result.json();
                        })
                        .then(function (json) {
                            if (json.error) {
                                showError(json.error);
                            } else {
                                orderComplete(clientSecret);
                            }
                        });


                }
            });
        };

        /*
         * Collect card details and pay for the order
         */
        var pay = function (stripe, card) {
            changeLoadingState(true);

            // Collects card details and creates a PaymentMethod
            stripe
                .createPaymentMethod("card", card)
                .then(function (result) {
                    if (result.error) {
                        showError(result.error.message);
                    } else {
                        orderData.paymentMethodId = result.paymentMethod.id;
                        orderData.c_type = 'inv';

                        return fetch("{{route( 'biller.process_card',[$invoice['id'],1,$token,1,$invoice['ins']])}}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify(orderData)
                        });
                    }
                })
                .then(function (result) {
                    return result.json();
                })
                .then(function (response) {
                    if (response.error) {
                        showError(response.error);
                    } else if (response.requiresAction) {
                        // Request authentication
                        handleAction(response.clientSecret);
                    } else {
                        orderComplete(response.clientSecret);
                    }
                });
        };

        /* ------- Post-payment helpers ------- */

        /* Shows a success / error message when the payment is complete */
        var orderComplete = function (clientSecret) {
            stripe.retrievePaymentIntent(clientSecret).then(function (result) {
                var paymentIntent = result.paymentIntent;
                var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);

                document.querySelector(".sr-payment-form").classList.add("hidden");
                //  document.querySelector("pre").textContent = paymentIntentJson;

                document.querySelector(".sr-result").classList.remove("hidden");
                setTimeout(function () {
                    document.querySelector(".sr-result").classList.add("expand");
                }, 200);

                changeLoadingState(false);
            });
        };

        var showError = function (errorMsgText) {
            changeLoadingState(false);
            var errorMsg = document.querySelector(".sr-field-error");
            errorMsg.textContent = errorMsgText;
            setTimeout(function () {
                errorMsg.textContent = "";
            }, 4000);
        };

        // Show a spinner on payment submission
        var changeLoadingState = function (isLoading) {
            if (isLoading) {
                document.querySelector("button").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("button").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        };


    </script>
@endsection