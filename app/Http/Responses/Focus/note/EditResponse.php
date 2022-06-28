<?php

namespace App\Http\Responses\Focus\note;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\note\Note
     */
    protected $notes;

    /**
     * @param App\Models\note\Note $notes
     */
    public function __construct($notes)
    {
        $this->notes = $notes;
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
        return view('focus.notes.edit')->with([
            'notes' => $this->notes
        ]);
    }
}