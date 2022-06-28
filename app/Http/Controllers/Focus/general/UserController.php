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
namespace App\Http\Controllers\Focus\general;

use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;

use App\Models\Access\User\UserProfile;
use App\Models\Company\ConfigMeta;
use App\Notifications\Frontend\Auth\UserChangedPassword;
use Illuminate\Http\Request;
use App\Http\Responses\ViewResponse;
use App\Models\hrm\Attendance;
use App\Models\hrm\Hrm;
use App\Models\hrm\HrmMeta;
use App\Models\misc\Misc;
use App\Models\project\Project;
use App\Notifications\Rose;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Frontend\Auth;

class UserController extends Controller
{

    public function index()
    {
        return view('focus.user.attendance');
    }


    public function todo()
    {
        $mics = Misc::all();
        $employees = Hrm::all();
        $user = auth()->user()->id;
        $project_select = Project::whereHas('users', function ($q) use ($user) {
            return $q->where('rid', '=', $user);
        })->get();


        return new ViewResponse('focus.projects.tasks.index', compact('mics', 'employees', 'project_select'));
    }

    public function profile()
    {
        $hrm = Hrm::find(auth()->user()->id);
        return view('focus.user.profile', compact('hrm'));
    }

    public function edit_profile(Request $request)
    {
        if ($request->post()) {
            $hrm = Hrm::find(auth()->user()->id);
            $hrm->first_name = $request->first_name;
            $hrm->last_name = $request->last_name;


            if ($request->picture) {
                $hrm->picture = $this->attachment($request, 'picture');
            }
            if ($request->signature) {
                $hrm->signature = $this->attachment($request, 'signature');
            }
            $hrm->save();
            $profile = UserProfile::where('user_id', '=', $hrm->id)->first();
            $profile->contact = $request->contact;
            $profile->company = $request->company;
            $profile->address_1 = $request->address_1;
            $profile->city = $request->city;
            $profile->state = $request->state;
            $profile->country = $request->country;
            $profile->postal = $request->postal;
            $profile->tax_id = $request->tax_id;
            $profile->save();
            return new RedirectResponse(route('biller.profile'), ['flash_success' => trans('alerts.backend.users.updated')]);

        }
        $hrms = Hrm::find(auth()->user()->id);
        return view('focus.user.edit_profile', compact('hrms'));
    }


    function change_profile_password(Request $request)
    {
        $user = Hrm::find(auth()->user()->id);
        if ($request->post()) {
            if (Hash::check($request['old_password'], $user->password)) {
                $user->password = $request['password'];

                if ($user->save()) {
                    try {
                        auth()->user()->notify(new UserChangedPassword($request['password']));
                    } catch (\Exception $e){
  return new RedirectResponse(route('biller.profile'), ['flash_success' => trans('menus.backend.access.users.change-password').' (SMTP Not Configured)']);
                    }

                    return new RedirectResponse(route('biller.profile'), ['flash_success' => trans('menus.backend.access.users.change-password')]);
                }

            }
            return new RedirectResponse(route('biller.profile'), ['flash_error' => trans('exceptions.backend.access.users.update_password_error')]);
        } else {
            return view('focus.user.change-password');
        }
    }


    public function clock()
    {

        $attend = ConfigMeta::where('feature_id', '=', 18)->first('feature_value')->feature_value;
        if ($attend) {
            $hrm_data = HrmMeta::where('user_id', '=', auth()->user()->id)->first();
            $today = date('Y-m-d');
            if (!$hrm_data->clock) {
                $hrm_data->clock = 1;
                $hrm_data->clock_in = time();
                $hrm_data->clock_out = 0;
                $hrm_data->save();

                session(['clock' => true]);
                return back()->with(['flash_success' => trans('hrms.clocked_in')]);

            } else if ($hrm_data->clock) {
                $clock_in = $hrm_data->clock_in;
                $time_u = time();
                $hrm_data->clock = 0;
                $hrm_data->clock_in = 0;
                $hrm_data->clock_out = $time_u;
                $hrm_data->save();
                $total_time = $time_u - $clock_in;
                $attendance = Attendance::where('user_id', '=', auth()->user()->id)->where('present', '=', $today)->first();

                if (isset($attendance->id)) {

                    $attendance->actual_hours = $attendance->actual_hours + $total_time;
                    $attendance->t_to = date('H:i:s');
                    $attendance->save();
                } else {
                    $attendance = new Attendance;
                    $attendance->ins = auth()->user()->ins;
                    $attendance->user_id = auth()->user()->id;
                    $attendance->present = $today;
                    $attendance->t_from = gmdate("H:i:s", $clock_in);
                    $attendance->t_to = date('H:i:s');
                    $attendance->note = trans('hrms.self_attendance');
                    $attendance->actual_hours = $total_time;
                    $attendance->save();
                }

                session(['clock' => false]);
                return back()->with(['flash_success' => trans('hrms.clock_out')]);


            }

        }

        return back()->with(['flash_error' => trans('hrms.clocked_not_allowed')]);
    }

    public function attendance()
    {
        return view('focus.user.attendance');
    }

    public function load_attendance()
    {
        $attend = Attendance::where('user_id', '=', auth()->user()->id)->select(DB::raw("TRIM(CONCAT(t_from,' - ',t_to)) AS title, present as start"))->get();

        return $attend->toJson();

    }

    public function notifications(Request $request)
    {
        if ($request->ajax()) return view('focus.general.notifications.index');
        return view('focus.general.notifications.all');
    }

    public function read_notifications(Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->get('nid'))->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return auth()->user()->unreadNotifications->count();
    }

    private function attachment($request, $field = 'picture')
    {
        $path = 'img' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
        if ($field == 'picture') $itemName = $request->picture;
        if ($field == 'signature') {
            $itemName = $request->signature;
            $path = 'img' . DIRECTORY_SEPARATOR . 'signs' . DIRECTORY_SEPARATOR;
        }
        $request->validate([
            $field => 'required|mimes:jpeg,png',
        ]);


        $name = $itemName->getClientOriginalName();

        $file_name = strlen($name) > 20 ? substr($name, 0, 20) . '.' . $itemName->getClientOriginalExtension() : $name;


        $file_name = time() . $file_name;

        Storage::disk('public')->put($path . $file_name, file_get_contents($itemName->getRealPath()));


        return $file_name;


    }


}
