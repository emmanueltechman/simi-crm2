<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

namespace App\Http\Controllers\Focus\product;

use App\Http\Requests\Focus\product\TransferProductRequest;
use App\Models\Company\Company;
use App\Models\product\Product;
use App\Models\product\ProductMeta;
use App\Models\product\ProductVariation;
use App\Models\productcategory\Productcategory;
use App\Models\warehouse\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\product\CreateResponse;
use App\Http\Responses\Focus\product\EditResponse;
use App\Repositories\Focus\product\ProductRepository;
use App\Http\Requests\Focus\product\ManageProductRequest;
use App\Http\Requests\Focus\product\CreateProductRequest;
use App\Http\Requests\Focus\product\EditProductRequest;
use App\Http\Requests\Focus\product\DeleteProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use mPDF;

/**
 * ProductsController
 */
class ProductsController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProductRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProductRepository $repository ;
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\product\ManageProductRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageProductRequest $request)
    {
        $input = $request->only('rel_type', 'rel_id');
        $segment = false;
        if (isset($input['rel_id']) and isset($input['rel_type'])) {
            switch ($input['rel_type']) {
                case 2 :
                    $segment = Warehouse::find($input['rel_id']);
                    break;
                default :
                    $segment = Productcategory::find($input['rel_id']);
            }
        }
        return new ViewResponse('focus.products.index', compact('input', 'segment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateProductRequestNamespace $request
     * @return \App\Http\Responses\Focus\product\CreateResponse
     */
    public function create(CreateProductRequest $request)
    {
        return new CreateResponse('focus.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateProductRequest $request)
    {

        //Input received from the request
        $input['main'] = $request->only(['name', 'taxrate', 'product_des', 'productcategory_id', 'sub_cat_id', 'unit', 'code_type', 'stock_type']);
        $input['custom_field'] = $request->only(['custom_field']);
        $input['serial'] = $request->only(['product_serial']);
        $input['variation'] = $request->only(['v_id', 'price', 'purchase_price', 'qty', 'code', 'barcode', 'disrate', 'alert', 'expiry', 'warehouse_id', 'variation_name', 'image']);
        $input['main']['ins'] = auth()->user()->ins;
        $input['custom_field']['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $id = $this->repository->create($input);

        //return with successfull message
        return new RedirectResponse(route('biller.products.show', [$id]), ['flash_success' => trans('alerts.backend.products.created') . ' <a href="' . route('biller.products.show', [$id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.products.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.products.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\product\Product $product
     * @param EditProductRequestNamespace $request
     * @return \App\Http\Responses\Focus\product\EditResponse
     */
    public function edit(Product $product, EditProductRequest $request)
    {
        return new EditResponse($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequestNamespace $request
     * @param App\Models\product\Product $product
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditProductRequest $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);
        $input['main'] = $request->only(['name', 'taxrate', 'product_des', 'productcategory_id', 'sub_cat_id', 'unit', 'code_type', 'stock_type', 'pv_id']);
        $input['variation'] = $request->only(['v_id', 'price', 'purchase_price', 'qty', 'code', 'barcode', 'disrate', 'alert', 'expiry', 'warehouse_id', 'variation_name', 'image', 'remove_v']);
        $input['custom_field'] = $request->only(['custom_field']);
        $input['product_serial'] = $request->only(['product_serial_e']);
        $input['serial'] = $request->only(['product_serial']);
        //Input received from the request
        //  $input = $request->except(['_token','ins']);
        //Update the model using repository update method
        $this->repository->update($product, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.products.show', [$product->id]), ['flash_success' => trans('alerts.backend.products.created') . ' <a href="' . route('biller.products.show', [$product->id]) . '" class="ml-5 btn btn-outline-light round btn-min-width bg-blue"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;' . ' <a href="' . route('biller.products.create') . '" class="btn btn-outline-light round btn-min-width bg-purple"><span class="fa fa-plus-circle" aria-hidden="true"></span> ' . trans('general.create') . '  </a>&nbsp; &nbsp;' . ' <a href="' . route('biller.products.index') . '" class="btn btn-outline-blue round btn-min-width bg-amber"><span class="fa fa-list blue" aria-hidden="true"></span> <span class="blue">' . trans('general.list') . '</span> </a>']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProductRequestNamespace $request
     * @param App\Models\product\Product $product
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Product $product, DeleteProductRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($product);
        //returning with successfull message
        return json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.products.deleted')));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProductRequestNamespace $request
     * @param App\Models\product\Product $product
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Product $product, ManageProductRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.products.view', compact('product'));
    }

    public function product_label(ManageProductRequest $style)
    {

        if (isset($style->items_per_row) AND isset($style->products_l)) {

            $product = ProductVariation::whereIn('id', $style->products_l)->get();

            $products = array();
            foreach ($product as $row) {
                $products[] = array('name' => $row->product['name'] . ' ' . $row['name'] . '', 'price' => $row['price'], 'unit' => $row['unit'], 'code' => $row['code'], 'warehouse' => $row->warehouse['title'], 'barcode' => $row['barcode'], 'expiry' => $row['expiry ']);


            }

            if (count($products) > 0)
                $company = Company::where('id', '=', auth()->user()->ins)->first();
            $style['store'] = $company['cname'];
            $html = view('focus.products.label_print', compact('style', 'products'))->render();

            try {
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                if ($style->pdf == 2) {
                    return $pdf->Output('products_label_print.pdf', 'D');
                } else {
                      $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                );
                return Response::stream($pdf->Output('products_label_print.pdf', 'I'), 200, $headers);
                }
            } catch (\Exception $e) {
                return new RedirectResponse(route('biller.products.product_label'), ['flash_error' => $e->getMessage()]);
            }

        }


        $warehouses = Warehouse::all();
        return view('focus.products.label', compact('warehouses'));
    }

    public function stock_transfer(TransferProductRequest $request)
    {

        if ($request->from_warehouse and $request->to_warehouse and $request->products_l and $request->from_warehouse != $request->to_warehouse) {
            $input = $request->only('from_warehouse', 'to_warehouse', 'products_l', 'qty', 'merger');
            $i = 0;
            $qtyArray = explode(',', $input['qty']);
            $sort = implode(',', $qtyArray);
            $products = ProductVariation::whereIn('id', $input['products_l'])->orderByRaw(DB::raw("FIELD(id, $sort)"))->get();
            $stock_log = array();
            foreach ($products as $row) {
                $check_product_list = ProductVariation::where('product_id', '=', $row['product_id'])->where('warehouse_id', '=', $input['to_warehouse']);
                if (!isset($qtyArray[$i])) $qtyArray[$i] = $row->qty;
                $check_product_list->when(request('merger'), function ($q) {
                    switch (request('merger')) {
                        case 1 :
                            return $q->where('code', '=', request('merger'))->whereNotNull('code');
                            break;
                        case 2 :
                            return $q->whereNull('code');
                            break;
                    }
                });
                $check_product = $check_product_list->first();
                if (isset($check_product['id'])) {
                    $check_product->qty = $check_product->qty + $qtyArray[$i];
                    $check_product->save();
                } else {
                    $new_item = $row->toArray();
                    $new_item['warehouse_id'] = $input['to_warehouse'];
                    $new_item['qty'] = $qtyArray[$i];
                    if (!$new_item['parent_id']) $new_item['parent_id'] = $new_item['id'];
                    $new_product = ProductVariation::create($new_item);
                    $row->qty = $row->qty - $qtyArray[$i];
                    $row->save();
                }
                $stock_log[] = array('rel_type' => 1, 'rel_id' => $row['id'], 'ref_id' => $row['warehouse_id'], 'value' => $qtyArray[$i], 'value2' => $input['to_warehouse']);
                $i++;

            }
            ProductMeta::insert($stock_log);
            return new RedirectResponse(route('biller.products.stock_transfer'), ['flash_success' => trans('products.stock_transfer_success')]);
        } else if ($request->from_warehouse or $request->to_warehouse or $request->products_l or $request->from_warehouse != $request->to_warehouse) {
            return new RedirectResponse(route('biller.products.stock_transfer'), ['flash_error' => trans('products.stock_transfer_error')]);
        }

        $warehouses = Warehouse::all();
        return view('focus.products.stock_transfer', compact('warehouses'));
    }

    function standard(ManageProductRequest $style)
    {

        if ($style->standard_sheet) {
            $style['border'] = $style->label_border;
            $product = ProductVariation::where('id', $style->products_l)->first();
            $company = Company::where('id', '=', auth()->user()->ins)->first();
            $style['store'] = $company['cname'];

            switch ($style->standard_sheet) {
                case 'lp65':
                    if ($style['bar_height'] > 0.5) {
                        $style['bar_height'] = 0.5;
                        if ($style['product_code'] and $style['product_price']) $style['bar_height'] = 0.4;
                        if ($style['product_code'] and !$style['product_price']) $style['bar_height'] = 0.5;
                        if (!$style['product_code'] and $style['product_price']) $style['bar_height'] = 0.5;
                    }

                    $html = view('focus.products.sheets.sheet_65', compact('style', 'products'))->render();
                    break;


                case 'lp24':
                    if ($style['bar_height'] > 0.5) {
                        $style['bar_height'] = 0.5;
                        if ($style['product_code'] and $style['product_price']) $style['bar_height'] = 0.4;
                        if ($style['product_code'] and !$style['product_price']) $style['bar_height'] = 0.5;
                        if (!$style['product_code'] and $style['product_price']) $style['bar_height'] = 0.5;
                    }

                    $html = view('focus.products.sheets.LP24_134', compact('style', 'products'))->render();
                    break;


            }
            try {
                $pdf = new \Mpdf\Mpdf(config('pdf'));
                $pdf->WriteHTML($html);
                if ($style->pdf == 2) {
                    return $pdf->Output('products_label_print.pdf', 'D');
                } else {
                       $headers = array(
                        "Content-type" => "application/pdf",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0"
                );
                return Response::stream($pdf->Output('products_label_print.pdf', 'I'), 200, $headers);
                }
            } catch (\Exception $e) {
                return new RedirectResponse(route('biller.products.product_label'), ['flash_error' => $e->getMessage()]);
            }
        }
        $warehouses = Warehouse::all();
        return view('focus.products.fixed_label', compact('warehouses'));

    }


    public function product_search(Request $request, $bill_type)
    {

        if (!access()->allow('product_search')) return false;
        $q = $request->post('keyword');
        $w = $request->post('wid');
        $s = $request->post('serial_mode');
        //if ($bill_type == 'label') $q = @$q['term'];
        $wq = compact('q', 'w');
        if ($s == 1) {
            $product = \App\Models\product\ProductMeta::where('value', 'LIKE', '%' . $q . '%')->whereNull('value2')->whereHas('product_serial', function ($query) use ($wq) {
                if ($wq['w'] > 0) return $query->where('warehouse_id', $wq['w']);
            })->with(['product_standard'])->limit(6)->get();
            $output = array();

            foreach ($product as $row) {
                    if($bill_type=='purchase') $row->product_serial['price']=$row->product_serial['purchase_price'];
                $output[] = array('name' => $row->product_serial->product['name'], 'disrate' => $row->product_serial['disrate'], 'price' => $row->product_serial['price'], 'id' => $row->product_serial['id'], 'taxrate' => $row->product_serial->product['taxrate'], 'product_des' => $row->product_serial->product['product_des'], 'unit' => $row->product_serial->product['unit'], 'code' => $row->product_serial['code'], 'alert' => $row->product_serial['qty'], 'serial' => $row->value);


            }
        } else {

            if ($bill_type == 'label') $q = @$q['term'];

            $wq = compact('q', 'w');

            $product = ProductVariation::whereHas('product', function ($query) use ($wq) {

                $query->where('name', 'LIKE', '%' . $wq['q'] . '%');
                return $query;
            })->when($wq['w'] > 0, function ($q) use ($wq) {
                $q->where('warehouse_id', $wq['w']);
            })->limit(6)->get();
            $output = array();

            foreach ($product as $row) {

                if($bill_type=='purchase') { $row->price=$row->purchase_price; $row->qty=5000; }
                if (($row->product->stock_type > 0 and $row->qty > 0) or !$row->product->stock_type) {
                    $output[] = array('name' => $row->product->name . ' ' . $row['name'], 'disrate' => numberFormat($row->disrate), 'price' => numberFormat($row->price), 'id' => $row->id, 'taxrate' => numberFormat($row->product['taxrate']), 'product_des' => $row->product['product_des'], 'unit' => $row->product['unit'], 'code' => $row->code, 'alert' => $row->qty, 'image' => $row->image, 'serial' => '');
                }
            }

        }

        if (count($output) > 0)

            return view('focus.products.partials.search')->withDetails($output);
    }

    public function product_sub_load(Request $request)
    {
        $q = $request->get('id');
        $result = \App\Models\productcategory\Productcategory::all()->where('c_type', '=', 1)->where('rel_id', '=', $q);

        return json_encode($result);
    }

    public function pos(Request $request, $bill_type)
    {
        if (!access()->allow('pos')) return false;
        $q = $request->post('keyword');
        $w = $request->wid;
        $cat_id = $request->post('cat_id');
        $s = $request->post('serial_mode');
        $limit = $request->post('search_limit', 20);
        $bill_type=$request->bill_type;
        if ($bill_type == 'label'){
            $q = @$request->post('product')['term'];

        }

        $wq = compact('q', 'w', 'cat_id');
        if ($s == 1 and $q) {
            $product = \App\Models\product\ProductMeta::where('value', 'LIKE', '%' . $q . '%')->whereNull('value2')->whereHas('product_serial', function ($query) use ($wq) {
                if ($wq['w'] > 0) return $query->where('warehouse_id', $wq['w']);
            })->with(['product_standard'])->limit($limit)->get();
            $output = array();

            foreach ($product as $row) {

                $output[] = array('name' => $row->product_serial->product['name'], 'disrate' => $row->product_serial['disrate'], 'price' => $row->product_serial['price'], 'id' => $row->product_serial['id'], 'taxrate' => $row->product_serial->product['taxrate'], 'product_des' => $row->product_serial->product['product_des'], 'unit' => $row->product_serial->product['unit'], 'code' => $row->product_serial['code'], 'alert' => $row->product_serial['qty'], 'image' => $row->product_serial['image'], 'serial' => $row->value);


            }
        } else {

            $product = ProductVariation::whereHas('product', function ($query) use ($wq) {
                $query->where('name', 'LIKE', '%' . $wq['q'] . '%');
                if ($wq['cat_id'] > 0) $query->where('productcategory_id', $wq['cat_id']);
                return $query;
            })->when($wq['w'] > 0, function ($q) use ($wq) {
                $q->where('warehouse_id', $wq['w']);
            })->limit($limit)->get();
            $output = array();

            foreach ($product as $row) {
                if (($row->product->stock_type > 0 and $row->qty > 0) or !$row->product->stock_type) {
                    $output[] = array('name' => $row->product->name . ' ' . $row['name'], 'disrate' => numberFormat($row->disrate), 'price' => numberFormat($row->price), 'id' => $row->id, 'taxrate' => numberFormat($row->product['taxrate']), 'product_des' => $row->product['product_des'], 'unit' => $row->product['unit'], 'code' => $row->code, 'alert' => $row->qty, 'image' => $row->image, 'serial' => '');
                }
            }

        }

        if (count($output) > 0)

            return view('focus.products.partials.pos')->withDetails($output);
    }


}
