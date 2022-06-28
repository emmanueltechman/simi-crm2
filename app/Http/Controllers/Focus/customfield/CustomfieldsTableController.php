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
namespace App\Http\Controllers\Focus\customfield;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\customfield\CustomfieldRepository;
use App\Http\Requests\Focus\customfield\ManageCustomfieldRequest;

/**
 * Class CustomfieldsTableController.
 */
class CustomfieldsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CustomfieldRepository
     */
    protected $customfield;

    /**
     * contructor to initialize repository object
     * @param CustomfieldRepository $customfield ;
     */
    public function __construct(CustomfieldRepository $customfield)
    {
        $this->customfield = $customfield;
    }

    /**
     * This method return the data of the model
     * @param ManageCustomfieldRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->customfield->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('module', function ($customfield) {
                $mod = '';
                switch ($customfield->module_id) {
                    case 1:
                        $mod = trans('customers.customer');
                        break;
                    case 2:
                        $mod = trans('invoices.invoice');
                        break;
                    case 3:
                        $mod = trans('products.product');
                        break;
                    case 4:
                        $mod = trans('quotes.quote');
                        break;
                    case 5:
                        $mod = trans('orders.credit_notes');
                        break;
                          case 6:
                        $mod = trans('major.company');
                        break;
                }
                return $mod;
            })
            ->addColumn('created_at', function ($customfield) {
                return dateFormat($customfield->created_at);
            })
            ->addColumn('actions', function ($customfield) {
                return $customfield->action_buttons;
            })
            ->make(true);
    }
}
