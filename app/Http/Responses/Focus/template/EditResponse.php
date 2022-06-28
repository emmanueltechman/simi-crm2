<?php

namespace App\Http\Responses\Focus\template;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\template\Template
     */
    protected $templates;

    /**
     * @param App\Models\template\Template $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
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
        return view('focus.templates.edit')->with([
            'templates' => $this->templates
        ]);
    }
}