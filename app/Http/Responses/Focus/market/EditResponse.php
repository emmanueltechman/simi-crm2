<?php

namespace App\Http\Responses\Focus\market;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\additional\Additional
     */
    protected $markets;

    /**
     * @param App\Models\additional\Additional $additionals
     */
    public function __construct($markets)
    {
        $this->markets = $markets;
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

        return view('focus.market.edit')->with([
            'market' => $this->markets
        ]);
    }
}