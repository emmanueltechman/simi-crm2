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

use App\Http\Responses\RedirectResponse;
use App\Models\customer\Customer;
use App\Models\transaction\TransactionHistory;
use App\Repositories\Focus\customer\CustomerPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerHome extends Controller
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

    public function __construct()
    {
        $this->customer_picture_path = 'img' . DIRECTORY_SEPARATOR . 'customer' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }


    public function index()
    {

    }

    public function profile()
    {
        $user = auth('crm')->user();
        return view('crm.user.edit_profile', compact('user'));
    }

    public function update_profile(Request $request)
    {

        $user = auth('crm')->user();

        $user = Customer::withoutGlobalScopes()->find($user->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->company = $request->company;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->region = $request->region;
        $user->country = $request->country;
        $user->postbox = $request->postbox;
        $user->taxid = $request->taxid;
        $user->name_s = $request->name_s;
        $user->phone_s = $request->phone_s;
        $user->email_s = $request->email_s;
        $user->address_s = $request->address_s;
        $user->city_s = $request->city_s;
        $user->region_s = $request->region_s;
        $user->country_s = $request->country_s;
        $user->city_s = $request->city_s;
        $user->postbox_s = $request->postbox_s;

        if ($request->current_password) {
            $request->validate([
                'current_password' => ['required', new CustomerPassword],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            $user->password = $request->new_password;
        }

        if (!empty($request->picture)) {
            if ($this->storage->exists($this->customer_picture_path . $user->picture)) {
                $this->storage->delete($this->customer_picture_path . $user->picture);
            }
            $user->picture = $this->uploadPicture($request->picture);

        }
        $user->save();

        return new RedirectResponse(route('crm.user.update'), ['flash_success' => trans('alerts.backend.users.updated')]);


    }

    private function uploadPicture($logo)
    {
        $path = $this->customer_picture_path;

        $image_name = time() . $logo->getClientOriginalName();

        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));


        return $image_name;
    }

    public function wallet()
    {
        $user = auth('crm')->user();
        $wallet_transactions = TransactionHistory::withoutGlobalScopes()->where(['relation_id' => 11, 'party_id' => $user->id])->get();
        return view('crm.user.wallet', compact('user', 'wallet_transactions'));
    }


}
