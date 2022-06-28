<?php

namespace App\Repositories\Focus\productcategory;

use DB;
use Carbon\Carbon;
use App\Models\productcategory\Productcategory;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductcategoryRepository.
 */
class ProductcategoryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Productcategory::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
       $q=$this->query();
       $q->when(!request('rel_type'), function ($q) {
            return $q->where('c_type', '=',request('rel_type',0));
        });
       $q->when(request('rel_type'), function ($q) {
            return $q->where('rel_id', '=',request('rel_id',0));
        });

        return $q->get();
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
       $c=Productcategory::create($input);
       if ($c->id) return $c->id;
        throw new GeneralException(trans('exceptions.backend.productcategories.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Productcategory $productcategory
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Productcategory $productcategory, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($productcategory->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.productcategories.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Productcategory $productcategory
     * @throws GeneralException
     * @return bool
     */
    public function delete(Productcategory $productcategory)
    {
        if ($productcategory->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.productcategories.delete_error'));
    }
}
