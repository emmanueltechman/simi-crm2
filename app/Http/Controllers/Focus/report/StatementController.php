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

use App\Http\Responses\RedirectResponse;
use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\customer\Customer;
use App\Models\invoice\Invoice;
use App\Models\items\InvoiceItem;
use App\Models\items\OrderItem;
use App\Models\items\PurchaseItem;
use App\Models\items\Register;
use App\Models\market\ChannelBill;
use App\Models\market\SalesChannel;
use App\Models\product\ProductMeta;
use App\Models\product\ProductVariation;
use App\Models\productcategory\Productcategory;
use App\Models\purchaseorder\Purchaseorder;
use App\Models\supplier\Supplier;
use App\Models\transaction\Transaction;
use App\Models\transactioncategory\Transactioncategory;
use App\Models\warehouse\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\report\ManageReports;
use Illuminate\Support\Facades\Response;
use mPDF;

class StatementController extends Controller
{
    public function index(ManageReports $reports)
    {

    }

    public function account(ManageReports $reports)
    {

    }

    public function statement(ManageReports $reports)
    {
        switch ($reports->section) {
            case 'account':
                $lang['title'] = trans('meta.account_statement');
                $lang['module'] = 'account_statement';
                $accounts = Account::all();
                return view('focus.report.general_statement', compact('accounts', 'lang'));
                break;
            case 'income':
                $lang['title'] = trans('meta.income_statement');
                $lang['module'] = 'income_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'expense':
                $lang['title'] = trans('meta.expense_statement');
                $lang['module'] = 'expense_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'customer':
                $lang['title'] = trans('meta.customer_statement');
                $lang['module'] = 'customer_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'supplier':
                $lang['title'] = trans('meta.supplier_statement');
                $lang['module'] = 'supplier_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'tax':
                $lang['title'] = trans('meta.tax_statement');
                $lang['module'] = 'tax_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'stock_transfer':
                $lang['title'] = trans('meta.stock_transfer_statement_warehouse');
                $lang['module'] = 'stock_transfer_statement';
                $warehouses = Warehouse::all();
                return view('focus.report.general_statement', compact('warehouses', 'lang'));
                break;
            case 'stock_transfer_product':
                $lang['title'] = trans('meta.stock_transfer_statement_product');
                $lang['module'] = 'product_transfer_statement';
                $warehouses = Warehouse::all();
                return view('focus.report.general_statement', compact('warehouses', 'lang'));
                break;
            case 'product_statement':
                $lang['title'] = trans('meta.stock_transfer_statement_product');
                $lang['module'] = 'product_statement';
                $warehouses = Warehouse::all();
                return view('focus.report.general_statement', compact('warehouses', 'lang'));
                break;

            case 'product_category_statement':
                $lang['title'] = trans('meta.product_category_statement');
                $lang['module'] = 'product_category_statement';
                $product_categories = Productcategory::all();
                return view('focus.report.general_statement', compact('product_categories', 'lang'));
                break;
            case 'product_warehouse_statement':
                $lang['title'] = trans('meta.product_warehouse_statement');
                $lang['module'] = 'product_warehouse_statement';
                $warehouses = Warehouse::all();
                return view('focus.report.general_statement', compact('warehouses', 'lang'));
                break;
            case 'product_customer_statement':
                $lang['title'] = trans('meta.product_customer_statement');
                $lang['module'] = 'product_customer_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;
            case 'product_supplier_statement':
                $lang['title'] = trans('meta.product_supplier_statement');
                $lang['module'] = 'product_supplier_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;

            case 'pos_statement':
                $lang['title'] = trans('meta.pos_statement');
                $lang['module'] = 'pos_statement';
                return view('focus.report.general_statement', compact('lang'));
                break;

            case 'market_statement':
                $lang['title'] = trans('sales_channel.sales_channel_statement');
                $lang['module'] = 'market_statement';
                $channels = SalesChannel::all();
                return view('focus.report.general_statement', compact('lang', 'channels'));
                break;


        }
    }

    public function generate_statement(ManageReports $reports)
    {

        switch ($reports->section) {
            case 'account':
                if (!$reports->account) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $account_details = Account::where('id', '=', $reports->account)->first();
                $lang['title'] = trans('meta.account_statement');
                $lang['title2'] = trans('accounts.account');
                $lang['module'] = 'account_statement';
                $lang['party'] = $account_details->holder . ' (' . trans('accounts.' . $account_details->account_type) . ')' . '<br>' . $account_details->number . '<br>' . $account_details->type;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $account_details->holder);
                break;

            case 'income':
                $account_details = Account::where('id', '=', $reports->account)->first();
                $lang['title'] = trans('meta.income_statement');
                $lang['title2'] = trans('meta.income_statement');
                $lang['module'] = 'income_statement';
                $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
                $category = Transactioncategory::find($default_category['feature_value']);
                $lang['party'] = $category->name;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $category->name);
                $transactions = Transaction::whereBetween('payment_date', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->where('trans_category_id', '=', $category->id)->get();

                break;
            case 'expenses':
                $account_details = Account::where('id', '=', $reports->account)->first();
                $lang['title'] = trans('meta.expense_statement');
                $lang['title2'] = trans('meta.expense_statement');
                $lang['module'] = 'expense_statement';
                $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 10)->first('feature_value');
                $category = Transactioncategory::find($default_category['feature_value']);
                $lang['party'] = $category->name;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $category->name);
                $transactions = Transaction::whereBetween('payment_date', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->where('trans_category_id', '=', $category->id)->get();

                break;

            case 'customer':
                if (!$reports->account) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $account_details = Customer::where('id', '=', $reports->account)->first();
                $lang['title'] = trans('meta.customer_statement');
                $lang['title2'] = trans('customers.customer');
                $lang['module'] = 'customer_statement';
                $lang['party'] = $account_details->name . '<br>' . $account_details->email . '<br>' . $account_details->phone;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $account_details->name);
                break;
            case 'supplier':
                if (!$reports->account) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $account_details = Supplier::where('id', '=', $reports->account)->first();
                $lang['title'] = trans('meta.supplier_statement');
                $lang['title2'] = trans('suppliers.supplier');
                $lang['module'] = 'supplier_statement';
                $lang['party'] = $account_details->name . '<br>' . $account_details->email . '<br>' . $account_details->phone;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $account_details->name);
                break;


        }

        switch ($reports->trans_type) {
            case 'credit':
                $transactions = $account_details->transactions->whereBetween('payment_date', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->where('credit', '>', 0);
                break;
            case 'debit':
                $transactions = $account_details->transactions->whereBetween('payment_date', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->where('debit', '>', 0);
                break;
            case 'all':
                $transactions = $account_details->transactions->whereBetween('payment_date', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)]);
                break;
        }


        switch ($reports->output_format) {

            case 'pdf_print':
                $html = view('focus.report.pdf.account', compact('account_details', 'transactions', 'lang'))->render();
                $headers = array(
                    "Content-type" => "application/pdf",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                break;
            case 'pdf':
                $html = view('focus.report.pdf.account', compact('account_details', 'transactions', 'lang'))->render();
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return $pdf->Output($file_name . '.pdf', 'D');
                break;
            case 'csv':
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=$file_name.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $columns = array(trans('transactions.payment_date'), trans('general.description'), trans('transactions.debit'), trans('transactions.credit'), trans('accounts.balance'));
                $callback = function () use ($transactions, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);
                    $balance = 0;

                    foreach ($transactions as $row) {
                        $balance += $row['credit'] - $row['debit'];
                        fputcsv($file, array(dateFormat($row['payment_date']), $row['note'], amountFormat($row['debit']), amountFormat($row['credit']), amountFormat($balance)));
                    }
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);
                break;
        }
    }

    public function generate_tax_statement(ManageReports $reports)
    {
        if (!$reports->from_date) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
        $pdf_name = 'tax';
        switch ($reports->tax_type) {

            case 'tax_sales':
                $account_details = Invoice::whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
                $lang['title'] = trans('meta.tax_statement');
                $lang['title2'] = trans('meta.tax_statement');
                $lang['module'] = 'tax_statement';
                $lang['party'] = config('core.cname');
                $lang['party_2'] = trans('customers.customer');
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
            case 'tax_purchase':
                $account_details = Purchaseorder::whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
                $lang['title'] = trans('meta.tax_statement_purchase');
                $lang['title2'] = trans('meta.tax_statement_purchase');
                $lang['module'] = 'tax_statement';
                $lang['party'] = config('core.cname');
                $lang['party_2'] = trans('suppliers.supplier');
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
            case 'tax_gst':
                $account_details = Invoice::whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
                $lang['title'] = trans('meta.tax_statement');
                $lang['title2'] = trans('meta.tax_statement');
                $lang['module'] = 'gst_statement';
                $lang['party'] = config('core.cname');
                $lang['party_2'] = trans('customers.customer');
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                $pdf_name = 'gst';
                break;
        }


        switch ($reports->output_format) {

            case 'pdf_print':
                $html = view('focus.report.pdf.' . $pdf_name, compact('account_details', 'lang'))->render();
                $headers = array(
                    "Content-type" => "application/pdf",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                break;
            case 'pdf':
                $html = view('focus.report.pdf.tax', compact('account_details', 'lang'))->render();
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return $pdf->Output($file_name . '.pdf', 'D');
                break;

            case 'csv':
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=$file_name.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $columns = array(trans('general.date'), trans('orders.order'), trans('customers.customer'), trans('general.total'), trans('general.tax'), trans('accounts.balance'));

                if ($reports->tax_type == 'tax_gst') {
                    $columns[7] = 'GSTIN';
                    $columns[8] = 'CGST';
                    $columns[9] = 'SGST';
                    $columns[10] = 'IGST';
                }
                $callback = function () use ($account_details, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);
                    $balance = 0;
                    if (count($columns)==10) {
                        foreach ($account_details as $row) {
                            $balance += $row['tax'];
                            $cgst = 0;
                            $sgst = 0;
                            $igst = 0;
                            $balance += $row['tax'];
                            if ($row['tax_format'] == 'cgst') {
                                $cgst = $row['tax'] / 2;
                                $sgst = $row['tax'] / 2;
                            } else {
                                $igst = $row['tax'];
                            }
                            fputcsv($file, array(dateFormat($row['invoicedate']), $row['tid'], $row->customer->name, amountFormat($row['total']), amountFormat($row['tax']), amountFormat($balance), $row->customer->taxid, amountFormat($cgst), amountFormat($sgst) , amountFormat($igst)));
                        }
                    } else {
                        foreach ($account_details as $row) {
                            $balance += $row['tax'];
                            fputcsv($file, array(dateFormat($row['invoicedate']), $row['tid'], $row->customer->name, amountFormat($row['total']), amountFormat($row['tax']), amountFormat($balance)));
                        }
                    }
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);
                break;
        }
    }

    public function generate_stock_statement(ManageReports $reports)
    {

        switch ($reports->stock_action) {
            case 'warehouse':
                if (!$reports->from_warehouse) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $account_details = ProductMeta::when($reports->from_warehouse != 'all', function ($q) use ($reports) {
                    return $q->where('ref_id', '=', $reports->from_warehouse);
                })->when($reports->to_warehouse != 'all', function ($q) use ($reports) {
                    return $q->where('value2', '=', $reports->to_warehouse);
                })->whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->where('rel_type', '=', 1)->get();
                $lang['title'] = trans('meta.stock_transfer_statement');
                $lang['title2'] = trans('meta.stock_transfer_statement_warehouse');
                $lang['module'] = 'warehouse';
                $lang['party'] = config('core.cname');
                $lang['party_2'] = trans('customers.customer');
                $transfer = 1;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
            //product stock transfer
            case 'product':
                if (!$reports->product_name) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $account_details = ProductMeta:: where('rel_id', '=', $reports->product_name)->where('rel_type', '=', 1)->when($reports->to_warehouse != 'all', function ($q) use ($reports) {
                    return $q->where('value2', '=', $reports->to_warehouse);
                })->whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
                $lang['title'] = trans('meta.stock_transfer_statement');
                $lang['title2'] = trans('meta.stock_transfer_statement_product');
                $lang['module'] = 'product';
                $lang['party'] = config('core.cname');
                $lang['party_2'] = trans('customers.customer');
                $transfer = 1;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;

            case 'product_statement':
                if (!$reports->product_name) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                if ($reports->type_p == 'sales') {
                    $lang['title2'] = trans('meta.product_statement_sales');

                    $account_details = InvoiceItem::where('product_id', '=', $reports->product_name)->whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();

                } elseif ($reports->type_p == 'purchase') {
                    $lang['title2'] = trans('meta.product_statement_purchase');
                    $account_details = PurchaseItem::where('product_id', '=', $reports->product_name)->whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
                }
                $product = ProductVariation::where('id', '=', $reports->product_name)->first();
                $lang['title'] = trans('meta.product_statement');

                $lang['module'] = 'product_statement';
                $lang['party'] = $product->product['name'] . ' ' . $product['name'];
                $lang['party_2'] = trans('products.product');
                $transfer = 2;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;

            case 'product_category_statement':
                if (!$reports->product_category) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $cat_id = $reports->product_category;
                if ($reports->type_p == 'sales') {
                    $lang['title2'] = trans('meta.product_statement_sales');
                    $account_details = InvoiceItem::whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->whereHas('variation', function ($q) use ($cat_id) {
                        return $q->whereHas('product', function ($q) use ($cat_id) {
                            return $q->where('productcategory_id', '=', $cat_id);
                        });
                    })->get();


                } elseif ($reports->type_p == 'purchase') {
                    $lang['title2'] = trans('meta.product_statement_purchase');
                    $account_details = PurchaseItem::whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->whereHas('variation', function ($q) use ($cat_id) {
                        return $q->whereHas('product', function ($q) use ($cat_id) {
                            return $q->where('productcategory_id', '=', $cat_id);
                        });
                    })->get();
                }
                $product = Productcategory::where('id', '=', $reports->product_category)->first();
                $lang['title'] = trans('meta.product_category_statement');
                $lang['module'] = 'product_statement';
                $lang['party'] = $product['title'];
                $lang['party_2'] = trans('products.product');
                $transfer = 2;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;

            case 'product_warehouse_statement':
                if (!$reports->warehouse) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                $cat_id = $reports->warehouse;
                if ($reports->type_p == 'sales') {
                    $account_details = InvoiceItem::whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->whereHas('variation', function ($q) use ($cat_id) {
                        return $q->where('warehouse_id', '=', $cat_id);
                    })->get();
                    $lang['title2'] = trans('meta.product_statement_sales');

                } elseif ($reports->type_p == 'purchase') {
                    $account_details = PurchaseItem::whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->whereHas('variation', function ($q) use ($cat_id) {
                        return $q->where('warehouse_id', '=', $cat_id);
                    })->get();
                    $lang['title2'] = trans('meta.product_statement_purchase');
                }
                $product = Productcategory::where('id', '=', $reports->product_category)->first();
                $lang['title'] = trans('meta.product_warehouse_statement');
                $lang['module'] = 'product_statement';
                $lang['party'] = $product['title'];
                $lang['party_2'] = trans('products.product');
                $transfer = 2;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
            case 'product_customer_statement':
                if (!$reports->person) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);

                if ($reports->type_p == 'sales') {
                    $account_details = Invoice::where('customer_id', '=', $reports->person)->whereBetween('invoicedate', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->with('products')->get()->pluck('products');
                    $lang['title2'] = trans('customers.customer');
                    $lang['title'] = trans('meta.product_customer_statement');
                    $customer = Customer::find($reports->person);
                    $lang['party'] = $customer->name;

                }

                $lang['module'] = 'product_statement';
                $lang['party_2'] = trans('products.product');
                $transfer = 3;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
            case 'product_supplier_statement':
                if (!$reports->person) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);


                $account_details = Purchaseorder::whereBetween('created_at', [datetime_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->with('products')->get()->pluck('products');
                $lang['title2'] = trans('suppliers.supplier');
                $lang['title'] = trans('meta.product_supplier_statement');
                $supplier = Supplier::find($reports->person);
                $lang['party'] = $supplier->name;


                $lang['module'] = 'product_statement';
                $lang['party_2'] = trans('products.product');
                $transfer = 3;
                $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);
                break;
        }

        if ($transfer == 1) {
            switch ($reports->output_format) {

                case 'pdf_print':

                    $html = view('focus.report.pdf.stock_transfer', compact('account_details', 'lang'))->render();
                    $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);

                    break;
                case 'pdf':
                    $html = view('focus.report.pdf.stock_transfer', compact('account_details', 'lang'))->render();
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return $pdf->Output($file_name . '.pdf', 'D');
                    break;

                case 'csv':
                    $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=$file_name.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $columns = array(trans('general.date'), trans('products.product'), trans('products.stock_transfer_from'), trans('products.stock_transfer_to'), trans('products.qty'), trans('general.total'));
                    $callback = function () use ($account_details, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);
                        $balance = 0;

                        foreach ($account_details as $row) {
                            $balance += $row['value'];
                            fputcsv($file, array(dateFormat($row['created_at']), @$row->product->product['name'] . ' ' . @$row->product['name'], $row->from_warehouse['title'], $row->to_warehouse['title'], numberFormat($row['value']), numberFormat($balance) . ' ' . @$row->product->product['unit']));
                        }
                        fclose($file);
                    };
                    return Response::stream($callback, 200, $headers);
                    break;
            }
        }
        if ($transfer == 2) {
            switch ($reports->output_format) {

                case 'pdf_print':
                    $html = view('focus.report.pdf.product', compact('account_details', 'lang'))->render();
                    $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                    break;
                case 'pdf':
                    $html = view('focus.report.pdf.product', compact('account_details', 'lang'))->render();
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return $pdf->Output($file_name . '.pdf', 'D');
                    break;

                case 'csv':
                    $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=$file_name.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $columns = array(trans('general.date'), trans('products.product'), trans('products.price'), trans('products.qty'), trans('general.total'));
                    $callback = function () use ($account_details, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);
                        $balance = 0;

                        foreach ($account_details as $row) {
                            $balance += $row['product_qty'];
                            fputcsv($file, array(dateFormat($row['created_at']), $row['product_name'], amountFormat($row['product_price']), numberFormat($row['product_qty']) . ' ' . $row['unit'], numberFormat($balance)));
                        }
                        fclose($file);
                    };
                    return Response::stream($callback, 200, $headers);
                    break;
            }
        }
        if ($transfer == 3) {
            switch ($reports->output_format) {

                case 'pdf_print':
                    $html = view('focus.report.pdf.product_person', compact('account_details', 'lang'))->render();
                    $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                    break;
                case 'pdf':
                    $html = view('focus.report.pdf.product_person', compact('account_details', 'lang'))->render();
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return $pdf->Output($reports->section . '.pdf', 'D');
                    break;

                case 'csv':
                    $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=$file_name.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $columns = array(trans('general.date'), trans('products.product'), trans('products.price'), trans('products.qty'), trans('general.total'));
                    $callback = function () use ($account_details, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);
                        $balance = 0;
                        foreach ($account_details as $account_detail) {
                            foreach ($account_detail as $row) {
                                $balance += $row['product_qty'];
                                fputcsv($file, array(dateFormat($row['created_at']), @$row['product_name'], amountFormat($row['product_price']), numberFormat($row['product_qty']), numberFormat($balance) . ' ' . $row['unit']));
                            }
                        }
                        fclose($file);

                    };
                    return Response::stream($callback, 200, $headers);
                    break;
            }
        }
    }


    public function pos_statement(ManageReports $reports)
    {
        if (!$reports->from_date) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);

        $register_entries = Register::whereBetween('created_at', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])->get();
        $lang['title'] = trans('meta.pos_statement');
        $lang['title2'] = trans('meta.pos_statement');
        $lang['module'] = 'pos_statement';
        $lang['party'] = config('core.cname');
        $lang['party_2'] = '';
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $reports->from_date);


        switch ($reports->output_format) {

            case 'view':

                return view('focus.report.pdf.pos_view_register', compact('register_entries', 'lang'));

                break;

            case 'pdf_print':

                $html = view('focus.report.pdf.pos_register', compact('register_entries', 'lang'))->render();
                $headers = array(
                    "Content-type" => "application/pdf",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                break;
            case 'pdf':
                $html = view('focus.report.pdf.pos_register', compact('register_entries', 'lang'))->render();
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                return $pdf->Output($file_name . '.pdf', 'D');
                break;

            case 'csv':
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=$file_name.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );
                $columns = array(trans('pos.opened_on'), trans('pos.closed_on'), trans('general.employee'), trans('general.description'));
                $callback = function () use ($register_entries, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);
                    foreach ($register_entries as $row) {
                        $bal = '';
                        $balance = json_decode($row->data, true);
                        foreach ($balance as $key => $amount_row) {
                            $bal .= $key . ' : ' . amountFormat($amount_row) . '<br>';
                        }
                        fputcsv($file, array(dateFormat($row['created_at']), dateFormat($row['closed_at']), $row->user->first_name . ' ' . $row->user->last_name, $bal));
                    }
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);
                break;
        }
    }

    public function generate_market_statement(ManageReports $reports)
    {

        switch ($reports->section) {
            case 'market':
                if (!$reports->channel) return new RedirectResponse(route('biller.reports.statements', [$reports->section]), ['flash_error' => trans('meta.invalid_entry')]);
                if ($reports->channel != 'all') {
                    $account_details = SalesChannel::where('id', '=', $reports->channel)->with(['invoice'])->first();

                    $lang['title'] = trans('sales_channel.sales_channel_statement');
                    $lang['title2'] = trans('sales_channel.sales');
                    $lang['module'] = 'market_statement';

                    $lang['party'] = $account_details->name;
                    $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_' . $account_details->name);
                } else {
                    $account_details = SalesChannel::get();
                    $lang['title'] = trans('sales_channel.sales_channel_statement');
                    $lang['title2'] = trans('sales_channel.sales');
                    $lang['module'] = 'market_statement';
                    $channels = '';
                    if (is_array($account_details)) {
                        foreach ($account_details as $account_detail) {
                            $channels .= $account_detail->name . ' <br>';
                        }
                    }
                    $lang['party'] = $channels;
                    $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', $lang['title'] . '_all');
                }
                break;


        }

        if ($reports->channel != 'all') {

            switch ($reports->trans_type) {
                case 'invoice':
                    $lang['bill_type'] = trans('invoices.invoice');;
                    $lang['title2'] = trans('sales_channel.sales');
                    $transactions = ChannelBill::where('c_id', '=', $account_details->id)->with(['invoice'])->whereHas('invoice', function ($query) use ($reports) {
                        $query->whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)]);
                    })->get();

                    break;
                case 'purchaseorders':
                    $lang['title2'] = trans('sales_channel.purchase');
                    $lang['bill_type'] = trans('purchaseorders.purchaseorders');;
                    $transactions = ChannelBill::where('c_id', '=', $account_details->id)->with(['purchaseorders'])->whereHas('purchaseorders', function ($query) use ($reports) {
                        $query->whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)]);
                    })->get();
                    break;

            }
        } else {

            switch ($reports->trans_type) {
                case 'invoice':
                    $lang['bill_type'] = trans('invoices.invoice');;
                    $lang['title2'] = trans('sales_channel.sales');
                    $lang['party'] = $reports->from_date . ' - ' . $reports->to_date;
                    //    $transactions = ChannelBill::with(['bill'])->whereHas('invoice', function ($query) use ($reports) {
                    //         $query->whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database($reports->to_date)]);
                    //        $query->selectRaw("SUM(total) as total_sales");

                    //     })->groupBy('c_id')->get();
                    // dd($transactions);
                    $transactions = ChannelBill::join('invoices', 'invoices.id', '=', 'channel_bill.bill_id')->join('channel', 'channel.id', '=', 'channel_bill.c_id')
                        ->selectRaw('SUM(rose_invoices.total) as total_sales,rose_channel.name')
                        ->groupBy('channel_bill.c_id')->where('channel_bill.ref', '=', 1)->whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])
                        ->get();
                    //dd($transactions2);
                    break;
                case 'purchaseorders':
                    $lang['title2'] = trans('sales_channel.purchase');
                    $lang['bill_type'] = trans('purchaseorders.purchaseorders');
                    $lang['party'] = $reports->from_date . ' - ' . $reports->to_date;
                    $transactions = ChannelBill::join('purchase_orders', 'purchase_orders.id', '=', 'channel_bill.bill_id')->join('channel', 'channel.id', '=', 'channel_bill.c_id')
                        ->selectRaw('SUM(rose_purchase_orders.total) as total_sales,rose_channel.name')
                        ->groupBy('channel_bill.c_id')->where('channel_bill.ref', '=', 2)->whereBetween('invoicedate', [date_for_database($reports->from_date), date_for_database_plus($reports->to_date)])
                        ->get();
                    break;

            }
        }


        if ($reports->channel != 'all') {

            switch ($reports->output_format) {

                case 'pdf_print':
                    $html = view('focus.report.pdf.market', compact('account_details', 'transactions', 'lang'))->render();
                    $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                    break;
                case 'pdf':
                    $html = view('focus.report.pdf.account', compact('account_details', 'transactions', 'lang'))->render();
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return $pdf->Output($file_name . '.pdf', 'D');
                    break;
                case 'csv':
                    $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=$file_name.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $columns = array(trans('sales_channel.sales_channel'), trans('general.amount'));
                    $callback = function () use ($transactions, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);
                        $balance = 0;

                        foreach ($transactions as $row) {
                            $balance += $row->invoice['total'];
                            fputcsv($file, array(dateFormat($row->invoice['invoicedate']), $row->invoice['tid'], amountFormat($row->invoice['total_sales']), amountFormat($balance)));
                        }
                        fclose($file);
                    };

            }
        } else {
            switch ($reports->output_format) {

                case 'pdf_print':
                    $html = view('focus.report.pdf.market_extended', compact('account_details', 'transactions', 'lang'))->render();
                    $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return Response::stream($pdf->Output($file_name . '.pdf', 'I'), 200, $headers);
                    break;
                case 'pdf':
                    $html = view('focus.report.pdf.account', compact('account_details', 'transactions', 'lang'))->render();
                    $pdf = new \Mpdf\Mpdf(config('pdf'));
                    $pdf->WriteHTML($html);
                    return $pdf->Output($file_name . '.pdf', 'D');
                    break;
                case 'csv':
                    $headers = array(
                        "Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=$file_name.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                    );
                    $columns = array(trans('sales_channel.sales_channel'), trans('general.amount'));
                    $callback = function () use ($transactions, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);
                        $balance = 0;

                        foreach ($transactions as $row) {
                            $balance += $row->invoice['total'];
                            fputcsv($file, array($row['name'], amountFormat($row['total_sales'])));
                        }
                        fclose($file);
                    };
                    return Response::stream($callback, 200, $headers);
                    break;
            }
        }
    }

}
