<?php

namespace App\Http\Responses\Focus\project;

use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\project\Project
     */
    protected $projects;

    /**
     * @param App\Models\project\Project $projects
     */
    public function __construct($projects)
    {
        $this->projects = $projects;
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
        $mics = Misc::all();
        $employees = Hrm::all();
        $projects =$this->projects;
        return view('focus.projects.edit',compact('mics','employees','projects'));
    }
}