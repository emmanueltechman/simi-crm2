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
namespace App\Http\Controllers\Focus\supplier;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\supplier\SupplierRepository;
use App\Http\Requests\Focus\supplier\ManageSupplierRequest;

/**
 * Class SuppliersTableController.
 */
class SuppliersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var SupplierRepository
     */
    protected $supplier;

    /**
     * contructor to initialize repository object
     * @param SupplierRepository $supplier ;
     */
    public function __construct(SupplierRepository $supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * This method return the data of the model
     * @param ManageSupplierRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageSupplierRequest $request)
    {
        $core = $this->supplier->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('name', function ($supplier) {
                return '<a class="font-weight-bold" href="' . route('biller.suppliers.show', [$supplier->id]) . '">' . $supplier->name . '</a><br><img class="media-object img-lg border"
                                                                      src="' . Storage::disk('public')->url('app/public/img/supplier/' . $supplier->picture) . '"
                                                                      alt="Client Image">';
            })
            ->addColumn('created_at', function ($supplier) {
                $c = '';
                if ($supplier->active) $c = 'checked';
                return '<div class="customer_active icheckbox_flat-aero ' . $c . '" data-cid="' . $supplier->id . '" data-active="' . $supplier->active . '"></div>';
            })
            ->addColumn('actions', function ($supplier) {
                return $supplier->action_buttons;
            })
            ->make(true);
    }
}
