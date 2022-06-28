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
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class ProductRepository.
 */
class ProductVariationRepository extends BaseRepository
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
    const MODEL = ProductVariation::class;

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

    }

    public function getForDataTable()
    {
            $q = ProductVariation::with(['product']);
            $q->when(request('p_rel_id') AND (request('p_rel_type') == 2), function ($q) {
                return $q->where('warehouse_id', '=', request('p_rel_id', 0));
            });
            return $q->get();

    }


}
