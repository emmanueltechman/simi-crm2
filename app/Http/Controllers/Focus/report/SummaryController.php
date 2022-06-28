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
namespace App\Http\Controllers\Focus\report;

use App\Http\Requests\Focus\report\ManageReports;
use App\Models\Company\ConfigMeta;
use App\Models\invoice\Invoice;
use App\Models\items\InvoiceItem;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\transaction\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummaryController extends Controller
{
    public function index(ManageReports $summary)
    {

    }

    public function summary(ManageReports $summary)
    {
        switch ($summary->section) {
            case 'income':
                $lang['title'] = trans('meta.income_summary');
                $lang['module'] = 'income';
                if ($summary->calculate) {
                    $income_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                    $income = Transaction::where('trans_category_id', $income_category['feature_value'])->whereBetween('payment_date', [datetime_for_database($summary->from_date), date_for_database_plus($summary->to_date)])->sum('credit');
                    $lang['calculate'] = trans('meta.income_summary') . ' &nbsp; &nbsp; &nbsp;' . dateFormat($summary->from_date) . ' - ' . dateFormat($summary->to_date) . ' &nbsp; &nbsp; &nbsp;' . trans('general.total') . ' ' . amountFormat($income);
                }
                return view('focus.summary.summary', compact('lang'));
                break;
            case 'expense':
                $lang['title'] = trans('meta.expense_summary');
                $lang['module'] = 'expense';
                if ($summary->calculate) {
                    $income_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 10)->first('feature_value');
                    $income = Transaction::where('trans_category_id', $income_category['feature_value'])->whereBetween('payment_date', [datetime_for_database($summary->from_date), date_for_database_plus($summary->to_date)])->sum('debit');
                    $lang['calculate'] = trans('meta.expense_summary') . ' &nbsp; &nbsp; &nbsp;' . dateFormat($summary->from_date) . ' - ' . dateFormat($summary->to_date) . ' &nbsp; &nbsp; &nbsp;' . trans('general.total') . ' ' . amountFormat($income);
                }
                return view('focus.summary.summary', compact('lang'));
                break;
            case 'sale':
                $lang['title'] = trans('meta.sale_summary');
                $lang['module'] = 'sale';
                if ($summary->calculate) {
                    $sales = Invoice::whereBetween('invoicedate', [datetime_for_database($summary->from_date), date_for_database_plus($summary->to_date)])->sum('total');
                    $lang['calculate'] = trans('meta.sale_summary') . ' &nbsp; &nbsp; &nbsp;' . dateFormat($summary->from_date) . ' - ' . dateFormat($summary->to_date) . ' &nbsp; &nbsp; &nbsp;' . trans('general.total') . ' ' . amountFormat($sales);
                }
                return view('focus.summary.summary', compact('lang'));
                break;

            case 'purchase':
                $lang['title'] = trans('meta.purchase_summary');
                $lang['module'] = 'purchase';
                if ($summary->calculate) {
                    $sales = Purchaseorder::whereBetween('invoicedate', [datetime_for_database($summary->from_date), date_for_database_plus($summary->to_date)])->sum('total');
                    $lang['calculate'] = trans('meta.purchase_summary') . ' &nbsp; &nbsp; &nbsp;' . dateFormat($summary->from_date) . ' - ' . dateFormat($summary->to_date) . ' &nbsp; &nbsp; &nbsp;' . trans('general.total') . ' ' . amountFormat($sales);
                }
                return view('focus.summary.summary', compact('lang'));
                break;

            case 'products':
                $lang['title'] = trans('meta.products_summary');
                $lang['module'] = 'products';
                if ($summary->calculate) {
                    $productsales = InvoiceItem::whereBetween('created_at', [datetime_for_database($summary->from_date), date_for_database_plus($summary->to_date)])->sum('product_qty');
                    $lang['calculate'] = trans('meta.products_summary') . ' &nbsp; &nbsp; &nbsp;' . dateFormat($summary->from_date) . ' - ' . dateFormat($summary->to_date) . ' &nbsp; &nbsp; &nbsp;' . trans('general.total') . ' ' . numberFormat($productsales);
                }
                return view('focus.summary.summary', compact('lang'));
                break;
        }
    }
}
