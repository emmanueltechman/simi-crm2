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
use App\Models\customer\Customer;
use App\Models\invoice\Invoice;
use App\Models\items\InvoiceItem;
use App\Models\product\ProductVariation;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\transaction\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(ManageReports $reports)
    {

    }

    public function chart(ManageReports $request)
    {
        $c['from_date'] = date("Y-m-d", strtotime(' - 30 days'));
        $c['to_date'] = date('Y-m-d', strtotime(' +1 days'));

        switch ($request->interval) {
            case 'week':
                $c['from_date'] = date("Y-m-d", strtotime(' - 7 days'));
                $c['to_date'] = date('Y-m-d', strtotime(' +1 days'));
                break;
            case 'month':
                $c['from_date'] = date("Y-m-d", strtotime(' - 30 days'));
                $c['to_date'] = date('Y-m-d', strtotime(' +1 days'));
                break;
            case 'year':
                $c['from_date'] = date("Y-m-d", strtotime(' - 1 years'));
                $c['to_date'] = date('Y-m-d', strtotime(' +1 days'));
                break;

            case 'custom':
                $c['from_date'] = date_for_database($request->from_date);
                $c['to_date'] = date_for_database_plus($request->to_date);
                break;

            default :
                $c['from_date'] = date("Y-m-d", strtotime(' - 90 days'));
                $c['to_date'] = date('Y-m-d', strtotime(' +1 days'));
                break;
        }


        switch ($request->section) {
            case 'customer':
                $chart_result = Invoice::whereBetween('invoicedate', [$c['from_date'], $c['to_date']])->groupBy('customer_id')->select('customer_id', DB::raw('sum(total) as amount'))->orderBy('amount', 'desc')->take(100)->get();
                $lang['title'] = trans('meta.customer_graphical_overview');
                $lang['module'] = 'customer';
                if ($request->interval) {
                    $chart_array = array();
                    foreach ($chart_result as $row) {
                        $chart_array[] = array('y' => $row->customer['name'], 'a' => $row['amount']);
                    }
                    return json_encode($chart_array);
                }
                return view('focus.chart.draw', compact('chart_result', 'lang'));
                break;

            case 'supplier':
                $chart_result = Purchaseorder::whereBetween('invoicedate', [$c['from_date'], $c['to_date']])->groupBy('supplier_id')->select('supplier_id', DB::raw('sum(total) as amount'))->orderBy('amount', 'desc')->take(100)->get();
                $lang['title'] = trans('meta.supplier_graphical_overview');
                $lang['module'] = 'supplier';

                if ($request->interval) {
                    $chart_array = array();
                    foreach ($chart_result as $row) {
                        $chart_array[] = array('y' => $row->supplier['name'], 'a' => $row['amount']);
                    }
                    return json_encode($chart_array);
                }
                return view('focus.chart.draw', compact('chart_result', 'lang'));
                break;

            case 'product':
                $chart_result = InvoiceItem::whereBetween('created_at', [datetime_for_database($c['from_date']), datetime_for_database($c['to_date'])])->groupBy('product_id')->select('product_name', DB::raw('sum(product_qty) as amount'))->orderBy('amount', 'desc')->take(100)->get();
                $lang['title'] = trans('meta.product_graphical_overview');
                $lang['module'] = 'product';
                if ($request->interval) {
                    $chart_array = array();
                    foreach ($chart_result as $row) {
                        $chart_array[] = array('y' => $row['product_name'], 'a' => $row['amount']);
                    }
                    return json_encode($chart_array);
                }
                return view('focus.chart.draw', compact('chart_result', 'lang'));
                break;

            case 'income_vs_expenses':
                $income_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                $purchase_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 10)->first('feature_value');

                $chart_result['income'] = Transaction::where('trans_category_id', $income_category['feature_value'])->whereBetween('payment_date', [$c['from_date'], $c['to_date']])->sum('credit');
                $chart_result['expense'] = Transaction::where('trans_category_id', $purchase_category['feature_value'])->whereBetween('payment_date', [$c['from_date'], $c['to_date']])->sum('debit');


                $lang['title'] = trans('meta.income_vs_expenses_overview');
                $lang['module'] = 'income_vs_expenses';
                $lang['note'] = trans('meta.tip_income_vs_expenses');
                $chart_result_json = array();
                if ($request->interval) {
                    $chart_result_json[] = array('label' => trans('accounts.Income'), 'value' => intval($chart_result['income']));
                    $chart_result_json[] = array('label' => trans('accounts.Expenses'), 'value' => intval($chart_result['expense']));

                    return json_encode($chart_result_json);
                }
                return view('focus.chart.draw', compact('chart_result', 'lang'));
                break;

            /*
                            case 'product_category':
                           // $chart_result = InvoiceItem::whereBetween('created_at', [datetime_for_database($c['from_date']), datetime_for_database($c['to_date'])])->groupBy('product_id')->select('product_name',DB::raw('sum(product_qty) as amount'))->orderBy('amount', 'desc')->take(100)->get();
                    $chart_result_raw = InvoiceItem::whereBetween('created_at', [datetime_for_database($c['from_date']), datetime_for_database($c['to_date'])])->groupBy('product_id')->select('product_id','product_name',DB::raw('sum(product_qty) as amount'))->orderBy('amount', 'desc')->get();
                    $p_list=array();
                    $p_sort=array();
            foreach ($chart_result_raw as $product){
                $p_list[]=$product['product_id'];
                $p_sort[$product['product_id']]=$product['amount'];
            }

            $chart_result=ProductVariation::whereIn('id',$p_list)->whereHas('product',function ($q){
                $q->groupBy('productcategory_id');
            })->get();



                            $lang['title'] = trans('meta.product_categoryt_graphical_overview');
                            $lang['module'] = 'product_category';


                            if ($request->interval) {
                                $chart_array = array();
                                foreach ($chart_result as $row) {
                                    $chart_array[] = array('y' => $row['product_name'], 'a' => $row['amount']);
                                }
                                return json_encode($chart_array);
                            }
                            return view('focus.chart.draw', compact('p_sort','p_list','chart_result', 'lang'));
                            break;
            */
        }


        return view('focus.report.account_statement');

    }

}
