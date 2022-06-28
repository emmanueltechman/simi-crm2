<?php

namespace App\Http\Responses\Focus\customergroup;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\customergroup\Customergroup
     */
    protected $customergroups;

    /**
     * @param App\Models\customergroup\Customergroup $customergroups
     */
    public function __construct($customergroups)
    {
        $this->customergroups = $customergroups;
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
        return view('focus.customergroups.edit')->with([
            'customergroups' => $this->customergroups
        ]);
    }
}