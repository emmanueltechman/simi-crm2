<?php

namespace App\Repositories\Focus\product;

use App\Models\product\ProductMeta;
use App\Models\product\ProductVariation;
use DB;
use Carbon\Carbon;
use App\Models\product\Product;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{
    /**
     *file_path .
     *
     * @var string
     */
    protected $file_path;
    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;
    /**
     * Associated Repository Model.
     */
    const MODEL = Product::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->file_path = 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function getForDataTable()
    {
        $q = $this->query();

        $q->when(request('p_rel_id') and !request('p_rel_type'), function ($q) {
            $q->where('sub_cat_id', '=', 0);
            return $q->where('productcategory_id', '=', request('p_rel_id', 0));
        });

        $q->when(request('p_rel_id') and (request('p_rel_type') == 1), function ($q) {
            return $q->where('sub_cat_id', '=', request('p_rel_id', 0));
        });

        return $q->get(['id', 'productcategory_id', 'name', 'sub_cat_id', 'created_at']);

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

        DB::beginTransaction();
        $product_des = strip_tags($input['main']['product_des'], config('general.allowed'));
        $input['main'] = array_map('strip_tags', $input['main']);
        $input['main']['product_des'] = $product_des;
        $product = Product::create($input['main']);
        if ($product->id) {
            $variations = array();
            $i = 0;
            $std_p = 0;
            foreach ($input['variation']['price'] as $key => $value) {

                if (!empty($input['variation']['image'][$key])) {
                    $input['variation']['image'][$key] = $this->uploadFile($input['variation']['image'][$key]);
                } else {
                    $input['variation']['image'][$key] = 'example.png';
                }
                if (!empty($input['variation']['expiry'][$key])) {
                    if (strtotime(date_for_database($input['variation']['expiry'][$key])) > strtotime(date('Y-m-d'))) $input['variation']['expiry'][$key] = date_for_database($input['variation']['expiry'][$key]);
                }
                if (!$input['variation']['barcode'][$key]) $input['variation']['barcode'][$key] = rand(100, 999) . rand(0, 9) . rand(1000000, 9999999) . rand(0, 9);


                if (!$i) {
                    $std = array('product_id' => $product->id, 'parent_id' => 0, 'variation_class' => 0, 'name' => $input['variation']['variation_name'][$key], 'warehouse_id' => $input['variation']['warehouse_id'][$key], 'code' => $input['variation']['code'][$key], 'price' => numberClean($input['variation']['price'][$key]), 'purchase_price' => numberClean($input['variation']['purchase_price'][$key]), 'disrate' => numberClean($input['variation']['disrate'][$key]), 'qty' => numberClean($input['variation']['qty'][$key]), 'alert' => numberClean($input['variation']['alert'][$key]), 'image' => $input['variation']['image'][$key], 'barcode' => $input['variation']['barcode'][$key], 'expiry' => $input['variation']['expiry'][$key], 'ins' => $product->ins);
                    $std = array_map('strip_tags', $std);
                    $std_p = ProductVariation::create($std);
                } else {

                    $variations[] = array('product_id' => $product->id, 'parent_id' => 1, 'variation_class' => 0, 'name' => strip_tags($input['variation']['variation_name'][$key]), 'warehouse_id' => $input['variation']['warehouse_id'][$key], 'code' => $input['variation']['code'][$key], 'price' => numberClean($input['variation']['price'][$key]), 'purchase_price' => numberClean($input['variation']['purchase_price'][$key]), 'disrate' => numberClean($input['variation']['disrate'][$key]), 'qty' => numberClean($input['variation']['qty'][$key]), 'alert' => numberClean($input['variation']['alert'][$key]), 'image' => $input['variation']['image'][$key], 'barcode' => $input['variation']['barcode'][$key], 'expiry' => $input['variation']['expiry'][$key], 'ins' => $product->ins);
                }


                $i++;
            }


            if (is_array($input['custom_field'])) {
                if (ProductVariation::insert($variations)) {
                    save_custom_field($input['custom_field'], $product->id, 3);
                }
            }
            if (isset($input['serial']['product_serial'])) {
                $serial = array();
                foreach ($input['serial']['product_serial'] as $key => $value) {
                    $serial[] = array('rel_type' => 2, 'rel_id' => 0, 'ref_id' => $std_p->id, 'value' => strip_tags($value));
                }
                ProductMeta::insert($serial);
            }
            DB::commit();
            return $product->id;
        }
        throw new GeneralException(trans('exceptions.backend.products.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Product $product
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Product $product, array $input)
    {
        DB::beginTransaction();
        $pv_i = $input['main']['pv_id'];
        unset($input['main']['pv_id']);
        $input['main'] = array_map('strip_tags', $input['main']);
        if ($product->update($input['main'])) {
            // dd($product->id);
            $variations = array();
            $varriation_new = array();
            $i = 0;
            $parent_id = 0;
            foreach ($input['variation']['warehouse_id'] as $key => $value) {
                if (!empty($input['variation']['expiry'][$key])) {
                    if (strtotime(date_for_database($input['variation']['expiry'][$key])) > strtotime(date('Y-m-d'))) $input['variation']['expiry'][$key] = date_for_database($input['variation']['expiry'][$key]);
                }
                if ($input['variation']['v_id'][$key] > 0) {
                    if (!empty($input['variation']['image'][$key])) {
                        $input['variation']['image'][$key] = $this->uploadFile($input['variation']['image'][$key]);
                        $variations[] = array('id' => $input['variation']['v_id'][$key], 'product_id' => $product->id, 'variation_class' => 0, 'name' => strip_tags($input['variation']['variation_name'][$key]), 'warehouse_id' => $input['variation']['warehouse_id'][$key], 'code' => $input['variation']['code'][$key], 'price' => numberClean($input['variation']['price'][$key]), 'purchase_price' => numberClean($input['variation']['purchase_price'][$key]), 'disrate' => numberClean($input['variation']['disrate'][$key]), 'qty' => numberClean($input['variation']['qty'][$key]), 'alert' => numberClean($input['variation']['alert'][$key]), 'image' => $input['variation']['image'][$key], 'barcode' => $input['variation']['barcode'][$key], 'expiry' => $input['variation']['expiry'][$key], 'ins' => $product->ins);
                    } else {
                        $variations[] = array('id' => $input['variation']['v_id'][$key], 'product_id' => $product->id, 'variation_class' => 0, 'name' => strip_tags($input['variation']['variation_name'][$key]), 'warehouse_id' => $input['variation']['warehouse_id'][$key], 'code' => $input['variation']['code'][$key], 'price' => numberClean($input['variation']['price'][$key]), 'purchase_price' => numberClean($input['variation']['purchase_price'][$key]), 'disrate' => numberClean($input['variation']['disrate'][$key]), 'qty' => numberClean($input['variation']['qty'][$key]), 'alert' => numberClean($input['variation']['alert'][$key]), 'barcode' => $input['variation']['barcode'][$key], 'expiry' => $input['variation']['expiry'][$key], 'ins' => $product->ins);
                    }
                } else {
                    if (!empty($input['variation']['image'][$key])) {

                        $input['variation']['image'][$key] = $this->uploadFile($input['variation']['image'][$key]);
                    } else {
                        $input['variation']['image'][$key] = 'example.png';
                    }
                    $varriation_new[] = array('product_id' => $product->id, 'parent_id' => 1, 'variation_class' => 0, 'name' => strip_tags($input['variation']['variation_name'][$key]), 'warehouse_id' => $input['variation']['warehouse_id'][$key], 'code' => $input['variation']['code'][$key], 'price' => numberClean($input['variation']['price'][$key]), 'purchase_price' => numberClean($input['variation']['purchase_price'][$key]), 'disrate' => numberClean($input['variation']['disrate'][$key]), 'qty' => numberClean($input['variation']['qty'][$key]), 'alert' => numberClean($input['variation']['alert'][$key]), 'image' => $input['variation']['image'][$key], 'barcode' => $input['variation']['barcode'][$key], 'expiry' => $input['variation']['expiry'][$key], 'ins' => $product->ins);
                }
                $i++;
            }

            $update_variation = new ProductVariation;
            $index = 'id';
            Batch::update($update_variation, $variations, $index);
            if (isset($varriation_new[0])) {
                ProductVariation::insert($varriation_new);
            }
            if (isset($input['variation']['remove_v'])) {
                ProductVariation::whereIn('id', $input['variation']['remove_v'])->delete();
            }

            if (isset($input['serial']['product_serial'])) {
                $serial = array();
                foreach ($input['serial']['product_serial'] as $key => $value) {
                    $serial[] = array('rel_type' => 2, 'rel_id' => 0, 'ref_id' => $pv_i, 'value' => strip_tags($value));
                }
                ProductMeta::insert($serial);
            }

            if (is_array($input['custom_field'])) {
                $input['custom_field']['ins'] = $product->ins;
                update_custom_field($input['custom_field'], $product->id, 3);
            }

            if (isset($input['product_serial']['product_serial_e'])) {
                $update_serial = new ProductMeta();
                $index = 'id';
                $serials = array();
                foreach ($input['product_serial']['product_serial_e'] as $key => $value) {
                    $serials[] = array('id' => $key, 'value' => strip_tags($value));
                }
                Batch::update($update_serial, $serials, $index);
            }


            DB::commit();
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.products.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Product $product
     * @return bool
     * @throws GeneralException
     */
    public function delete(Product $product)
    {
        if ($product->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.products.delete_error'));
    }

    /*
* Upload logo image
*/
    public function uploadFile($file)
    {
        $path = $this->file_path;
        $file_name = time() . $file->getClientOriginalName();
        $rules = array('image' => 'required|mimes:png,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array('image' => $file), $rules);
        if ($validator->passes()) {
            $this->storage->put($path . $file_name, file_get_contents($file->getRealPath()));
             return $file_name;
        }
         return 'default.png';
    }

    /*
    * remove logo or favicon icon
    */
    public function removePicture(Product $file, $type)
    {
        $path = $this->file_path;

        if ($file->$type && $this->storage->exists($path . $file->$type)) {
            $this->storage->delete($path . $file->$type);
        }

        $result = $file->update([$type => null]);

        if ($result) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.settings.update_error'));
    }
}
