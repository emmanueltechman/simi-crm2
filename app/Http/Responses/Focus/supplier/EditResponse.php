<?php

namespace App\Http\Responses\Focus\supplier;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\supplier\Supplier
     */
    protected $suppliers;

    /**
     * @param App\Models\supplier\Supplier $suppliers
     */
    public function __construct($suppliers)
    {
        $this->suppliers = $suppliers;
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
        return view('focus.suppliers.edit')->with([
            'suppliers' => $this->suppliers
        ]);
    }
}