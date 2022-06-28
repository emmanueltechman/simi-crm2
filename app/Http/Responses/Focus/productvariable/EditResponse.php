<?php

namespace App\Http\Responses\Focus\productvariable;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\productvariable\Productvariable
     */
    protected $productvariables;

    /**
     * @param App\Models\productvariable\Productvariable $productvariables
     */
    public function __construct($productvariables)
    {
        $this->productvariables = $productvariables;
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
        return view('focus.productvariables.edit')->with([
            'productvariables' => $this->productvariables
        ]);
    }
}