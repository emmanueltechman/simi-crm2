<?php

namespace App\Http\Responses\Focus\warehouse;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\warehouse\Warehouse
     */
    protected $warehouses;

    /**
     * @param App\Models\warehouse\Warehouse $warehouses
     */
    public function __construct($warehouses)
    {
        $this->warehouses = $warehouses;
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
        return view('focus.warehouses.edit')->with([
            'warehouses' => $this->warehouses
        ]);
    }
}