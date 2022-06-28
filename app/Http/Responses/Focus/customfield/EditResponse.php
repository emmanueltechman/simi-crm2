<?php

namespace App\Http\Responses\Focus\customfield;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\customfield\Customfield
     */
    protected $customfields;

    /**
     * @param App\Models\customfield\Customfield $customfields
     */
    public function __construct($customfields)
    {
        $this->customfields = $customfields;
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
        return view('focus.customfields.edit')->with([
            'customfields' => $this->customfields
        ]);
    }
}