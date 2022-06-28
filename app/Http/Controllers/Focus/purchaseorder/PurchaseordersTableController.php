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
namespace App\Http\Controllers\Focus\purchaseorder;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\purchaseorder\PurchaseorderRepository;
use App\Http\Requests\Focus\purchaseorder\ManagePurchaseorderRequest;

/**
 * Class PurchaseordersTableController.
 */
class PurchaseordersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PurchaseorderRepository
     */
    protected $purchaseorder;

    /**
     * contructor to initialize repository object
     * @param PurchaseorderRepository $purchaseorder ;
     */
    public function __construct(PurchaseorderRepository $purchaseorder)
    {
        $this->purchaseorder = $purchaseorder;
    }

    /**
     * This method return the data of the model
     * @param ManagePurchaseorderRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePurchaseorderRequest $request)
    {


        $core = $this->purchaseorder->getForDataTable();

        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($purchaseorder) {
                return '<a class="font-weight-bold" href="' . route('biller.purchaseorders.show', [$purchaseorder->id]) . '">' . $purchaseorder->tid . '</a>';
            })
            ->addColumn('supplier_id', function ($purchaseorder) {
                 if(isset($purchaseorder->supplier)) return $purchaseorder->supplier->name . ' <a class="font-weight-bold" href="' . route('biller.suppliers.show', [$purchaseorder->supplier->id]) . '"><i class="ft-eye"></i></a>';
            })
            ->addColumn('created_at', function ($purchaseorder) {
                return dateFormat($purchaseorder->invoicedate);
            })
            ->addColumn('total', function ($purchaseorder) {
                return amountFormat($purchaseorder->total);
            })
            ->addColumn('status', function ($purchaseorder) {
                return '<span class="st-' . $purchaseorder->status . '">' . trans('payments.' . $purchaseorder->status) . '</span>';
            })
            ->addColumn('actions', function ($purchaseorder) {
                return $purchaseorder->action_buttons;
            })->rawColumns(['tid', 'supplier_id', 'actions', 'status', 'total'])
            ->make(true);
    }
}
