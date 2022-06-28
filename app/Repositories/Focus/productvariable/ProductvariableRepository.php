<?php

namespace App\Repositories\Focus\productvariable;

use DB;
use Carbon\Carbon;
use App\Models\productvariable\Productvariable;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductvariableRepository.
 */
class ProductvariableRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Productvariable::class;

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
        if (Productvariable::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.productvariables.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Productvariable $productvariable
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Productvariable $productvariable, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($productvariable->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.productvariables.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Productvariable $productvariable
     * @throws GeneralException
     * @return bool
     */
    public function delete(Productvariable $productvariable)
    {
        if ($productvariable->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.productvariables.delete_error'));
    }
}
