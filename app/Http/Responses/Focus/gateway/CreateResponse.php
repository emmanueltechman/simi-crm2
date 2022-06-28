<?php

namespace App\Http\Responses\Focus\gateway;

use App\Models\Company\UserGateway;
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
        $gateways=UserGateway::where('enable','=','Yes')->get();
        return view('focus.gateways.create',compact('gateways'));
    }
}