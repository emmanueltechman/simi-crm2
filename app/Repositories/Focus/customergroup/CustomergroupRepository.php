<?php

namespace App\Repositories\Focus\customergroup;

use DB;
use Carbon\Carbon;
use App\Models\customergroup\Customergroup;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomergroupRepository.
 */
class CustomergroupRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Customergroup::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
       //  ->join('blogs', 'customers.id', '=', 'blogs.id');
        return $this->query()
            ->get(['id','title','disc_rate']);
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
        $input['disc_rate'] = numberClean($input['disc_rate']);
        $result=Customergroup::create($input);
        if ($result->id) {
            return $result->id;
        }
        throw new GeneralException(trans('exceptions.backend.customergroups.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Customergroup $customergroup
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Customergroup $customergroup, array $input)
    {
        $input = array_map( 'strip_tags', $input);
        $input['disc_rate'] = numberClean($input['disc_rate']);
    	if ($customergroup->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.customergroups.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Customergroup $customergroup
     * @throws GeneralException
     * @return bool
     */
    public function delete(Customergroup $customergroup)
    {
        if ($customergroup->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.customergroups.delete_error'));
    }
}
