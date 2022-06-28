<?php

namespace App\Repositories\Focus\bank;

use DB;
use Carbon\Carbon;
use App\Models\bank\Bank;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankRepository.
 */
class BankRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Bank::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','name','number','enable']);
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
        $input = array_map( 'strip_tags', $input);
        if (Bank::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.banks.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Bank $bank
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Bank $bank, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($bank->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.banks.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Bank $bank
     * @throws GeneralException
     * @return bool
     */
    public function delete(Bank $bank)
    {
        if ($bank->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.banks.delete_error'));
    }
}
