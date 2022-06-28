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
namespace App\Http\Controllers\Focus\term;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\term\TermRepository;


/**
 * Class TermsTableController.
 */
class TermsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TermRepository
     */
    protected $term;

    /**
     * contructor to initialize repository object
     * @param TermRepository $term ;
     */
    public function __construct(TermRepository $term)
    {
        $this->term = $term;
    }

    /**
     * This method return the data of the model
     * @param ManageTermRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->term->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('type', function ($term) {
                $ty = '';
                switch ($term->type) {
                    case 1 :
                        $ty = trans('invoices.invoices');
                        break;
                    case 2 :
                        $ty = trans('quotes.quotes');
                        break;
                    case 3:
                        $ty = trans('orders.general_bills');
                        break;
                    default :
                        $ty = trans('general.all');
                }

                return $ty;
            })
            ->addColumn('created_at', function ($term) {
                return dateFormat($term->created_at);
            })
            ->addColumn('actions', function ($term) {
                return $term->action_buttons;
            })
            ->make(true);
    }
}
