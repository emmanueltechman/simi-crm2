<?php

namespace App\Http\Responses\Focus\task;

use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\project\Project;
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
        $this->tasks = $projects;
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
        $tasks=$this->tasks;
        $mics = Misc::all();
        $employees = Hrm::all();
        $user = auth()->user()->id;
        $project_select = Project::whereHas('users', function ($q) use ($user) {
            return $q->where('rid', '=', $user);
        })->get();
        return view('focus.projects.tasks.edit',compact('tasks','mics', 'employees', 'project_select'));

    }
}