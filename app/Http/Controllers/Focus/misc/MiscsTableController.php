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
namespace App\Http\Controllers\Focus\misc;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\misc\MiscRepository;
use App\Http\Requests\Focus\misc\ManageMiscRequest;

/**
 * Class MiscsTableController.
 */
class MiscsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var MiscRepository
     */
    protected $misc;

    /**
     * contructor to initialize repository object
     * @param MiscRepository $misc ;
     */
    public function __construct(MiscRepository $misc)
    {
        $this->misc = $misc;
    }

    /**
     * This method return the data of the model
     * @param ManageMiscRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageMiscRequest $request)
    {
        //
        $core = $this->misc->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('color', function ($tag) {
                return '<div class="badge white" style="background-color: ' . $tag->color . '; color: #0b97c4">Color</div>';
            })
            ->addColumn('actions', function ($tag) {
                return $tag->action_buttons;
            })
            ->make(true);
    }
}
