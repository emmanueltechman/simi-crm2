<?php

namespace App\Http\Responses\Focus\hrm;

use App\Models\Access\Permission\Permission;
use App\Models\Access\Permission\PermissionUser;
use App\Models\Access\Role\Role;
use App\Models\department\Department;
use App\Models\hrm\HrmMeta;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\hrm\Hrm
     */
    protected $hrms;

    /**
     * @param App\Models\hrm\Hrm $hrms
     */
    public function __construct($hrms)
    {
        $this->hrms = $hrms;
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
        $roles=Role::where('status','<',1)->where(function ($query) {
        $query->where('ins', '=', auth()->user()->ins)->orWhereNull('ins');})->get();
        $hrms = $this->hrms;
        $departments = Department::all();
         $general['create']=$this->hrms['id'];
            $emp_role=$this->hrms->role['id'];
        $permissions_all=Permission::whereHas('roles',function ($q) use ($emp_role){
            return $q->where('role_id','=',$emp_role);
        })->get()->toArray();
        $permissions=PermissionUser::all()->keyBy('id')->where('user_id','=',$general['create'])->toArray();
        return view('focus.hrms.edit',compact('hrms','roles','general','permissions_all','permissions','departments'));

    }
}