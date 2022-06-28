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
namespace App\Http\Controllers\Focus\department;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\department\DepartmentRepository;
use App\Http\Requests\Focus\department\ManageDepartmentRequest;

/**
 * Class DepartmentsTableController.
 */
class DepartmentsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var DepartmentRepository
     */
    protected $department;

    /**
     * contructor to initialize repository object
     * @param DepartmentRepository $department ;
     */
    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
    }

    /**
     * This method return the data of the model
     * @param ManageDepartmentRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageDepartmentRequest $request)
    {
        //
        $core = $this->department->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('name', function ($department) {
                //  return $department->name;
                return '<a href="' . route('biller.hrms.index') . '?rel_type=2&rel_id=' . $department->id . '">' . $department->name . '</a>';
            })
            ->addColumn('employee', function ($department) {
                return $department->users->count('*');
            })
            ->addColumn('created_at', function ($department) {
                return Carbon::parse($department->created_at)->toDateString();
            })
            ->addColumn('actions', function ($department) {
                return '<a href="' . route('biller.hrms.index') . '?rel_type=2&rel_id=' . $department->id . '" class="btn btn-purple round" data-toggle="tooltip" data-placement="top" title="List"><i class="fa fa-list"></i></a> ' . $department->action_buttons;
            })
            ->make(true);
    }
}
