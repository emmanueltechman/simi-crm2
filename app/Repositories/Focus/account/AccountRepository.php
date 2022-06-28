<?php

namespace App\Repositories\Focus\account;

use DB;
use Carbon\Carbon;
use App\Models\account\Account;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountRepository.
 */
class AccountRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Account::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->get(['id','number','holder','balance','debit','account_type','created_at']);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        $input['balance']= numberClean($input['balance']);
        $input['debit']= numberClean($input['debit']);
        if (Account::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.accounts.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Account $account
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Account $account, array $input)
    {
    	if ($account->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.accounts.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Account $account
     * @throws GeneralException
     * @return bool
     */
    public function delete(Account $account)
    {
        if ($account->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.accounts.delete_error'));
    }
}
