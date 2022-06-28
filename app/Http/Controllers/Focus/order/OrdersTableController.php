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
namespace App\Http\Controllers\Focus\order;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\order\OrderRepository;
use App\Http\Requests\Focus\order\ManageOrderRequest;

/**
 * Class OrdersTableController.
 */
class OrdersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var OrderRepository
     */
    protected $order;

    /**
     * contructor to initialize repository object
     * @param OrderRepository $order ;
     */
    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /**
     * This method return the data of the model
     * @param ManageOrderRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageOrderRequest $request)
    {


        $core = $this->order->getForDataTable();
        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($order) {
                return '<a class="font-weight-bold" href="' . route('biller.orders.show', [$order->id]) . '">' . $order->tid . '</a>';
            })
            ->addColumn('customer', function ($order) {
                if (request('section') == 'stockreturn') {
                   if(isset($order->supplier)) return @$order->supplier->name . ' <a class="font-weight-bold" href="' . route('biller.suppliers.show', [@$order->supplier->id]) . '"><i class="ft-eye"></i></a>';
                } else {
                    if(isset($order->customer))  return @$order->customer->name . ' <a class="font-weight-bold" href="' . route('biller.customers.show', [@$order->customer->id]) . '"><i class="ft-eye"></i></a>';
                }
            })
            ->addColumn('created_at', function ($order) {
                return dateFormat($order->invoicedate);
            })
            ->addColumn('total', function ($order) {
                return amountFormat($order->total);
            })
            ->addColumn('status', function ($order) {
                return '<span class="st-' . $order->status . '">' . trans('payments.' . $order->status) . '</span>';
            })
            ->addColumn('actions', function ($order) {
                return $order->action_buttons;
            })->rawColumns(['tid', 'customer', 'actions', 'status', 'total'])
            ->make(true);
    }
}
