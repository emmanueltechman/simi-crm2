<?php

namespace App\Http\Responses\Focus\currency;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\currency\Currency
     */
    protected $currencies;

    /**
     * @param App\Models\currency\Currency $currencies
     */
    public function __construct($currencies)
    {
        $this->currencies = $currencies;
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
        return view('focus.currencies.edit')->with([
            'currencies' => $this->currencies
        ]);
    }
}