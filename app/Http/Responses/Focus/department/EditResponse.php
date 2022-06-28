<?php

namespace App\Http\Responses\Focus\department;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\department\Department
     */
    protected $departments;

    /**
     * @param App\Models\department\Department $departments
     */
    public function __construct($departments)
    {
        $this->departments = $departments;
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
        return view('focus.departments.edit')->with([
            'departments' => $this->departments
        ]);
    }
}