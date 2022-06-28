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

use App\Http\Requests\Focus\general\CommunicationRequest;
use App\Mail\SendBill;
use App\Models\Company\ConfigMeta;
use App\Models\customergroup\CustomerGroupEntry;
use App\Models\invoice\Invoice;
use App\Models\order\Order;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\quote\Quote;
use App\Models\template\Template;
use App\Repositories\Focus\general\RosemailerRepository;
use App\Repositories\Focus\general\RosesmsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Bitly;

class CommunicationsController extends Controller
{
    //
    public function load(Request $request)
    {
        $input = $request->only('bill_id', 'template_type', 'template_category');

        $template = Template::all()->where('category', '=', $input['template_category'])->where('other', '=', $input['template_type'])->first();
        switch ($input['template_category']) {
            case 1 :
                if (!access()->allow('invoice-manage')) return '';
                $bill = Invoice::find($input['bill_id']);
                $valid_token = hash_hmac('ripemd160', 'i' . $bill->id . $bill->tid, config('master.key'));
                $link = route('biller.view_bill', [$bill->id, 1, $valid_token, 0]);
                $bill_type = trans('invoices.invoice');
                break;
            case 2 :
                if (!access()->allow('invoice-manage')) return '';
                $bill = Invoice::find($input['bill_id']);
                $valid_token = hash_hmac('ripemd160', 'i' . $bill->id . $bill->tid, config('master.key'));
                $link = route('biller.view_bill', [$bill->id, 1, $valid_token, 0]);
                $bill_type = trans('invoices.invoice');
                break;
            case 4 :
                if (!access()->allow('quote-manage')) return '';
                $bill = Quote::find($input['bill_id']);
                $valid_token = hash_hmac('ripemd160', 'q' . $bill->id . $bill->tid, config('master.key'));
                $link = route('biller.view_bill', [$bill->id, 4, $valid_token, 0]);
                $bill_type = trans('quotes.quote');
                break;
            case 5 :
                if (!access()->allow('quote-manage')) return '';
                $bill = Order::find($input['bill_id']);
                $valid_token = hash_hmac('ripemd160', 'o' . $bill->id . $bill->tid, config('master.key'));
                $link = route('biller.view_bill', [$bill->id, 5, $valid_token, 0]);
                $bill_type = trans('orders.credit_note');
                break;
            case 9 :
                if (!access()->allow('purchaseorder-manage')) return '';
                $bill = Purchaseorder::find($input['bill_id']);
                $valid_token = hash_hmac('ripemd160', 'po' . $bill->id . $bill->tid, config('master.key'));
                $link = route('biller.view_bill', [$bill->id, 9, $valid_token, 0]);
                $bill_type = trans('purchaseorders.purchaseorder');
                break;
        }

        $data = array(
            'Company' => config('core.cname'),
            'BillNumber' => $bill->tid,
            'BillType' => $bill_type,
            'URL' => "<a href='$link'>$link</a>",
            'Name' => $bill->customer->name,
            'CompanyDetails' => '<h6><strong>' . config('core.cname') . ',</strong></h6>
<address>' . config('core.address') . '<br>' . config('core.city') . '</address>
            ' . config('core.region') . ' : ' . config('core.country') . '<br>  ' . trans('general.email') . ' : ' . config('core.email'),
            'DueDate' => dateFormat(date('Y-m-d')),
            'Amount' => amountFormat($bill->total)
        );
        if ($input['template_type'] >= 11 && $input['template_type'] <= 18) {
            $short_url = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 7)->where('ins', '=', $bill->ins)->first(array('feature_value', 'value2'));
            $data['URL'] = $link;
            if ($short_url['feature_value']) {
                config([
                    'bitly.accesstoken' => $short_url['value2']]);
                $data['URL'] = Bitly::getUrl($link);
            }
        }
        $replaced_body = parse($template['body'], $data, true);
        $subject = parse($template['title'], $data, true);
        return json_encode(array('subject' => $subject, 'body' => $replaced_body));

    }

    public function send_bill(CommunicationRequest $request)
    {
        $input = $request->only('text', 'subject', 'mail_to', 'customer_name');
        $mailer = new RosemailerRepository;
        return $mailer->send($input['text'], $input);

    }


    public function group_send_email(CommunicationRequest $request)
    {

        $input = $request->only('text', 'subject', 'bill_id');
        $customers = CustomerGroupEntry::where('customer_group_id', '=', $input['bill_id'])->get();
        $meta = array();
        foreach ($customers as $customer) {
            $meta[] = $customer->customer_details['email'];
        }
        $input['email'] = $meta;
        $mailer = new RosemailerRepository;
        return $mailer->send_group($input['text'], $input);

    }


    public function send_bill_sms(CommunicationRequest $request)
    {
        $mailer = new RosesmsRepository;
        return $mailer->send_sms($request->sms_to, $request->text);
    }

    public function customer_send_email(CommunicationRequest $request)
    {
        $input = $request->only('mail_to', 'text', 'subject', 'bill_id');
        $mailer = new RosemailerRepository;
        return $mailer->send($input['text'], $input);

    }


}
