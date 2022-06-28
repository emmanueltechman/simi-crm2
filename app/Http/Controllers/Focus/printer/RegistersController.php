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
namespace App\Http\Controllers\Focus\printer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\invoice\ManagePosRequest;
use App\Models\items\Register;
use App\Http\Responses\RedirectResponse;

/**
 * RegisterController
 */
class RegistersController extends Controller
{

    public function __construct()
    {

        $this->printer_connection = '';

    }

    public function status()
    {
        $item = Register::where('user_id', '=', auth()->user()->id)->whereNull('closed_at')->first();
        if ($item) return $item;
        return false;
    }


    public function open(ManagePosRequest $request)
    {
        $item = Register::orderBy('id', 'desc')->where('user_id', '=', auth()->user()->id)->whereNull('closed_at')->first();
        if (!$item) {
            $input = $request->post('pm', 0);
            $input['Change'] = 0;
            $data = json_encode($input);
            Register::create(array('ins' => auth()->user()->ins, 'user_id' => auth()->user()->id, 'data' => $data));
            return new RedirectResponse(route('biller.invoices.pos'), ['']);
        } else {
            $item->closed_at = date('Y-m-d H:i:s');
        }

    }

    public function close(ManagePosRequest $request)
    {
        $item = Register::orderBy('id', 'desc')->where('user_id', '=', auth()->user()->id)->whereNull('closed_at')->first();
        if ($item) {
            $item->closed_at = date('Y-m-d H:i:s');
        }
        $item->save();
        return new RedirectResponse(route('biller.index'), ['']);

    }

    public function load(ManagePosRequest $request)
    {
        $draw = array();
        $data = Register::orderBy('id', 'desc')->where('user_id', '=', auth()->user()->id)->whereNull('closed_at')->first();
        $items = json_decode($data->data);
        $i = 1;
        $draw['open'] = dateTimeFormat($data->created_at);
        foreach ($items as $row) {
            if ($row) $draw['pm_' . $i] = numberFormat($row); else $draw['pm_' . $i] = 0;
            $i++;
        }
        return json_encode($draw);
    }

}
