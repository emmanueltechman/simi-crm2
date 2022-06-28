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

use App\Models\account\Account;
use App\Models\invoice\Invoice;
use App\Models\items\Register;
use App\Models\product\Product;
use App\Models\product\ProductVariation;
use App\Models\transaction\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class GeneralController extends Controller
{


    public function bill_cancel(Request $request)
    {
        switch ($request->bill_type) {
            case 1:
                $invoice = Invoice::find($request->bill_id);
                if ($invoice) {
                    foreach ($invoice->transactions as $transaction) {
                        $account = Account::find($transaction['account_id']);
                        $account->balance -= $transaction['credit'];
                        $account->debit -= $transaction['debit'];
                        $account->save();
                        $transaction->delete();
                    }
                    foreach ($invoice->products as $product) {
                       if($product['product_id']) {
                           $item = ProductVariation::find($product['product_id']);
                           $item->qty += $product['product_qty'];
                           $item->save();
                       }
                    }
                    if($invoice->i_class==1) {
                        $register = Register::where('user_id', $invoice->user_id)->latest('created_at')->first();
                        $new_data = array();
                        $register_update = array();
                        $register_update[$invoice->pmethod] = $invoice->pamnt;
                        $items = json_decode($register->data, true);

                        foreach ($items as $key => $reg) {

                            if (isset($register_update[$key])) $new_data[$key] = $reg - $invoice->pamnt; else $new_data[$key] = $reg;

                        }
                        $register->data = json_encode($new_data);
                        $register->save();
                    }

                   // $invoice->transactions()->delete();
                    $invoice->status = 'canceled';
                    $invoice->pamnt = 0;
                    $invoice->pmethod = '';
                    $invoice->save();

                    echo json_encode(array('status' => 'Success', 'message' => trans('alerts.bills.canceled'), 'bill_status' => trans('payments.' . $request->status)));

                }
                break;
        }
    }

    public function print_receipt(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $html = view('focus.bill.print_receipt_v1', compact('transaction'))->render();
        $pdf = new \Mpdf\Mpdf(config('pdf'));
        $pdf->WriteHTML($html);
        if ($request->pdf == 2) {
            return $pdf->Output('transaction_' . $transaction['id'] . '.pdf', 'D');
        } else {
               $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                );

               return Response::stream($pdf->Output('transaction_' . $transaction['id'] . '.pdf','I'), 200, $headers);
        }
    }

    public function upload_bill_files()
    {
        $imgName = request()->file->getClientOriginalName();
        request()->file->move(public_path('images'), $imgName);
        return response()->json(['uploaded' => '/images/' . $imgName]);
    }
}
