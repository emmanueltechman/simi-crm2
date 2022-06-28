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
namespace App\Http\Controllers\Focus\market;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Repositories\Focus\market\MarketRepository;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\additional\AdditionalRepository;
use App\Http\Requests\Focus\additional\ManageAdditionalRequest;

/**
 * Class AdditionalsTableController.
 */
class MarketTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var AdditionalRepository
     */
    protected $additional;

    /**
     * contructor to initialize repository object
     * @param AdditionalRepository $additional ;
     */
    public function __construct(MarketRepository $additional)
    {
        $this->additional = $additional;
    }

    /**
     * This method return the data of the model
     * @param ManageAdditionalRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->additional->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('created_at', function ($additional) {
                return dateFormat($additional->created_at);
            })
            ->addColumn('actions', function ($additional) {
                return $additional->action_buttons;
            })
            ->make(true);
    }
}
