<?php

namespace App\Http\Responses\Focus\gateway;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\gateway\Usergatewayentry
     */
    protected $usergatewayentries;

    /**
     * @param App\Models\gateway\Usergatewayentry $usergatewayentries
     */
    public function __construct($usergatewayentries)
    {
        $this->usergatewayentries = $usergatewayentries;
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
        return view('focus.gateways.edit')->with([
            'usergatewayentries' => $this->usergatewayentries
        ]);
    }
}