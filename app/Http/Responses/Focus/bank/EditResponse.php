<?php

namespace App\Http\Responses\Focus\bank;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\bank\Bank
     */
    protected $banks;

    /**
     * @param App\Models\bank\Bank $banks
     */
    public function __construct($banks)
    {
        $this->banks = $banks;
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
        return view('focus.banks.edit')->with([
            'banks' => $this->banks
        ]);
    }
}