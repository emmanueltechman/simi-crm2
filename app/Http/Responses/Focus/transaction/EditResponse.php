<?php

namespace App\Http\Responses\Focus\transaction;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\transaction\Transaction
     */
    protected $transactions;

    /**
     * @param App\Models\transaction\Transaction $transactions
     */
    public function __construct($transactions)
    {
        $this->transactions = $transactions;
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
        return view('focus.transactions.edit')->with([
            'transactions' => $this->transactions
        ]);
    }
}