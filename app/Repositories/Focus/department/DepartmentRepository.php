<?php

namespace App\Repositories\Focus\department;

use DB;
use Carbon\Carbon;
use App\Models\department\Department;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DepartmentRepository.
 */
class DepartmentRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Department::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','name','created_at']);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        $input = array_map( 'strip_tags', $input);
        if (Department::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.departments.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Department $department
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Department $department, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($department->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.departments.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Department $department
     * @throws GeneralException
     * @return bool
     */
    public function delete(Department $department)
    {
        if ($department->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.departments.delete_error'));
    }
}
