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
namespace App\Http\Controllers\Focus\customer;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\customer\CustomerRepository;
use App\Http\Requests\Focus\customer\ManageCustomerRequest;
use Illuminate\Support\Facades\Storage;

/**
 * Class CustomersTableController.
 */
class CustomersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CustomerRepository
     */
    protected $customer;

    /**
     * contructor to initialize repository object
     * @param CustomerRepository $customer ;
     */
    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    /**
     * This method return the data of the model
     * @param ManageCustomerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCustomerRequest $request)
    {
        //
        $core = $this->customer->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('image', function ($customer) {
                return '<div class="">
<input type="checkbox" name="cust[]" class="custom-checkbox" value="' . $customer->id . '">
                                               
                                                <label><img class="media-object img-lg "
                                                                      src="' . Storage::disk('public')->url('app/public/img/customer/' . $customer->picture) . '"
                                                                      alt="Client Image"></label>
                                            </div>';
            })
            ->addColumn('name', function ($customer) {
                $d = '';
                if (request('due_filter')) {
                    $sum = $customer->invoices->whereIn('status', array('due', 'partial'));
                    $due = $sum->sum('total') - $sum->sum('pamnt');
                    $d = '<span class="badge badge-danger">' . amountFormat($due) . '</span>';
                }
                return '<a class="font-weight-bold" href="' . route('biller.customers.show', [$customer->id]) . '">' . $customer->name . '</a>' . $d;
            })
            ->addColumn('group', function ($customer) {
                $g = '';
                foreach ($customer->group as $row) {
                    $g .= '<a class="badge bg-purple" href="' . route('biller.customers.index') . '?rel_type=0&rel_id=' . $row->group_data->id . '"><i class="fa fa-anchor"></i> ' . $row->group_data->title . '</a> ';
                }
                return $g;
            }
            )
            ->addColumn('created_at', function ($customer) {
                $c = '';
                if ($customer->active) $c = 'checked';
                return '<div class="customer_active icheckbox_flat-aero ' . $c . '" data-cid="' . $customer->id . '" data-active="' . $customer->active . '"></div>';
            })
            ->addColumn('actions', function ($customer) {
                return $customer->action_buttons;
            })
            ->make(true);
    }
}
