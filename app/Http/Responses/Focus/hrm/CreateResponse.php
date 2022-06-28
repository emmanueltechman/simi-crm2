<?php

namespace App\Http\Responses\Focus\hrm;

use App\Models\Access\Role\Role;
use App\Models\department\Department;
use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        $roles=Role::where('status','<',1)->where(function ($query) {
        $query->where('ins', '=', auth()->user()->ins)->orWhereNull('ins');})->get();
        $departments = Department::all();
        $general['create']=1;
        return view('focus.hrms.create',compact('roles','general','departments'));
    }
}