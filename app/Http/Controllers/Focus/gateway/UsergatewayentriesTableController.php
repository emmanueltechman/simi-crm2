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
namespace App\Http\Controllers\Focus\gateway;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\gateway\UsergatewayentryRepository;
use App\Http\Requests\Focus\gateway\ManageUsergatewayentryRequest;

/**
 * Class UsergatewayentriesTableController.
 */
class UsergatewayentriesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var UsergatewayentryRepository
     */
    protected $usergatewayentry;

    /**
     * contructor to initialize repository object
     * @param UsergatewayentryRepository $usergatewayentry ;
     */
    public function __construct(UsergatewayentryRepository $usergatewayentry)
    {
        $this->usergatewayentry = $usergatewayentry;
    }

    /**
     * This method return the data of the model
     * @param ManageUsergatewayentryRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->usergatewayentry->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('gateway', function ($usergatewayentry) {
                return $usergatewayentry->gateway['name'];
            })
            ->addColumn('actions', function ($usergatewayentry) {
                return $usergatewayentry->action_buttons;
            })
            ->make(true);
    }
}
