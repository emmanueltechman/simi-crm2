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
namespace App\Http\Controllers\Focus\import;

use App\Http\Requests\Focus\report\ManageImport;
use App\Http\Requests\Focus\report\ManageReports;
use App\Http\Responses\RedirectResponse;
use App\Imports\AccountsImport;
use App\Imports\CustomersImport;
use App\Imports\ProductsImport;
use App\Imports\TransactionsImport;
use App\Models\account\Account;
use App\Models\productcategory\Productcategory;
use App\Models\transactioncategory\Transactioncategory;
use App\Models\warehouse\Warehouse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

/**
 * ImportController
 */
class ImportController extends Controller
{
    private $upload_temp;

    public function __construct()
    {
        $this->upload_temp = Storage::disk('public');
    }

    public function index(ManageImport $request)
    {
        if ($request->post()) {

            $request->validate([
                'import_file' => 'required|max:' . config('master.file_size')]);
            $extension = File::extension($request->import_file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

            } else {
                return new RedirectResponse(route('biller.import.general', [$request->type]), ['flash_error' => trans('import.import_invalid_file')]);
            }

            $move = false;
            $data = array();
            $file = $request->file('import_file');
            $filename = date('Ymd_his') . rand(9999, 99999) . $file->getClientOriginalName();
            $temp_path = 'temp' . DIRECTORY_SEPARATOR;
            switch ($request->type) {
                case 'customer' :
                    $move = $this->upload_temp->put($temp_path . $filename, file_get_contents($file->getRealPath()));
                    $data['customer_password_type'] = $request->customer_password_type;
                    session(['customer_password' => $request->customer_password]);
                    break;
                case  'products':
                    $move = $this->upload_temp->put($temp_path . $filename, file_get_contents($file->getRealPath()));
                    $data['productcategory'] = $request->productcategory;
                    $data['warehouse'] = $request->warehouse;
                    break;
                case  'accounts':
                    $move = $this->upload_temp->put($temp_path . $filename, file_get_contents($file->getRealPath()));
                    break;
                case  'transactions':
                    $move = $this->upload_temp->put($temp_path . $filename, file_get_contents($file->getRealPath()));
                    $data['accounts'] = $request->account;
                    $data['transaction_categories'] = $request->trans_category;
                    break;
            }

            if ($move) {
                $response = 1;
                $file_value = $filename;
                $section = $request->type;
                return view('focus.import.step_1', compact('response', 'file_value', 'section', 'data'));
            }

        } elseif ($request->type) {
            $words['title'] = '';
            $words['template_path'] = '';
            $data = array();
            switch ($request->type) {
                case 'customer' :
                    $words['title'] = trans('import.import_customers');
                    $words['template_path'] = $request->type;
                    break;
                case 'products' :
                    $data['product_category'] = Productcategory::all();
                    $data['warehouses'] = Warehouse::all();
                    $words['title'] = trans('import.import_products');
                    $words['template_path'] = $request->type;
                    break;
                case 'accounts' :
                    $words['title'] = trans('import.import_accounts');
                    $words['template_path'] = $request->type;
                    break;
                case 'transactions' :
                    $words['title'] = trans('import.import_transactions');
                    $data['accounts'] = Account::all();
                    $data['transaction_categories'] = Transactioncategory::all();
                    $words['template_path'] = $request->type;
                    break;
            }

            if ($words['title']) return view('focus.import.index', compact('words', 'data'));

        }

    }

    public function import_process(ManageImport $request)
    {
        if ($request->name) {
            $temp_path = 'temp' . DIRECTORY_SEPARATOR;
            $path = Storage::disk('public')->exists($temp_path . $request->name);
            if ($path) {
                $path = Storage::disk('public')->path($temp_path . $request->name);
                $data = array();
                switch ($request->type) {
                    case 'customer' :
                        if ($request->customer_password_type == 1) {
                            $data['password'] = $request->session()->pull('customer_password', null);
                        }
                        $import = new CustomersImport($data);
                        break;
                    case 'products' :
                        $data['category'] = $request->productcategory;
                        $data['warehouse'] = $request->warehouse;
                        $import = new ProductsImport($data);
                        break;

                    case 'accounts' :
                        $import = new AccountsImport();
                        break;
                    case 'transactions' :
                        $data['account'] = $request->accounts;
                        $data['trans_category'] = $request->transaction_categories;
                        $import = new TransactionsImport($data);
                        break;
                }


                try {
                    Excel::import($import, $path);
                } catch (\Exception $e) {
                    Storage::disk('public')->delete($temp_path . $request->name);
                    return array('status' => 'Error', 'message' => trans('import.import_process_failed'));
                }

                Storage::disk('public')->delete($temp_path . $request->name);
                if (@$import->getRowCount()>-1) {
                    return json_encode(array('status' => 'Success', 'message' => trans('import.import_process_success') . @$import->getRowCount()));
                } else {
                    return array('status' => 'Error', 'message' => trans('import.import_process_failed'));
                }
            }
        }
    }

    public function samples($file_name)
    {
        $file = Storage::disk('public')->get('sample/' . $file_name);


        return (new Response($file, 200))
            ->header('Content-Type', 'text/csv');
    }
}
