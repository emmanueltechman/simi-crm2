<?php

namespace App\Http\Responses\Focus\account;

use App\Models\Company\ConfigMeta;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\account\Account
     */
    protected $accounts;

    /**
     * @param App\Models\account\Account $accounts
     */
    public function __construct($accounts)
    {
        $this->accounts = $accounts;
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
        $account_types = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 17)->first('value1');
         $account_types=json_decode($account_types->value1,true);
        return view('focus.accounts.edit')->with([
            'accounts' => $this->accounts,
               'account_types' =>$account_types
        ]);
    }
}