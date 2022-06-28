<?php

namespace App\Repositories\Focus\misc;

use DB;
use Carbon\Carbon;
use App\Models\misc\Misc;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MiscRepository.
 */
class MiscRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Misc::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        $q = $this->query();
        if (request('module') == 'task') {
            $q->where('section', '=', 2);
        } else {
            $q->where('section', '=', 1);
        }
        return
            $q->get(['id','name','color','section']);
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
        if (Misc::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.miscs.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Misc $misc
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Misc $misc, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($misc->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.miscs.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Misc $misc
     * @throws GeneralException
     * @return bool
     */
    public function delete(Misc $misc)
    {
        if ($misc->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.miscs.delete_error'));
    }
}
