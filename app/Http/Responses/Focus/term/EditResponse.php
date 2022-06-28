<?php

namespace App\Http\Responses\Focus\term;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\term\Term
     */
    protected $terms;

    /**
     * @param App\Models\term\Term $terms
     */
    public function __construct($terms)
    {
        $this->terms = $terms;
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
        return view('focus.terms.edit')->with([
            'terms' => $this->terms
        ]);
    }
}