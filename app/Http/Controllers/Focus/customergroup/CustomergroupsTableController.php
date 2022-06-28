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
namespace App\Http\Controllers\Focus\customergroup;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\customergroup\CustomergroupRepository;
use App\Http\Requests\Focus\customergroup\ManageCustomergroupRequest;

/**
 * Class CustomergroupsTableController.
 */
class CustomergroupsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CustomergroupRepository
     */
    protected $customergroup;

    /**
     * contructor to initialize repository object
     * @param CustomergroupRepository $customergroup ;
     */
    public function __construct(CustomergroupRepository $customergroup)
    {
        $this->customergroup = $customergroup;
    }

    /**
     * This method return the data of the model
     * @param ManageCustomergroupRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCustomergroupRequest $request)
    {
        //
        $core = $this->customergroup->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('title', function ($customergroup) {
                return '<a class="font-weight-bold" href="' . route('biller.customers.index') . '?rel_type=0&rel_id=' . $customergroup->id . '">' . $customergroup->title . '</a>';
            })
            ->addColumn('total', function ($customergroup) {
                return $customergroup->customers->count('id');
            })
            ->addColumn('discount', function ($customergroup) {
                return numberFormat($customergroup->disc_rate) . '%';
            })
            ->addColumn('created_at', function ($customergroup) {
                return dateFormat($customergroup->created_at);
            })
            ->addColumn('actions', function ($customergroup) {
                return '<a class="btn btn-purple round" href="' . route('biller.customers.index') . '?rel_type=0&rel_id=' . $customergroup->id . '" title="List"><i class="fa fa-list"></i></a>' . $customergroup->action_buttons;
            })
            ->make(true);
    }
}
