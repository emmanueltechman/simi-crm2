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

use App\Models\event\Event;
use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use App\Repositories\Focus\event\EventRepository;
use App\Http\Requests\Focus\event\ManageEventRequest;
use App\Http\Requests\Focus\event\CreateEventRequest;
use App\Http\Requests\Focus\event\EditEventRequest;
use App\Http\Requests\Focus\event\DeleteEventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * EventsController
 */
class EventsController extends Controller
{
    /**
     * variable to store the repository object
     * @var EventRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param EventRepository $repository ;
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\event\ManageEventRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageEventRequest $request)
    {
        return new ViewResponse('focus.events.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateEventRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        $input['user_id'] = auth()->user()->id;
        //Create the model using repository create method
        $r = $this->repository->create($input);
        //return with successfull message
        return trans('alerts.backend.events.created');
        //  return new RedirectResponse(route('biller.events.index'), ['flash_success' => trans('alerts.backend.events.created')]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteEventRequestNamespace $request
     * @param App\Models\event\Event $event
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Event $event, ManageEventRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.events.view', compact('event'));
    }

    public function load_events()
    {
        //$attend= Attendance::where('user_id','=',1)->get(array('present as start','present as title'));
        $attend = Event::where('user_id', '=', Auth::id())->select(DB::raw("TRIM(CONCAT(start,' - ',end)) AS dates"), 'id', 'title', 'description', 'start', 'end', 'color')->get();

        return $attend->toJson();

    }

    public function update_event(EditEventRequest $request)
    {
        $event = Event::find($request->id);
        if ($request->title) $event->title = $request->title;
        if ($request->description) $event->description = $request->description;
        if ($request->color) $event->color = $request->color;
        $event->start = datetime_for_database($request->start, false);
        $event->end = datetime_for_database($request->end, false);
        $event->save();
        return trans('alerts.backend.events.updated');

    }

    public function delete_event(DeleteEventRequest $request)
    {
        $event = Event::find($request->id);
        $event->delete();
        return trans('alerts.backend.events.deleted');

    }

}
