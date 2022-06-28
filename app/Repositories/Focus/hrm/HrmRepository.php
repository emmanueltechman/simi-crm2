<?php

namespace App\Repositories\Focus\hrm;

use App\Models\Access\Permission\Permission;
use App\Models\Access\Permission\PermissionUser;
use App\Models\Access\Role\Role;
use App\Models\Access\User\UserProfile;
use App\Models\employee\RoleUser;
use App\Models\hrm\HrmMeta;
use DB;
use Carbon\Carbon;
use App\Models\hrm\Hrm;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class HrmRepository.
 */
class HrmRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Hrm::class;
    protected $file_picture_path;
    protected $file_sign_path;
    protected $storage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->file_picture_path = 'img' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
        $this->file_sign_path = 'img' . DIRECTORY_SEPARATOR . 'signs' . DIRECTORY_SEPARATOR;
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
        $q = $this->query();
        if (request('rel_type') == 2 AND request('rel_id')) {
            $q->whereHas('meta', function ($s) {
                return $s->where('department_id', '=', request('rel_id', 0));
            });
        }
        return $q->get(['id','email','picture','first_name','last_name','status','created_at']);
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

        if (!empty($input['employee']['picture'])) {
            $input['employee']['picture'] = $this->uploadPicture($input['employee']['picture'], $this->file_picture_path);
        }
        if (!empty($input['employee']['signature'])) {
            $input['employee']['signature'] = $this->uploadPicture($input['employee']['signature'], $this->file_sign_path);
        }
        DB::beginTransaction();
        $role = $input['employee']['role'];
        $role_valid = Role::where(function ($query) {
            $query->where('ins', '=', auth()->user()->ins)->orWhereNull('ins');
        })->where('id', '=', $role)->first();
        if ($role_valid->status < 1) {
            unset($input['employee']['role']);
            $input['employee']['created_by'] = auth()->user()->id;
            $input['employee']['confirmed'] = 1;
             $input['profile'] = array_map( 'strip_tags', $input['profile']);
              $input['meta'] = array_map( 'strip_tags', $input['meta']);
              $input['employee'] = array_map( 'strip_tags', $input['employee']);
            $hrm = Hrm::create($input['employee']);

            $input['profile']['user_id'] = $hrm->id;
            $input['meta']['user_id'] = $hrm->id;

            UserProfile::create($input['profile']);
            HrmMeta::create($input['meta']);
            RoleUser::create(array('user_id' => $hrm->id, 'role_id' => $role));

            if (isset($input['permission']['permission'])) $hrm->permissions()->attach($input['permission']['permission']);

            DB::commit();
            if ($hrm->id) {
                return $hrm->id;
            }
        }
        throw new GeneralException(trans('exceptions.backend.hrms.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Hrm $hrm
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Hrm $hrm, array $input)
    {
        if (!empty($input['employee']['picture'])) {
            if ($this->storage->exists($this->file_picture_path . $hrm->picture)) {
                $this->storage->delete($this->file_picture_path . $hrm->picture);
            }
            $input['employee']['picture'] = $this->uploadPicture($input['employee']['picture'], $this->file_picture_path);
        }
        if (!empty($input['employee']['signature'])) {
            if ($this->storage->exists($this->file_sign_path . $hrm->signature)) {
                $this->storage->delete($this->file_sign_path . $hrm->signature);
            }
            $input['employee']['signature'] = $this->uploadPicture($input['employee']['signature'], $this->file_sign_path);
        }
        if (empty($input['employee']['password'])) {
            unset($input['employee']['password']);
        }


        $role = $input['employee']['role'];
        $role_valid = Role::where(function ($query) {
            $query->where('ins', '=', auth()->user()->ins)->orWhereNull('ins');
        })->where('id', '=', $role)->first();
        if (@$role_valid->status < 1) {
            DB::beginTransaction();
             $input['profile'] = array_map( 'strip_tags', $input['profile']);
            $user = UserProfile::where('user_id', $hrm->id)->update($input['profile']);
            $role = $input['employee']['role'];
            unset($input['employee']['role']);
            RoleUser::where('user_id', $hrm->id)->update(array('role_id' => $role));

              $input['meta'] = array_map( 'strip_tags', $input['meta']);

            HrmMeta::where('user_id', $hrm->id)->update($input['meta']);

            //$hrm->permissions()->delete(['user_id'=>$hrm->id]);
            PermissionUser::where('user_id', $hrm->id)->delete();
                   $input['employee'] = array_map( 'strip_tags', $input['employee']);
            if ($hrm->update($input['employee'])) DB::commit();
            if (isset($input['permission']['permission'])) {
                $hrm->permissions()->attach($input['permission']['permission']);
            }
            return true;
        }


        throw new GeneralException(trans('exceptions.backend.hrms.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Hrm $hrm
     * @return bool
     * @throws GeneralException
     */
    public function delete(Hrm $hrm)
    {
        UserProfile::where('user_id', $hrm->id)->delete();
        if ($hrm->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.hrms.delete_error'));
    }

    /*
* Upload logo image
*/
    public function uploadPicture($logo, $path)
    {

        $image_name = time() . $logo->getClientOriginalName();

        $this->storage->put($path . $image_name, file_get_contents($logo->getRealPath()));

        return $image_name;
    }
}
