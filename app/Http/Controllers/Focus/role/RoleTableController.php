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
namespace App\Http\Controllers\Focus\role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\hrm\ManageHrmRequest;
use App\Repositories\Focus\role\RoleRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class RoleTableController.
 */
class RoleTableController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @param RoleRepository $roles
     */
    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageHrmRequest $request)
    {
        return Datatables::of($this->roles->getForDataTable())
            ->escapeColumns(['name', 'sort'])
            ->addColumn('permissions', function ($role) {
                if ($role->all) {
                    return '<span class="label label-success">' . trans('labels.general.all') . '</span>';
                }

                return $role->permission_name;
            })
            ->addColumn('actions', function ($role) {

                if ($role->ins == auth()->user()->ins) {
                    return '<a class="btn btn-flat btn-default btn-primary" href="' . route('biller.role.edit', $role->id) . '">
                    <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-pencil"></i>
                </a> <a class="btn btn-flat btn-default btn-danger" href="' . route('biller.role.destroy', $role->id) . '" data-method="delete"
                        data-trans-button-cancel="' . trans('buttons.general.cancel') . '"
                        data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '"
                        data-trans-title="' . trans('strings.backend.general.are_you_sure') . '">
                            <i data-toggle="tooltip" data-placement="top" title="Delete" class="fa fa-trash"></i>
                    </a>';
                }
                return trans('business.default');
            })
            ->make(true);
    }
}
