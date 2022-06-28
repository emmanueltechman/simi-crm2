<?php

namespace App\Http\Responses\Focus\productcategory;

use App\Models\productcategory\Productcategory;
use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
          $product_category=Productcategory::all()->where('c_type','=',0);
        return view('focus.productcategories.create',compact('product_category'));
    }
}