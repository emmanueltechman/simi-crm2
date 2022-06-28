<?php

namespace App\Repositories\Focus\warehouse;

use DB;
use Carbon\Carbon;
use App\Models\warehouse\Warehouse;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WarehouseRepository.
 */
class WarehouseRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Warehouse::class;

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
        if (Warehouse::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.warehouses.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Warehouse $warehouse
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Warehouse $warehouse, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($warehouse->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.warehouses.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Warehouse $warehouse
     * @throws GeneralException
     * @return bool
     */
    public function delete(Warehouse $warehouse)
    {
        if ($warehouse->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.warehouses.delete_error'));
    }
}
