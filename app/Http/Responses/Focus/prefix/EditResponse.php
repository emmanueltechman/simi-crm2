<?php

namespace App\Http\Responses\Focus\prefix;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\prefix\Prefix
     */
    protected $prefixes;

    /**
     * @param App\Models\prefix\Prefix $prefixes
     */
    public function __construct($prefixes)
    {
        $this->prefixes = $prefixes;
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
        return view('focus.prefixes.edit')->with([
            'prefixes' => $this->prefixes
        ]);
    }
}