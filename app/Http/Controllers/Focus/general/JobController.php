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

namespace App\Http\Controllers\Focus\general;

use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use App\Models\currency\Currency;
use App\Models\invoice\Invoice;
use App\Models\items\InvoiceItem;
use App\Models\product\ProductVariation;
use App\Models\template\Template;
use App\Http\Controllers\Controller;
use App\Repositories\Focus\general\RosemailerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mavinoo\Batch\BatchFacade as Batch;

class JobController extends Controller
{

    public function index(Request $request, $method)
    {

        $key = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 6)->where('ins', '=', 1)->first();

        if ($key->value2 == $request->token) {
            switch ($method) {
                case 'subscription':
                    $this->subscription();
                    break;
                case 'due_email_alert':
                    $this->due_email_alert();
                    break;
                case 'expired_products':
                    $this->expired_products();
                    break;
                case 'low_stock_products':
                    $this->low_stock_products();
                    break;
                case 'currency_exchange':
                    $this->currency_exchange();
                    break;
                case 'due_marker':
                    $this->due_marker();
                    break;
                case 'overdue_marker':
                    $this->overdue_marker();
                    break;
            }
        } else {
            exit('Token Mismatch!');
        }

    }

    private function due_marker()
    {
        $due_date = date('Y-m-d');
        $invoices = Invoice::where('status', '=', 'pending')->where('invoiceduedate', '<=', $due_date)->get();
        if (count($invoices) > 0) {
            foreach ($invoices as $row) {
                $row->status = 'due';
                $row->save();
            }
            echo "------------------Due Invoices Updated------------------------\n\n";
        }
    }

    private function overdue_marker()
    {
        $due_date = date("Y-m-d", strtotime('+30days'));
        $invoices = Invoice::where('status', '=', 'due')->where('invoiceduedate', '<', $due_date)->get();
        if (count($invoices) > 0) {
            foreach ($invoices as $row) {
                $row->status = 'overdue';
                $row->save();
            }
            echo "------------------Due Invoices Updated------------------------\n\n";
        }
    }


    private function subscription()
    {
        DB::beginTransaction();
        try {
            $due_date = date('Y-m-d');
            $invoices = Invoice::withoutGlobalScopes()->where('i_class', '=', 2)->where('invoiceduedate', '<=', $due_date)->get();
            if (count($invoices) > 0) {

                $new_invoice = array();
                $new_invoice_items = array();
                $stock_update = array();
                $invoice_update = array();
                $invoice_latest = Invoice::withoutGlobalScopes()->where('i_class', '>', 1)->orderBy('id', 'desc')->first();
                $latest = $invoice_latest['tid'];
                $n = ' #';
                $body = '';
                foreach ($invoices as $row) {
                    $latest++;
                    $n .= $latest . ',';

                    $n_date = date("Y-m-d", strtotime($row['invoiceduedate'] . " +" . $row['r_time'] . 's'));

                    $body .= dateFormat($n_date) . ' -> ' . trans('invoices.subscription') . '#' . $latest . ' ' . trans('general.amount') . ' ' . amountFormat($row['total']) . '<br>';

                    $new_invoice = array('tid' => $latest, 'invoicedate' => $row['invoiceduedate'], 'invoiceduedate' => $n_date, 'subtotal' => $row['subtotal'], 'shipping' => $row['shipping'], 'discount' => $row['discount'], 'tax' => $row['tax'], 'total' => $row['total'], 'notes' => $row['notes'], 'customer_id' => $row['customer_id'], 'user_id' => $row['user_id'], 'items' => $row['items'], 'tax_format' => $row['tax_format'], 'tax_id' => $row['tax_id'], 'discount_format' => $row['discount_format'], 'refer' => $row['refer'], 'term_id' => $row['term_id'], 'currency' => $row['currency'], 'i_class' => 2, 'r_time' => $row['r_time'], 'ins' => $row['ins']);
                    $inv_result = Invoice::create($new_invoice);
                    foreach ($row->products as $product) {
                        $new_invoice_items[] = array(
                            'invoice_id' => $inv_result->id,
                            'product_id' => $product['product_id'],
                            'product_name' => $product['product_name'],
                            'code' => $product['code'],
                            'product_qty' => $product['product_qty'],
                            'product_price' => $product['product_price'],
                            'product_tax' => $product['product_tax'],
                            'product_discount' => $product['product_discount'],
                            'product_subtotal' => $product['product_subtotal'],
                            'total_tax' => $product['total_tax'],
                            'total_discount' => $product['total_discount'],
                            'product_des' => $product['product_des'],
                            'unit' => $product['unit'],
                            'ins' => $product['ins']
                        );
                        $stock_update[] = array('id' => $product['product_id'], 'qty' => $product['product_qty']);
                    }
                    $invoice_update[] = array('id' => $row->id, 'i_class' => 3);
                }
                InvoiceItem::insert($new_invoice_items);
                $update_variation = new ProductVariation();
                $invoice_variation = new Invoice();
                $index = 'id';
                Batch::update($update_variation, $stock_update, $index, true);
                Batch::update($invoice_variation, $invoice_update, $index);
                echo "------------------Subscriptions Generated------------------------\n\n";
                $mail = array();
                $mail['mail_to'] = feature(11)->value1;
                $mail['subject'] = trans('invoices.subscriptions') . ' -' . $n;
                $mail['customer_name'] = feature(11)->value1;
                $mail['text'] = '------------------Subscriptions Generated------------------------<br>' . trans('invoices.subscriptions') . '-' . $n . '<br><br>' . $body;
                $mailer = new RosemailerRepository;
                $result = $mailer->send($mail['text'], $mail);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo "------------------Server Overloaded------------------------\n\n";
        }
    }

    private function due_email_alert()
    {
        $due_date = date('Y-m-d');
        $invoices = Invoice::where('status', '=', 'due')->where('invoiceduedate', '<=', $due_date)->get();
        $emails = array();
        if (count($invoices) > 0) {
            foreach ($invoices as $row) {
                $template = Template::withoutGlobalScopes()->where('ins', '=', $row->ins)->where('category', '=', 1)->where('other', '=', 2)->first();
                $valid_token = hash_hmac('ripemd160', 'i' . $row->id . $row->tid, config('master.key'));
                $link = route('biller.view_bill', [$row->id, 1, $valid_token, 0]);
                $data = array(
                    'Company' => config('core.cname'),
                    'BillNumber' => $row->tid,
                    'BillType' => trans('invoices.invoice'),
                    'URL' => "<a href='$link'>$link</a>",
                    'Name' => $row->customer->name,
                    'CompanyDetails' => '<h6><strong>' . config('core.cname') . ',</strong></h6>
<address>' . config('core.address') . '<br>' . config('core.city') . '</address>
            ' . config('core.region') . ' : ' . config('core.country') . '<br>  ' . trans('general.email') . ' : ' . config('core.email'),
                    'DueDate' => dateFormat($row->invoiceduedate),
                    'Amount' => amountFormat($row->total)
                );
                $replaced_body = parse($template['body'], $data, true);
                $input['subject'] = parse($template['title'], $data, true);
                $input['email'] = $row->customer->email;
                Mail::send('focus.mailable.bill', array('body' => $replaced_body), function ($message) use ($input) {
                    $message->to($input['email']);
                    $message->subject($input['subject']);
                });
            }
            echo "------------------Due Invoices Alert Emails Sent------------------------\n\n";
        }
    }

    private function expired_products()
    {
        $products = ProductVariation::withoutGlobalScopes()->whereNotNull('expiry')->where('expiry', '<', date('Y-m-d'))->get();
        if (count($products) > 0) {

            $html_table = '<h2>' . trans('meta.expired_cron') . '</h2>' . trans('meta.expired_stock_body') . '<table style="padding: 5px;"><tr style="border-bottom: solid #000;"><th>' . trans('products.product') . '</th><th>' . trans('products.qty') . '</th><th>' . trans('products.price') . '</th></tr>';
            foreach ($products as $row) {

                if($row['qty']>0 AND $row['expiry']!='0000-00-00') {
                    $html_table .= '<tr style="padding: 8px;"><td style="padding: 8px;border: 1px solid;">' .dateFormat($row['expiry'],'d-m-Y') . ' - '. $row->product['name'] . '' . $row['name'] . '</td><td style="padding: 8px;border: 1px solid;">' . numberFormat($row['qty']) . ' ' . $row->product['unit'] . '</td><td style="padding: 8px;border: 1px solid;">' . amountFormat($row['price']) . '</td></tr>';
                }

            }
            $html_table .= '</table>';

            echo($html_table);
            exit;

            $meta = ConfigMeta::withoutGlobalScopes()->where('ins', '=', $row->ins)->where('feature_id', '=', 1)->first();

            $input['subject'] = trans('meta.expired_cron') . ' ' . dateFormat(date('Y-m-d'));
            $input['email'] = $meta->value2;
            Mail::send('focus.mailable.bill', array('body' => $html_table), function ($message) use ($input) {
                $str_mailer = explode ("+", $input['email']);
                if(isset($str_mailer[1])){
                    $message->to($str_mailer[0]);
                    array_shift($str_mailer);
                    $message->bcc($str_mailer);

                } else {
                    $message->to($input['email']);
                }
                $message->subject($input['subject']);
            });
            echo "------------------Expired Stock Alert Emails Sent------------------------\n\n";
        }

    }

    private function low_stock_products()
    {
        $products = ProductVariation::withoutGlobalScopes()->whereRaw('qty<=alert')->whereHas('product', function ($query) {
            return $query->where('stock_type', '=', 1);
        })->get();
        if (count($products) > 0) {

            $html_table = '<h2>' . trans('meta.low_stock_cron') . '</h2>' . trans('meta.low_stock_body') . '<table style="padding: 5px;"><tr style="border-bottom: solid #000;"><th>' . trans('products.product') . '</th><th>' . trans('products.qty') . '</th><th>' . trans('products.price') . '</th></tr>';
            foreach ($products as $row) {

               if($row['qty']>0) $html_table .= '<tr style="padding: 8px;"><td style="padding: 8px;border: 1px solid;">'. $row->product['name'] . '' . $row['name'] . '</td><td style="padding: 8px;border: 1px solid;">' . numberFormat($row['qty']) . ' ' . $row->product['unit'] . '</td><td style="padding: 8px;border: 1px solid;">' . amountFormat($row['price']) . '</td></tr>';

            }
            $html_table .= '</table>';


            $meta = ConfigMeta::withoutGlobalScopes()->where('ins', '=', $row->ins)->where('feature_id', '=', 1)->first();

            $input['subject'] = trans('meta.expired_cron') . ' ' . dateFormat(date('Y-m-d'));
            $input['email'] = $meta->value2;

            Mail::send('focus.mailable.bill', array('body' => $html_table), function ($message) use ($input) {

                $str_mailer = explode ("+", $input['email']);
                if(isset($str_mailer[1])){
                    $message->to($str_mailer[0]);
                    array_shift($str_mailer);
                    $message->bcc($str_mailer);

                } else {
                    $message->to($input['email']);
                }

                $message->subject($input['subject']);
            });
            echo "------------------Low Stock Alert Emails Sent------------------------\n\n";
        }

    }


    private function currency_exchange()
    {
        $companies = Company::all();
        $update = array();
        foreach ($companies as $row) {
            $meta = ConfigMeta::withoutGlobalScopes()->where('ins', '=', $row->id)->where('feature_id', '=', 2)->first('value2');
            $conf = json_decode($meta['value2'], true);
            if ($conf['enable'] == 1) $update[] = $row->id;
        }

        if (count($update) > 0) {
            $meta = ConfigMeta::withoutGlobalScopes()->where('ins', '=', 1)->where('feature_id', '=', 2)->first('value2');
            $conf = json_decode($meta['value2'], true);
            $endpoint = $conf['endpoint'];
            $access_key = $conf['key'];
            $base = $conf['base_currency'];
            $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);
            curl_close($ch);
            $exchangeRates = json_decode($json, true);
            $currencies = Currency::whereIn('ins', $update)->get();
            foreach ($currencies as $currency) {
                $currency->rate = $exchangeRates['quotes'][$base . $currency->code];
                $currency->save();
            }
            echo "------------------Currency Rates Updated------------------------\n\n";
        }
    }


}
