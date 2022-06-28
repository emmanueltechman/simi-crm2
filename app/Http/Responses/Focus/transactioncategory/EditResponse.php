<?php

namespace App\Http\Responses\Focus\transactioncategory;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\transactioncategory\Transactioncategory
     */
    protected $transactioncategories;

    /**
     * @param App\Models\transactioncategory\Transactioncategory $transactioncategories
     */
    public function __construct($transactioncategories)
    {
        $this->transactioncategories = $transactioncategories;
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
        return view('focus.transactioncategories.edit')->with([
            'transactioncategories' => $this->transactioncategories
        ]);
    }
}