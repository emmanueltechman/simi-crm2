<?php

namespace App\Repositories\Focus\customfield;

use DB;
use Carbon\Carbon;
use App\Models\customfield\Customfield;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomfieldRepository.
 */
class CustomfieldRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Customfield::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','module_id','field_type','name','created_at']);
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
        if (Customfield::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.customfields.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Customfield $customfield
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Customfield $customfield, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($customfield->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.customfields.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Customfield $customfield
     * @throws GeneralException
     * @return bool
     */
    public function delete(Customfield $customfield)
    {
        if ($customfield->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.customfields.delete_error'));
    }
}
