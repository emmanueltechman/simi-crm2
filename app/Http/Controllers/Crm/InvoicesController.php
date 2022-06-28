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
namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;


class InvoicesController extends Controller
{

    public function __construct()
    {

    }


    public function index()
    {

        $input['sub_json'] = "sub: 0";
        $input['sub_url'] = '';
        $input['title'] = trans('labels.backend.invoices.management');
        $input['meta'] = 'sub';
        $input['pre'] = 1;
        return view('crm.invoices.index', compact('input'));
    }


}
