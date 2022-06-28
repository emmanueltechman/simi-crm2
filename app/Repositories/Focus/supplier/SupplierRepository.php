<?php

namespace App\Repositories\Focus\supplier;

use DB;
use Carbon\Carbon;
use App\Models\supplier\Supplier;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class SupplierRepository.
 */
class SupplierRepository extends BaseRepository
{
    /**
     *customer_picture_path .
     *
     * @var string
     */
    protected $person_picture_path;
    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;
    /**
     * Associated Repository Model.
     */
    const MODEL = Supplier::class;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->person_picture_path = 'img' . DIRECTORY_SEPARATOR . 'supplier' . DIRECTORY_SEPARATOR;
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

        return $this->query()
            ->get();
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
        if (!empty($input['picture'])) {
            $input['picture'] = $this->uploadPicture($input['picture']);
        }
        $input = array_map( 'strip_tags', $input);
        $result=Supplier::create($input);
        if($result ) {
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.suppliers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Supplier $supplier
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Supplier $supplier, array $input)
    {
        if (!empty($input['picture'])) {
            $this->removePicture($supplier, 'picture');

            $input['picture'] = $this->uploadPicture($input['picture']);
        }
        $input = array_map( 'strip_tags', $input);
        if ($supplier->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.suppliers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Supplier $supplier
     * @return bool
     * @throws GeneralException
     */
    public function delete(Supplier $supplier)
    {
        if ($supplier->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.suppliers.delete_error'));
    }
      /*
 * Upload logo image
 */
    public function uploadPicture($logo)
    {
        $path = $this->person_picture_path;

        $image_name = time() . $logo->getClientOriginalName();

        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));

        return $image_name;
    }

    /*
    * remove logo or favicon icon
    */
    public function removePicture(Supplier $supplier, $type)
    {
        $path = $this->person_picture_path;

        if ($supplier->$type && $this->storage->exists($path . $supplier->$type)) {
            $this->storage->delete($path . $supplier->$type);
        }

        $result = $supplier->update([$type => null]);

        if ($result) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.settings.update_error'));
    }
}
