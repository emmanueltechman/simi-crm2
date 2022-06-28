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
namespace App\Http\Controllers\Focus\prefix;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\prefix\PrefixRepository;
use App\Http\Requests\Focus\prefix\ManagePrefixRequest;

/**
 * Class PrefixesTableController.
 */
class PrefixesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PrefixRepository
     */
    protected $prefix;

    /**
     * contructor to initialize repository object
     * @param PrefixRepository $prefix ;
     */
    public function __construct(PrefixRepository $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * This method return the data of the model
     * @param ManagePrefixRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->prefix->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('note', function ($prefix) {
                return trans('prefixes.' . $prefix->note);
            })
            ->addColumn('created_at', function ($prefix) {
                return dateFormat($prefix->created_at);
            })
            ->addColumn('actions', function ($prefix) {
                return $prefix->action_buttons;
            })
            ->make(true);
    }
}
