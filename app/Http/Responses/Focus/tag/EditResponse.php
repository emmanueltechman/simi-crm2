<?php

namespace App\Http\Responses\Focus\tag;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\tag\Tag
     */
    protected $tags;

    /**
     * @param App\Models\tag\Tag $tags
     */
    public function __construct($tags)
    {
        $this->tags = $tags;
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
        return view('focus.tags.edit')->with([
            'tags' => $this->tags
        ]);
    }
}