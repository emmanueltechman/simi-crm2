<?php

namespace App\Http\Responses\Focus\account;

use App\Models\Company\ConfigMeta;
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
         $account_types = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 17)->first('value1');
         $account_types=json_decode($account_types->value1,true);
        return view('focus.accounts.create',compact('account_types'));
    }
}