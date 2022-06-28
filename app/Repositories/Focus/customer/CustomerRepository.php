<?php

namespace App\Repositories\Focus\customer;

use App\Models\customergroup\CustomerGroupEntry;
use App\Models\items\CustomEntry;
use DB;
use Carbon\Carbon;
use App\Models\customer\Customer;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Http\Responses\RedirectResponse;
/**
 * Class CustomerRepository.
 */
class CustomerRepository extends BaseRepository
{

    /**
     *customer_picture_path .
     *
     * @var string
     */
    protected $customer_picture_path;


    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;
    /**
     * Associated Repository Model.
     */
    const MODEL = Customer::class;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->customer_picture_path = 'img' . DIRECTORY_SEPARATOR . 'customer' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        $q = $this->query();
        $q->when(request('g_rel_type'), function ($q) {

            return $q->where('rel_id', '=',request('g_rel_id',-1));
        });
        if (!request('g_rel_type') AND request('g_rel_id')) {
            $q->whereHas('group', function ($s) {
                return $s->where('customer_group_id', '=', request('g_rel_id', 0));
            });
        }
        return $q->get(['id','name','company','email','address','picture','active','created_at']);
    }



    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function create(array $input)
    {

        if (!empty($input['data']['picture'])) {
            $input['data']['picture'] = $this->uploadPicture($input['data']['picture']);
        }
        $groups = @$input['data']['groups'];
        unset($input['data']['groups']);
        DB::beginTransaction();
        $input['data'] = array_map( 'strip_tags', $input['data']);
        try {
            $result = Customer::create($input['data']);
        } catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                session()->flash('flash_error', 'Duplicate Email');
            }
            new RedirectResponse(route('biller.customers.create'), ['flash_success' =>trans('exceptions.backend.customers.create_error')]);
           // throw new GeneralException(trans('exceptions.backend.customers.create_error'));
        }


        if (@$result->id) {
            $fields = array();
            if (isset($groups)) {
                $insert_groups = array();
                foreach ($groups as $key => $value) {
                    $insert_groups[] = array('customer_id' => $result->id, 'customer_group_id' => strip_tags($value));
                }
                CustomerGroupEntry::insert($insert_groups);
            }

            if (isset($input['data2']['custom_field'])) {
                foreach ($input['data2']['custom_field'] as $key => $value) {
                    $fields[] = array('custom_field_id' => $key, 'rid' => $result->id, 'module' => 1, 'data' => strip_tags($value), 'ins' => $input['data']['ins']);
                }
                CustomEntry::insert($fields);
            }
            DB::commit();
            return $result;
        }
        return false;

    }

    /**
     * For updating the respective Model in storage
     *
     * @param Customer $customer
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Customer $customer, array $input)
    {

        if (!empty($input['data']['picture'])) {
            $this->removePicture($customer, 'picture');

            $input['data']['picture'] = $this->uploadPicture($input['data']['picture']);
        }
        if (empty($input['data']['password'])) {


          unset($input['data']['password']);
        }
        DB::beginTransaction();
        $groups = @$input['data']['groups'];

        unset($input['data']['groups']);
          $input['data'] = array_map( 'strip_tags', $input['data']);

        try {
            $customer->update($input['data']);

         } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                session()->flash('flash_error', 'Duplicate Email');
            }
               return false;
        }


            if (isset($groups)) {

                $insert_groups = array();
                foreach ($groups as $key => $value) {
                    $insert_groups[] = array('customer_id' => $customer->id, 'customer_group_id' => $value);
                }
                CustomerGroupEntry::where('customer_id',  $customer->id)->delete();

                CustomerGroupEntry::insert($insert_groups);

            } else {
                CustomerGroupEntry::where('customer_id',  $customer->id)->delete();
            }


            if (isset($input['data2']['custom_field'])) {
                foreach ($input['data2']['custom_field'] as $key => $value) {
                    $fields[] = array('custom_field_id' => $key, 'rid' => $customer->id, 'module' => 1, 'data' => strip_tags($value), 'ins' => $customer->ins);
                    CustomEntry::where('custom_field_id', '=', $key)->where('rid', '=', $customer->id)->delete();
                }
                CustomEntry::insert($fields);
            }
            DB::commit();
            return true;



        throw new GeneralException(trans('exceptions.backend.customers.update_error'));
    }

    /*
 * Upload logo image
 */
    public function uploadPicture($logo)
    {
        $path = $this->customer_picture_path;

        $image_name = time() . $logo->getClientOriginalName();

        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));

        return $image_name;
    }

    /*
    * remove logo or favicon icon
    */
    public function removePicture(Customer $customer, $type)
    {
        $path = $this->customer_picture_path;

        if ($customer->$type && $this->storage->exists($path . $customer->$type)) {
            $this->storage->delete($path . $customer->$type);
        }

        $result = $customer->update([$type => null]);

        if ($result) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.settings.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Customer $customer
     * @return bool
     * @throws GeneralException
     */
    public function delete(Customer $customer)
    {
        if ($customer->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.customers.delete_error'));
    }
}
