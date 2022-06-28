<?php

namespace App\Http\Responses\Focus\misc;

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

                $input['json'] = "module:'tags'";
        $input['title'] = trans('labels.backend.tags.management');
        $input['col1'] = trans('tags.tag');
        $input['col2'] = trans('general.color');
         $input['module'] = "tag";
        if ($request->module == 'task') {
            $input['title'] = trans('tasks.status_management');
            $input['col1'] = trans('tasks.status');
            $input['module'] = "task";
            $input['json'] = "module:'task'";
        }
        return view('focus.miscs.create',compact('input'));
    }
}