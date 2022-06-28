<?php

namespace App\Repositories\Focus\gateway;

use DB;
use Carbon\Carbon;
use App\Models\Gateway\Usergatewayentry;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsergatewayentryRepository.
 */
class UsergatewayentryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Usergatewayentry::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get();
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
        if (Usergatewayentry::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.usergatewayentries.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Usergatewayentry $usergatewayentry
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Usergatewayentry $usergatewayentry, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($usergatewayentry->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.usergatewayentries.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Usergatewayentry $usergatewayentry
     * @throws GeneralException
     * @return bool
     */
    public function delete(Usergatewayentry $usergatewayentry)
    {
        if ($usergatewayentry->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.usergatewayentries.delete_error'));
    }
}
