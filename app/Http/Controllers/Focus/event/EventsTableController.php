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
namespace App\Http\Controllers\Focus\event;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\event\EventRepository;
use App\Http\Requests\Focus\event\ManageEventRequest;

/**
 * Class EventsTableController.
 */
class EventsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var EventRepository
     */
    protected $event;

    /**
     * contructor to initialize repository object
     * @param EventRepository $event ;
     */
    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    /**
     * This method return the data of the model
     * @param ManageEventRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageEventRequest $request)
    {
        //
        $core = $this->event->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('created_at', function ($event) {
                return Carbon::parse($event->created_at)->toDateString();
            })
            ->addColumn('actions', function ($event) {
                return $event->action_buttons;
            })
            ->make(true);
    }
}
