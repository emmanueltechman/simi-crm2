<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\communication;

use App\Http\Responses\RedirectResponse;
use App\Models\account\Account;
use App\Models\bank\Bank;
use App\Models\bill\Bill;
use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use App\Models\Company\UserGateway;
use App\Models\Gateway\Usergatewayentry;
use App\Models\invoice\Invoice;
use App\Models\order\Order;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\quote\Quote;
use App\Models\transaction\Transaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Response;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class BillsController extends Controller
{
    public $pheight;

    public function __construct()
    {
        $this->pheight = 0;
    }


    public function index(Request $request)
    {
        $data = $this->bill_details($request);
        session(['bill_url' => $data['link']['preview']]);
        return view('focus.bill.preview', $data);

    }


    public function print_pdf(Request $request)
    {
        $data = $this->bill_details($request);
        if ($request->pdf) {

            $html = view('focus.bill.print_v1', $data)->render();
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $pdf = new \Mpdf\Mpdf(config('pdf'));
            $pdf->WriteHTML($html);
            if ($request->pdf == 2) {
                return $pdf->Output($data['invoice']['title'] . '_' . $data['invoice']['tid'] . '.pdf', 'D');
            } else {
                   $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                );
                return Response::stream($pdf->Output($data['invoice']['title'] . '_' . $data['invoice']['tid'] . '.pdf','I'), 200, $headers);

            }
        }
    }


    public function print_compact(Request $request)
    {

        $data = $this->bill_details($request);

        $this->pheight = 0;
        session(['height' => 0]);
        if ($request->pdf) {
            $data['qrc'] = 'pos_' . date('Y_m_d_H_i_s') . '_';
            if ($data['invoice']['status'] == 'due' || $data['invoice']['status'] == 'partial') {

                $qrCode = new QrCode($data['link']['preview']);
                $qrCode->writeFile(Storage::disk('public')->path('qr/' . $data['qrc'] . '.png'));
                $data['image'] = Storage::disk('public')->path('qr/' . $data['qrc'] . '.png');
            }
            $html = view('focus.bill.print_compact_v1', $data)->render();
            $h = session('height');
            $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'margin_left' => 1, 'margin_right' => 1, 'margin_top' => 1, 'margin_bottom' => 1, 'tempDir' => config('pdf.tempDir')]);
            $pdf->_setPageSize(array(58, $h), $pdf->DefOrientation);
            $pdf->WriteHTML($html);
            $pdf->Output($data['qrc'] . '.pdf', 'I');
            if (isset($data['qrc'])) unlink(Storage::disk('public')->path('qr/' . $data['qrc'] . '.png'));
        }
    }


    public function pay_card(Request $request)
    {
        $data = $this->bill_details($request);

        if (!$data['online_payment'] or !$data['online_pay_account']) exit('ErrorCode 7120');
        $gateway_id = $request->g;
        $data['token'] = $request->token;
        $ins = $data['invoice']['ins'];

        $gateway = UserGateway::where('id', '=', $gateway_id)->whereHas('config', function ($q) use ($ins) {
            $q->where('ins', '=', $ins);
        })->first();


        if ($gateway) {
            $data['gateway'] = $gateway;
            switch ($gateway->id) {
                case 1 :
                    return view('focus.gateways.vendors.stripe', $data);
                    break;
                case 2 :
                    session(['signature_one' => Str::random(8), 'cid' => $ins]);
                    return view('focus.gateways.vendors.paypal', $data);
                    break;
            }
        }


    }

    public function process_payment(Request $request)
    {
        $data = $this->bill_details($request);
        $gateway_id = $request->gateway;
        $data['token'] = $request->token;
        $amount = $data['invoice']['total'];

        $ins = $data['invoice']['ins'];
        $process = false;
        $itn = null;

        $gateway = UserGateway::where('id', '=', $gateway_id)->whereHas('config', function ($q) use ($ins) {
            $q->where('ins', '=', $ins);
        })->first();

        //gateway switch
        if ($gateway) {
            $gateway_note = '';
            $data['gateway'] = $gateway;
            $surcharge = 0;

            if ($gateway->config->surcharge > 0) {
                $surcharge = ($amount * $gateway->config->surcharge) / 100;
            }


            switch ($gateway->id) {
                case 1 :
                    $stripe_amount = ($surcharge + $amount) * 100;
                    $output = $this->stripe($request, $stripe_amount);
                    if ($output['status'] == 'succeeded') {
                        if ($stripe_amount == $output['paid_amount']) {
                            $process = true;
                            if (!$output['id']) {
                                $r = explode('_secret_', $output['clientSecret']);
                                $output['id'] = $r[0];
                            }
                            $gateway_note = ' - Stripe Ref#' . $output['id'];

                            $response['clientSecret'] = $output['clientSecret'];
                        }
                    }

                    break;
                             case 2 :
                                 $order=array();
                                 $order['amount']=$surcharge + $amount;
                                  $order['id']=$data['invoice']['id'];
                                   $order['tid']=$data['invoice']['tid'];
                                   $order['ins']=$data['invoice']['ins'];
                                   $order['token']=$data['token'];

                                 $this->postPaymentWithpaypal($order);

                    break;
            }


            if ($process) {
                //Input received from the request
                $transaction['ins'] = $data['invoice']['ins'];
                $transaction['payer_id'] = $data['invoice']['customer_id'];
                $transaction['user_id'] = $data['invoice']['user_id'];
                $transaction['payer'] = $data['invoice']->customer->name;
                $transaction['credit'] = $amount;
                $transaction['debit'] = 0;
                //$transaction['transaction_type'] = 'Income';
                $transaction['method'] = 'card';
                $transaction['payment_date'] = date('Y-m-d');
                $transaction['relation_id'] = 0;
                $transaction['note'] = trans('payments.online_paid') . $gateway_note;
                $transaction['bill_id'] = $data['invoice']['id'];
                $transaction['account_id'] = $data['online_pay_account'];
                $this->store_payment($transaction, '+', false);
                $response['status'] = 'Success';
                $response['message'] = trans('alerts.backend.transactions.created') . ' <a href="' . route('biller.view_bill', [$data['invoice']['id'], $request->type, $data['token'], 0]) . '" class="btn btn-blue-grey mb-1"><i
                                            class="fa fa-eye"></i> ' . trans('general.view') . ' </a>';

                echo json_encode($response);

            }
        }


    }

     public function postPaymentWithpaypal($order)
    {
       // $paypal_conf = \Config::get('paypal');
           $gateway_data = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 2)->where('ins', '=',$order['ins'])->first();

      //      $apiContext = new ApiContext(new OAuthTokenCredential($gateway_data['key1'], $gateway_data['key2']));
     //       $apiContext->setConfig(['mode' => ($gateway_data['dev_mode'] == true) ? 'sandbox' : 'live']);


        $clientId =$gateway_data['key1']; //$paypal_conf['client_id'];
        $clientSecret =$gateway_data['key2'];//$paypal_conf['secret'];
        if($gateway_data['dev_mode'] == true)
        {
            $environment = new SandboxEnvironment($clientId, $clientSecret);

        } else {
             $environment = new ProductionEnvironment($clientId, $clientSecret);
        }

        $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                             "intent" => "CAPTURE",
                             "purchase_units" => [[
                                 "reference_id" =>  $order['id'],
                                 "amount" => [
                                     "value" => number_format($order['amount'],2,'.',''),
                                     "currency_code" => $gateway_data['currency']
                                     //put other details here as well related to your order
                                 ]
                             ]],
                             "application_context" => [
                                  "cancel_url" => route( 'biller.process_card',[$order['id'],1,$order['token'],1,$order['ins']]),
                                  "return_url" => route( 'biller.process_card',[$order['id'],1,$order['token'],1,$order['ins']])
                             ]
                         ];
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            echo json_encode($response);

        }catch (HttpException $ex) {
            echo $ex->statusCode;
            //echo json_encode($ex->getMessage());
        }
    }
     public function capturePaymentWithpaypal($orderId)
     {
           $gateway_data = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 2)->where('ins', '=', session('cid'))->first();


          $clientId =$gateway_data['key1']; //$paypal_conf['client_id'];
        $clientSecret =$gateway_data['key2'];//$paypal_conf['secret'];

           if($gateway_data['dev_mode'] == true)
        {
            $environment = new SandboxEnvironment($clientId, $clientSecret);

        } else {
             $environment = new ProductionEnvironment($clientId, $clientSecret);
        }

         $client = new PayPalHttpClient($environment);
         // Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
         // $response->result->id gives the orderId of the order created above
         $request = new OrdersCaptureRequest($orderId);
         $request->prefer('return=representation');
         try {
             // Call API with your client and get a response for your call
             $response = $client->execute($request);
             // If call returns body in response, you can get the deserialized version from the result attribute of the response
         //    echo json_encode($response);
        //        echo '<br>';  echo '<br>';  echo '<br>';
        //
                      $response=json_decode(json_encode($response),true);

                if (isset($response['result']) AND $response['result']['intent']=='CAPTURE' AND $response['result']['status']=='COMPLETED') {


                $bill = Invoice::withoutGlobalScopes()->find($response['result']['purchase_units'][0]['reference_id']);
                $online_pay_account = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 6)->where('ins', '=', $bill['ins'])->first('feature_value');

                $gateway_note=' '.$response['result']['purchase_units'][0]['soft_descriptor'].' '.@$response['result']['purchase_units'][0]['payments']['captures'][0]['id'];

                //Input received from the request
                $transaction['ins'] = $bill['ins'];
                $transaction['payer_id'] =$bill['customer_id'];
                $transaction['user_id'] = $bill['user_id'];
                $transaction['payer'] =$bill->customer->name;
                $transaction['credit'] = $bill->total;
                $transaction['debit'] = 0;
                //$transaction['transaction_type'] = 'Income';
                $transaction['method'] = 'card';
                $transaction['payment_date'] = date('Y-m-d');
                $transaction['relation_id'] = 0;
                $transaction['note'] = trans('payments.online_paid') . $gateway_note;
                $transaction['bill_id'] = $bill['id'];
                $transaction['account_id'] = $online_pay_account['feature_value'];
                $this->store_payment($transaction, '+', false);
                $response['status'] = 'Success';
                 $valid_token = token_validator('', 'i' . $bill['id'] . $bill['tid'], true);
                $response['message'] = trans('alerts.backend.transactions.created') . ' <a href="' . route('biller.view_bill', [$bill['id'], 1, $valid_token, 0]) . '" class="btn btn-blue-grey mb-1"><i
                                            class="fa fa-eye"></i> ' . trans('general.view') . ' </a>';

                echo json_encode($response);

            }

         } catch (HttpException $ex) {

             echo json_encode(array('status'=>'Error','message'=>'Code '.$ex->statusCode.' Contact to seller.'));
           //  echo $ex->statusCode;

             //print_r($ex->getMessage());
         }



     }


    public
    function view_bank(Request $request)
    {
        $data['company'] = $this->bill_details($request);


        $data['banks'] = Bank::withoutGlobalScopes()->where('ins', '=', $data['company']['company']['id'])->where('enable', '=', 'Yes')->get();

        return view('focus.bill.banks', $data);

    }


    //protected core methods

    private function store_payment($transaction, $sign = '+', $message = true)
    {
        switch ($transaction['relation_id']) {
            case 0:
                $bill = Invoice::withoutGlobalScopes()->find($transaction['bill_id']);
                break;
        }
        DB::beginTransaction();
        if ($bill->id) {
            $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
            $transaction['trans_category_id'] = $default_category['feature_value'];

            try {
                $result = Transaction::create($transaction);
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
                return false;
            }

            $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first();
            if ($dual_entry['feature_value']) {
                $transaction2 = $transaction;
                $transaction2['account_id'] = $dual_entry['value1'];
                $transaction2['debit'] = $transaction['credit'];
                $transaction2['credit'] = $transaction['debit'];
                try {
                    Transaction::create($transaction2);
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollback();
                    echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
                    return false;
                }
            }

            if ($result->id && $sign == '+') {
                $account = Account::withoutGlobalScopes()->find($transaction['account_id']);
                $account->balance = $account->balance + $transaction['credit'];
                $account->save();

                $due = $bill->total - $bill->pamnt - $transaction['credit'];
                $due2 = $bill->pamnt + $transaction['credit'];

                $bill->pmethod = $transaction['method'];

                if ($due <= 0.00) {
                    $bill->pamnt = $bill->total;
                    $bill->status = 'paid';

                } elseif ($due2 < $bill->total and $transaction['credit'] > 0) {

                    $bill->pamnt = $bill->pamnt + $transaction['credit'];

                    $bill->status = 'partial';
                }
                $bill->save();
                $due = $bill->total - $bill->pamnt;

                if ($dual_entry['feature_value']) {
                    $account = Account::find($transaction2['account_id']);
                    $account->debit = $account->debit + $transaction2['debit'];
                    $account->save();
                }
            }

            if ($message) {

                $transaction['row'] = ' <tr><th scope="row">*</th><td><p class="text-muted">' . $transaction['payment_date'] . '</p></td><td><p class="text-muted">' . $transaction['method'] . '</p></td><td class="text-right">' . amountFormat(0) . '</td><td class="text-right">' . numberFormat($transaction['credit']) . '</td><td class="">' . $transaction['note'] . '</td></tr>';

                echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.transactions.created') . ' <a href="" class="btn btn-primary btn-lg"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '</a> &nbsp; &nbsp;', 'par1' => trans('payments.' . $bill->status), 'par2' => trans('payments.' . $transaction['method']), 'par3' => $transaction['row'], 'payment_made' => numberFormat($bill->pamnt), 'payment_due' => numberFormat($due), 'remains' => numberFormat($due)));

            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' => trans('general.error')));
        }

        DB::commit();
    }


    protected function bill_details($request)
    {
        $flag = false;

        switch ($request->type) {
            case 1 :
                //invoice
                $invoice = Invoice::withoutGlobalScopes()->where('id', '=', $request->id)->first();
                $invoice['type'] = 1;
                $prefix = 1;
                $title = trans('invoices.invoice_title');
                $invoice['custom'] = 2;
                $invoice['person'] = 1;
                $invoice['person_id'] = $invoice['customer_id'];
                $invoice['url'] = route('biller.invoices.show', $invoice->id);
                $invoice['title'] = 'invoice';
                if ($invoice['i_class'] > 1) {
                    $prefix = 6;
                    $title = trans('invoices.subscription');
                } else if ($invoice['i_class'] == 1) {
                    $prefix = 10;
                    $title = trans('invoices.pos');
                }
                $flag = token_validator($request->token, 'i' . $invoice['id'] . $invoice['tid']);
                $general = array('bill_type' => $title,
                    'lang_bill_number' => trans('invoices.tid'),
                    'lang_bill_date' => trans('invoices.invoice_date'),
                    'lang_bill_due_date' => trans('invoices.invoice_due_date'
                    ), 'direction' => visual(),
                    'person' => trans('customers.customer'),
                    'prefix' => $prefix, 'status_block' => true,);
                $valid_token = token_validator('', 'i' . $invoice['id'] . $invoice['tid'], true);
                break;
            case 3 :
                //invoice proforma
                $invoice = Bill::withoutGlobalScopes()->where('id', '=', $request->id)->first();
                $invoice['url'] = route('biller.invoices.show', $invoice->id);
                $invoice['type'] = 3;
                $invoice['custom'] = 2;
                $invoice['person'] = 1;
                $invoice['title'] = 'proforma';
                $invoice['person_id'] = $invoice['customer_id'];
                $flag = token_validator($request->token, 'i' . $invoice['id'] . $invoice['tid']);
                $general = array('bill_type' => trans('invoices.proforma'),
                    'lang_bill_number' => trans('invoices.proforma_tid'),
                    'lang_bill_date' => trans('invoices.invoice_date'),
                    'lang_bill_due_date' => trans('invoices.invoice_due_date'
                    ), 'direction' => visual(),
                    'person' => trans('customers.customer'),
                    'prefix' => 3, 'status_block' => false);
                $valid_token = token_validator('', 'i' . $invoice['id'] . $invoice['tid'], true);
                break;
            case 4 :
                $invoice = Quote::withoutGlobalScopes()->where('id', '=', $request->id)->first();
                $invoice['url'] = route('biller.quotes.show', $invoice->id);
                $invoice['type'] = 4;
                $invoice['custom'] = 2;
                $invoice['person'] = 1;
                $invoice['title'] = 'quote';
                $invoice['person_id'] = $invoice['customer_id'];
                $flag = token_validator($request->token, 'q' . $invoice['id'] . $invoice['tid']);
                $general = array('bill_type' => trans('quotes.quote'),
                    'lang_bill_number' => trans('quotes.quote'),
                    'lang_bill_date' => trans('quotes.invoicedate'),
                    'lang_bill_due_date' => trans('quotes.invoiceduedate'
                    ), 'direction' => visual(),
                    'person' => trans('customers.customer'),
                    'prefix' => 5, 'status_block' => false);
                $valid_token = token_validator('', 'q' . $invoice['id'] . $invoice['tid'], true);
                break;
            case 5 :
                $invoice = Order::withoutGlobalScopes()->where('id', '=', $request->id)->first();
                $invoice['url'] = route('biller.orders.show', $invoice->id);
                $invoice['type'] = 5;
                $invoice['custom'] = 5;
                $invoice['person'] = 1;
                $invoice['title'] = 'order';

                $title = trans('orders.credit_note');
                $prefix = 7;
                $person = trans('customers.customer');
                $invoice['person_id'] = $invoice['customer_id'];
                $flag = token_validator($request->token, 'o' . $invoice['id'] . $invoice['tid']);
                if ($invoice['i_class'] == 3) {
                    $prefix = 8;
                    $title = trans('orders.stock_return');
                    $person = trans('suppliers.supplier');
                    $invoice->customer=$invoice->supplier;
                }
                $general = array('bill_type' => $title,
                    'lang_bill_number' => trans('orders.order'),
                    'lang_bill_date' => trans('general.date'),
                    'lang_bill_due_date' => trans('orders.invoiceduedate'
                    ), 'direction' => visual(),
                    'person' => $person,
                    'prefix' => $prefix, 'status_block' => false);
                $valid_token = token_validator('', 'o' . $invoice['id'] . $invoice['tid'], true);
                break;
            case 9 :
                $invoice = Purchaseorder::withoutGlobalScopes()->where('id', '=', $request->id)->first();
                $invoice['url'] = route('biller.purchaseorders.show', $invoice->id);
                $invoice['type'] = 9;
                $invoice['custom'] = 9;
                $invoice['person'] = 1;
                $invoice['title'] = 'purchase_order';
                $invoice['person_id'] = $invoice['customer_id'];
                $flag = token_validator($request->token, 'po' . $invoice['id'] . $invoice['tid']);
                $general = array('bill_type' => trans('purchaseorders.purchaseorder'),
                    'lang_bill_number' => trans('purchaseorders.purchaseorder'),
                    'lang_bill_date' => trans('purchaseorders.invoicedate'),
                    'lang_bill_due_date' => trans('purchaseorders.invoiceduedate'
                    ), 'direction' => visual(),
                    'person' => trans('suppliers.supplier'),
                    'prefix' => 9, 'status_block' => false);
                $valid_token = token_validator('', 'po' . $invoice['id'] . $invoice['tid'], true);
                break;

        }
        if ($flag) {
            $company = Company::where('id', '=', $invoice['ins'])->first();
            $online_payment = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 5)->where('ins', '=', $company['id'])->first();
            $online_pay_account = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 6)->where('ins', '=', $company['id'])->first('feature_value');
            $gateway = UserGateway::whereHas('config', function ($q) use ($company) {
                $q->where('ins', '=', $company['id']);

            })->get();

            config([
                'currency' => ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 2)->where('ins', '=', $company['id'])->first()->currency
            ]);

            $general['tax_string_total'] = trans('general.total_tax');
            $general['tax_id'] = trans('general.tax_id');
            if ($invoice['tax_format'] == 'igst' or $invoice['tax_format'] == 'cgst') {
                $general['tax_string_total'] = trans('general.total_gst');
                $general['tax_id'] = trans('general.gstin');
            }

            $link['link'] = route('biller.print_bill', [$invoice['id'], $invoice['type'], $valid_token, 1]);
            $link['download'] = route('biller.print_bill', [$invoice['id'], $invoice['type'], $valid_token, 2]);
            $link['preview'] = route('biller.view_bill', [$invoice['id'], $invoice['type'], $valid_token, 0]);
            $link['bank'] = route('biller.view_bank', [$invoice['id'], $invoice['type'], $valid_token]);
            $link['payment'] = route('biller.pay_card', [$invoice['id'], $invoice['type'], $valid_token]);

            $data = array('general' => $general, 'invoice' => $invoice, 'company' => $company, 'online_payment' => $online_payment['feature_value'], 'gateway' => $gateway, 'online_pay_account' => $online_pay_account['feature_value'], 'link' => $link);

            return $data;
        } else {
            exit('Error');
        }
    }

    //gateways

    public function stripe_api_request(Request $request)
    {
        $result = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 1)->where('ins', '=', $request->id)->first('key1');
        return json_encode(array('publishableKey' => $result->key1));
    }

    private function stripe($request, $price)
    {

        $stripe = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 1)->where('ins', '=', $request->cid)->first();
        $stripe_secret = $stripe['key2'];
        \Stripe\Stripe::setApiKey($stripe_secret);

        try {
            if ($request->paymentMethodId != null) {
                $intent = \Stripe\PaymentIntent::create(['amount' => $price, 'currency' => $stripe['currency'], 'payment_method' => $request->paymentMethodId, 'confirmation_method' => "manual", 'confirm' => true, 'use_stripe_sdk' => true]);

            } else if ($request->paymentIntentId != null) {

                $intent = \Stripe\PaymentIntent::retrieve($request->paymentIntentId);
                $intent->confirm();
                switch ($intent->status) {
                    case "succeeded":

                        return array('status' => 'succeeded', 'paid_amount' => $intent->amount, 'clientSecret' => $intent->client_secret, 'id' => $request->paymentIntentId);
                        break;
                }
            }

            $output = generateResponse($intent);

            switch (@$intent->status) {
                case "succeeded":
                    return array('status' => 'succeeded', 'paid_amount' => $intent->amount, 'clientSecret' => $intent->client_secret, 'id' => $request->paymentIntentId);
                    break;
            }


            echo json_encode($output);
        } catch (\Stripe\Exception\CardException $e) {
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function paypal_process(Request $request)
    {
        if ($request->get('paymentId')) {
            $result = $this->paypal_response($request);

            if (isset($result['status']) and session()->previousUrl()) {
                if ($result['status'] == 'Error') {
                    return new RedirectResponse(session()->previousUrl(), ['flash_error' => $result['message']]);
                } elseif ($result['status'] == 'Success') {
                    Session::forget('signature_one');
                    return new RedirectResponse($result['url'], ['flash_success' => $result['message']]);
                }
            }

        } elseif ($request->post()) {

            //for paypal
            $invoice_id = $request->post('id');
            $token = $request->post('token');
            $data = $this->bill_details($request);
            $gateway_data = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 2)->where('ins', '=', $data['invoice']['ins'])->first();

            $paypalConfig = [
                'sandbox' => $gateway_data['dev_mode'],
                'client_id' => $gateway_data['key1'],
                'client_secret' => $gateway_data['key2'],
                'return_url' => route('biller.paypal_process'),
                'cancel_url' => route('biller.paypal_error')
            ];

            try {
                $apiContext = new ApiContext(new OAuthTokenCredential($gateway_data['key1'], $gateway_data['key2']));
                $apiContext->setConfig(['mode' => ($gateway_data['dev_mode'] == true) ? 'sandbox' : 'live']);

                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                if ($gateway_data['surcharge']) $surcharge = ($data['invoice']['total'] * $gateway_data['surcharge']) / 100;
                $amount = $data['invoice']['total'] + $surcharge;
                $invoice_amount = number_format($amount, 2, '.', '');

                if (session('signature_one')) {


                    $amount = new Amount();
                    $amount->setCurrency($gateway_data['currency'])
                        ->setTotal($invoice_amount);

                    try {

                        $transaction = new \PayPal\Api\Transaction();
                        $transaction->setAmount($amount)
                            ->setDescription(trans('invoices.invoice') . ' ' . $data['invoice']['tid'] . '' . trans('payments.completed'))
                            ->setInvoiceNumber($data['invoice']['id'])->setCustom(session('signature_one'));

                        $redirectUrls = new RedirectUrls();
                        $redirectUrls->setReturnUrl($paypalConfig['return_url'])
                            ->setCancelUrl($paypalConfig['cancel_url']);

                        $payment = new Payment();
                        $payment->setIntent('sale')
                            ->setPayer($payer)
                            ->setTransactions([$transaction])
                            ->setRedirectUrls($redirectUrls);

                        try {
                            $payment->create($apiContext);

                        } catch (\Exception $e) {

                            throw new \Exception('Unable to create link for payment' . $e->getMessage());
                        }

                        header('location:' . $payment->getApprovalLink());
                        exit(1);
                    } catch (\Exception $e) {
                        return new RedirectResponse(route('biller.pay_card', [$invoice_id, 1, $token]) . '?g=2', ['flash_error' => 'Gateway Transactions failed! PayPal Server communication interrupted']);
                    }
                } else {
                    return new RedirectResponse(route('biller.pay_card', [$invoice_id, 1, $token]) . '?g=2', ['flash_error' => 'Signature  Verification Failed!']);
                }
            } catch (\Exception $e) {
                return new RedirectResponse(route('biller.pay_card', [$invoice_id, 1, $token]) . '?g=2', ['flash_error' => 'Gateway Communication failed! PayPal Server communication interrupted']);
            }
        }


    }

    public function paypal_response(Request $request)
    {
        if (empty($request->get('paymentId')) || empty($request->get('PayerID'))) {
            exit('InvalidRequest');
        }
        $gateway_data = Usergatewayentry::withoutGlobalScopes()->where('user_gateway_id', '=', 2)->where('ins', '=', session('cid'))->first();

        $sign = session('signature_one');

        try {
            $apiContext = new ApiContext(new OAuthTokenCredential($gateway_data['key1'], $gateway_data['key2']));
            $apiContext->setConfig(['mode' => ($gateway_data['dev_mode'] == true) ? 'sandbox' : 'live']);
            $paymentId = $request->get('paymentId');
            $payment = Payment::get($paymentId, $apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->get('PayerID'));
            // Take the payment
            $payment->execute($execution, $apiContext);

            $data = [
                'transaction_id' => $payment->getId(),
                'payment_amount' => $payment->transactions[0]->amount->total,
                'payment_status' => $payment->getState(),
                'invoice_id' => $payment->transactions[0]->invoice_number,
                'sign' => $payment->transactions[0]->custom
            ];

            if ($data['payment_status'] === 'approved' and $sign == $data['sign']) {
                $invoice = Invoice::withoutGlobalScopes()->find($data['invoice_id']);
                $online_pay_account = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 6)->where('ins', '=', $invoice['ins'])->first('feature_value');
                $transaction['ins'] = $invoice['ins'];
                $transaction['payer_id'] = $invoice['customer_id'];
                $transaction['user_id'] = $invoice['user_id'];
                $transaction['payer'] = $invoice->customer->name;
                $transaction['credit'] = $invoice->total;
                $transaction['debit'] = 0;
                //$transaction['transaction_type'] = 'Income';
                $transaction['method'] = 'card';
                $transaction['payment_date'] = date('Y-m-d');
                $transaction['relation_id'] = 0;
                $transaction['note'] = trans('payments.online_paid') . $data['transaction_id'];
                $transaction['bill_id'] = $invoice['id'];
                $transaction['account_id'] = $online_pay_account['feature_value'];



                $this->store_payment($transaction, '+', false);
                $valid_token = token_validator('', 'i' . $invoice['id'] . $invoice['tid'], true);
                $response['status'] = 'Success';
                $response['url'] = route('biller.view_bill', [$invoice['id'], 1, $valid_token, 0]);
                $response['message'] = trans('payments.completed');


                return $response;

            } else {
                exit('Request Expired');
            }


        } catch (\Exception $e) {

            return array('status' => 'Error', 'message' => 'Payment Error! #R321 ' . $e->getCode());

        }

    }

    public function paypal_error(Request $request)
    {
        return redirect(session('bill_url'));
    }

}
