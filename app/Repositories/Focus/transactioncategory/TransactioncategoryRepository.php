<?php

namespace App\Repositories\Focus\transactioncategory;

use App\Models\Company\ConfigMeta;
use DB;
use Carbon\Carbon;
use App\Models\transactioncategory\Transactioncategory;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactioncategoryRepository.
 */
class TransactioncategoryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Transactioncategory::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','name','created_at']);
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
        if (Transactioncategory::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.transactioncategories.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Transactioncategory $transactioncategory
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Transactioncategory $transactioncategory, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($transactioncategory->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.transactioncategories.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Transactioncategory $transactioncategory
     * @throws GeneralException
     * @return bool
     */
    public function delete(Transactioncategory $transactioncategory)
    {

        $feature=ConfigMeta::where('feature_id','=',8)->first('feature_value');
        if($transactioncategory->id==$feature->feature_value){
            return false;
        }
         $feature=ConfigMeta::where('feature_id','=',10)->first('feature_value');
        if($transactioncategory->id==$feature->feature_value){
            return false;
        }




        if ($transactioncategory->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.transactioncategories.delete_error'));
    }
}
