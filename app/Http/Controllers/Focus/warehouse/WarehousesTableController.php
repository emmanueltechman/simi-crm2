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
namespace App\Http\Controllers\Focus\warehouse;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\warehouse\WarehouseRepository;
use App\Http\Requests\Focus\warehouse\ManageWarehouseRequest;

/**
 * Class WarehousesTableController.
 */
class WarehousesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var WarehouseRepository
     */
    protected $warehouse;

    /**
     * contructor to initialize repository object
     * @param WarehouseRepository $warehouse ;
     */
    public function __construct(WarehouseRepository $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * This method return the data of the model
     * @param ManageWarehouseRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageWarehouseRequest $request)
    {
        //
        $core = $this->warehouse->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('name', function ($warehouse) {
                return '<a class="font-weight-bold" href="' . route('biller.products.index') . '?rel_type=2&rel_id=' . $warehouse->id . '">' . $warehouse->title . '</a>';
            })->addColumn('total', function ($warehouse) {
                return numberFormat($warehouse->products->sum('qty'));
            })
            ->addColumn('worth', function ($warehouse) {
                return amountFormat($warehouse->products->sum('total_value'));
            })
            ->addColumn('created_at', function ($warehouse) {
                return dateFormat($warehouse->created_at);
            })
            ->addColumn('actions', function ($warehouse) {
                return '<a class="btn btn-purple round" href="' . route('biller.products.index') . '?rel_type=2&rel_id=' . $warehouse->id . '" title="List"><i class="fa fa-list"></i></a>' . $warehouse->action_buttons;
            })
            ->make(true);
    }
}
