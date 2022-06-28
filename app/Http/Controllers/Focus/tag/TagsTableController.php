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
namespace App\Http\Controllers\Focus\tag;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\tag\TagRepository;
use App\Http\Requests\Focus\tag\ManageTagRequest;

/**
 * Class TagsTableController.
 */
class TagsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TagRepository
     */
    protected $tag;

    /**
     * contructor to initialize repository object
     * @param TagRepository $tag ;
     */
    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * This method return the data of the model
     * @param ManageTagRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageTagRequest $request)
    {
        //
        $core = $this->tag->getForDataTable();
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
