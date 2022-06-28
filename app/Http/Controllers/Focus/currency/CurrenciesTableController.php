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
namespace App\Http\Controllers\Focus\currency;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\currency\CurrencyRepository;
use App\Http\Requests\Focus\currency\ManageCurrencyRequest;

/**
 * Class CurrenciesTableController.
 */
class CurrenciesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var CurrencyRepository
     */
    protected $currency;

    /**
     * contructor to initialize repository object
     * @param CurrencyRepository $currency ;
     */
    public function __construct(CurrencyRepository $currency)
    {
        $this->currency = $currency;
    }

    /**
     * This method return the data of the model
     * @param ManageCurrencyRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->currency->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('created_at', function ($currency) {
                return dateFormat($currency->created_at);
            })
            ->addColumn('actions', function ($currency) {
                return $currency->action_buttons;
            })
            ->make(true);
    }
}
