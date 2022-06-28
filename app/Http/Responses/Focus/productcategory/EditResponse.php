<?php

namespace App\Http\Responses\Focus\productcategory;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\productcategory\Productcategory
     */
    protected $productcategories;

    /**
     * @param App\Models\productcategory\Productcategory $productcategories
     */
    public function __construct($productcategories)
    {
        $this->productcategories = $productcategories;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
          $product_category=$this->productcategories::all()->where('c_type','=',0);
        return view('focus.productcategories.edit')->with([
            'productcategories' => $this->productcategories,'product_category'=>$product_category
        ]);
    }
}