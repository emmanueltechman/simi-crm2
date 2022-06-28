<?php

namespace App\Http\Responses\Focus\event;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\event\Event
     */
    protected $events;

    /**
     * @param App\Models\event\Event $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('focus.events.edit')->with([
            'events' => $this->events
        ]);
    }
}