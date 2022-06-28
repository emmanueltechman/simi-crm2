<?php

namespace App\Http\Responses\Focus\transaction;

use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\transactioncategory\Transactioncategory;
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
        $accounts=Account::all();
        $transaction_categories=Transactioncategory::all();
        $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first('feature_value');

        return view('focus.transactions.create',compact('accounts','transaction_categories','dual_entry'));
    }
}