<?php

namespace App\Repositories\Focus\currency;

use App\Models\Company\ConfigMeta;
use DB;
use Carbon\Carbon;
use App\Models\currency\Currency;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyRepository.
 */
class CurrencyRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Currency::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','code','symbol','rate','created_at']);
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
        if (Currency::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.currencies.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Currency $currency
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Currency $currency, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($currency->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.currencies.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Currency $currency
     * @throws GeneralException
     * @return bool
     */
    public function delete(Currency $currency)
    {

        $feature=ConfigMeta::where('feature_id','=',2)->first('feature_value');
        if($currency->id==$feature->feature_value){
            return false;
        }

        if ($currency->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.currencies.delete_error'));
    }
}
