<?php

namespace App\Http\Responses\Focus\misc;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\misc\Misc
     */
    protected $miscs;

    /**
     * @param App\Models\misc\Misc $miscs
     */
    public function __construct($miscs)
    {
        $this->miscs = $miscs;
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
        return view('focus.miscs.edit')->with([
            'miscs' => $this->miscs
        ]);
    }
}