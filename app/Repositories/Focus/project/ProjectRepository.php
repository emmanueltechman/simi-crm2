<?php

namespace App\Repositories\Focus\project;

use App\Models\Access\User\User;
use App\Models\event\Event;
use App\Models\event\EventRelation;
use App\Models\project\ProjectLog;
use App\Models\project\ProjectRelations;
use App\Notifications\Rose;
use DB;
use Carbon\Carbon;
use App\Models\project\Project;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectRepository.
 */
class ProjectRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Project::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable($c = true)
    {

        $q = $this->query()->withoutGlobalScopes();
        if ($c) {
            $q->whereHas('creator', function ($s) {
                return $s->where('rid', '=', auth()->user()->id);
            });
            $q->orWhereHas('users', function ($s) {
                return $s->where('rid', '=', auth()->user()->id);
            });
        } else {
            $q->where('project_share','=',4);
             $q->orWhere('project_share','=',6);
            $q->whereHas('customer', function ($s) {
                return $s->where('rid', '=', auth('crm')->user()->id);
            });
        }
        return $q->get(['id', 'name', 'status', 'priority', 'progress', 'end_date']);
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
        $employees = @$input['employees'];
        $tags = @$input['tags'];
        $calender = @$input['link_to_calender'];
        $color = @$input['color'];
        $customer = @$input['customer'];

        unset($input['tags']);
        unset($input['employees']);
         unset($input['customer']);
        unset($input['link_to_calender']);
        unset($input['color']);
        $user_id = auth()->user()->id;

        $input['start_date'] = datetime_for_database($input['start_date'] . ' ' . $input['time_from']);
        $input['end_date'] = datetime_for_database($input['end_date'] . ' ' . $input['time_to']);
        unset($input['time_from']);
        unset($input['time_to']);
        $input = array_map( 'strip_tags', $input);
        $result = Project::create($input);

        if ($result) {
            $tag_group = array();
            if (is_array($tags)) {
                foreach ($tags as $row) {
                    $tag_group[] = array('project_id' => $result->id, 'related' => 1, 'rid' => $row);
                }
            }

            if (is_array($employees)) {
                $emp_group = array();
                foreach ($employees as $row) {
                    $tag_group[] = array('project_id' => $result->id, 'related' => 2, 'rid' => $row);
                    $emp_group[] = $row;
                }
            }
            if ($customer > 0) {
                $tag_group[] = array('project_id' => $result->id, 'related' => 8, 'rid' => $customer);
            }
            $tag_group[] = array('project_id' => $result->id, 'related' => 3, 'rid' => $user_id);
            ProjectRelations::insert($tag_group);
            ProjectLog::create(array('project_id' => $result->id, 'value' => '[' . trans('general.create') . '] ' . $result->name, 'user_id' => $user_id));
            if ($calender) {
                $event = Event::create(array('title' => trans('projects.project') . ' - ' . $input['name'], 'description' => $input['short_desc'], 'start' => $input['start_date'], 'end' => $input['end_date'], 'color' => $color, 'user_id' => $user_id, 'ins' => $input['ins']));
                EventRelation::create(array('event_id' => $event->id, 'related' => 1, 'r_id' => $result->id));
            }
            $message = array('title' => trans('projects.project') . ' - ' . $result->name, 'icon' => 'fa-bullhorn', 'background' => 'bg-success', 'data' => $input['short_desc']);

            if (is_array(@$emp_group)) {
                $users = User::whereIn('id', $emp_group)->get();
                \Illuminate\Support\Facades\Notification::send($users, new Rose('', $message));
            } else {
                $notification = new Rose(auth()->user(), $message);
                auth()->user()->notify($notification);
            }
            return $result;
        }

        throw new GeneralException(trans('exceptions.backend.projects.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Project $project
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Project $project, array $input)
    {
        $employees = @$input['employees'];
        $tags = @$input['tags'];
        $calender = @$input['link_to_calender'];
        $color = @$input['color'];
        $customer = @$input['customer'];

        unset($input['tags']);
        unset($input['employees']);
        unset($input['link_to_calender']);
        unset($input['color']);
           unset($input['customer']);
        $user_id = auth()->user()->id;

        $input['start_date'] = datetime_for_database($input['start_date'] . ' ' . $input['time_from']);
        $input['end_date'] = datetime_for_database($input['end_date'] . ' ' . $input['time_to']);
        unset($input['time_from']);
        unset($input['time_to']);
        $input = array_map( 'strip_tags', $input);
        $result = $project->update($input);


        if ($result) {
            ProjectRelations::where(['related' => 1, 'project_id' => $project->id])->delete();
            ProjectRelations::where(['related' => 2, 'project_id' => $project->id])->delete();
            ProjectRelations::where(['related' => 3, 'project_id' => $project->id])->delete();
            $er = EventRelation::where(['related' => 1, 'r_id' => $project->id])->first();
            if ($er) {
                $er->event->delete();
                $er->delete();
            }
            $tag_group = array();
            if (is_array($tags)) {
                foreach ($tags as $row) {
                    $tag_group[] = array('project_id' => $project->id, 'related' => 1, 'rid' => $row);
                }
            }

            if (is_array($employees)) {
                foreach ($employees as $row) {
                    $tag_group[] = array('project_id' => $project->id, 'related' => 2, 'rid' => $row);
                }
            }
               if ($customer > 0) {
                $tag_group[] = array('project_id' => $project->id, 'related' => 8, 'rid' => $customer);
            }
            $tag_group[] = array('project_id' => $project->id, 'related' => 3, 'rid' => $user_id);
            ProjectRelations::insert($tag_group);
            ProjectLog::create(array('project_id' => $project->id, 'value' => '[' . trans('general.create') . '] ' . $project->name, 'user_id' => $user_id));
            if ($calender) {
                $event = Event::create(array('title' => trans('projects.project') . ' - ' . $input['name'], 'description' => $input['short_desc'], 'start' => $input['start_date'], 'end' => $input['end_date'], 'color' => $color, 'user_id' => $user_id, 'ins' => $project->ins));
                EventRelation::create(array('event_id' => $event->id, 'related' => 1, 'r_id' => $project->id));
            }
            return $result;
        }


        throw new GeneralException(trans('exceptions.backend.projects.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Project $project
     * @return bool
     * @throws GeneralException
     */
    public function delete(Project $project)
    {
        if ($project->creator->id == auth()->user()->id) {
            if ($project->delete()) {
                $er = EventRelation::where(['related' => 1, 'r_id' => $project->id])->first();
                if ($er) {
                    $er->event->delete();
                    $er->delete();
                }
                return true;
            }
        }

        throw new GeneralException(trans('exceptions.backend.projects.delete_error'));
    }
}
