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

use App\Models\Company\ConfigMeta;
use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\note\Note;
use App\Models\project\Project;
use App\Models\project\ProjectLog;
use App\Models\project\ProjectMileStone;
use App\Models\project\ProjectRelations;
use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use App\Repositories\Focus\project\ProjectRepository;
use App\Http\Requests\Focus\project\ManageProjectRequest;
use App\Repositories\Focus\project\TaskRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

/**
 * ProjectsController
 */
class ProjectsController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProjectRepository $repository ;
     */
    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\project\ManageProjectRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(Request $request)
    {
        $mics = Misc::withoutGlobalScopes()->get();
        $employees = Hrm::withoutGlobalScopes()->get();
        return new ViewResponse('crm.projects.index', compact('mics', 'employees'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProjectRequestNamespace $request
     * @param App\Models\project\Project $project
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Request $request)
    {

        if (project_client($request->id)) {
            $project = Project::withoutGlobalScopes()->find($request->id);

            $employees = Hrm::withoutGlobalScopes()->where('ins', '=', $project->ins)->get();
            $mics = Misc::withoutGlobalScopes()->where('ins', '=', $project->ins)->get();

            $features = ConfigMeta::withoutGlobalScopes()->where('ins', '=', $project->ins)->where('feature_id', 9)->first();

            return new ViewResponse('crm.projects.view', compact('project', 'employees', 'mics', 'features'));
        } else    return view('crm.projects.not_applicable');
    }

    public function store_meta(ManageProjectRequest $request)
    {

        $input = $request->except(['_token', 'ins']);
        if (!project_access($input['project_id'])) exit;
        switch ($input['obj_type']) {
            case 2 :
                $milestone = ProjectMileStone::create(array('project_id' => $input['project_id'], 'name' => $input['name'], 'note' => $input['description'], 'color' => $input['color'], 'due_date' => date_for_database($input['duedate']) . ' ' . $input['time_to'] . ':00', 'user_id' => auth()->user()->id));
                $result = '<li class=" " id="m_' . $milestone->id . '">
                                    <div class="timeline-badge" style="background-color: ' . $milestone->color . ' ;">*</div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">' . $milestone->name . '</h4>
                                            <p>
                                                <small class="text-muted"> [ ' . trans('general.due_date') . ' ' . dateTimeFormat($milestone->due_date) . ']
                                                </small>

                                            </p>
                                        </div>';

                $result .= '<div class="timeline-body mb-1">
                                            <p> ' . $milestone->note . '</p><a href="#" class=" delete-object" data-object-type="2" data-object-id="' . $milestone->id . '"><i class="danger fa fa-trash"></i></a>
                                        </div>';

                $result .= '<small class="text-muted"><i class="fa fa-user"></i> <strong>' . $milestone->creator->first_name . ' ' . $milestone->creator->last_name . '</strong>  <i class="fa fa-clock-o"></i>  ' . trans('general.created') . '  ' . dateTimeFormat($milestone->created_at) . '
                                                </small>
                                    </div>
                                </li>';
                ProjectLog::create(array('project_id' => $milestone->project_id, 'value' => '[' . trans('projects.milestone') . '] ' . '[' . trans('general.new') . '] ' . $input['name'], 'user_id' => auth()->user()->id));
                return json_encode(array('status' => 'Success', 'message' => trans('general.success'), 't_type' => 2, 'meta' => $result));
                break;
            case 5 :

                $p_log = ProjectLog::create(array('project_id' => $request->project_id, 'value' => $request->name, 'user_id' => auth()->user()->id));

                $log_text = '<tr><td>*</td><td>' . dateTimeFormat($p_log->created_at) . '</td><td>' . auth()->user()->first_name . '</td><td>' . $p_log->value . '</td></tr>';

                return json_encode(array('status' => 'Success', 'message' => trans('general.success'), 't_type' => 5, 'meta' => $log_text));
                break;

            case 6:

                $note = Note::create(array('title' => $input['title'], 'content' => $input['content'], 'user_id' => auth()->user()->id, 'section' => 1, 'ins' => auth()->user()->ins));
                $p_group = array('project_id' => $request->project_id, 'related' => 6, 'rid' => $note->id);
                ProjectRelations::create($p_group);
                ProjectLog::create(array('project_id' => $request->project_id, 'value' => '[' . trans('projects.milestone') . '] ' . $request->title, 'user_id' => auth()->user()->id));
                $log_text = '<tr><td>*</td><td>' . $note->title . '</td><td>' . dateTimeFormat($note->created_at) . '</td><td>' . auth()->user()->first_name . '</td><td><a href="' . route('biller.notes.show', [$note->id]) . '" class="btn btn-primary round" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a><a href="' . route('biller.notes.edit', [$note->id]) . '" class="btn btn-warning round" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil "></i> </a> <a class="btn btn-danger round" table-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" data-toggle="tooltip" data-placement="top" title="Delete" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();"><i class="fa fa-trash"></i> <form action="' . route('biller.notes.show', [$note->id]) . '" method="POST" name="delete_table_item" style="display:none"></form></a></td></tr>';
                return json_encode(array('status' => 'Success', 'message' => trans('general.success'), 't_type' => 6, 'meta' => $log_text));

                break;
        }


    }

    public function delete_meta(ManageProjectRequest $request)
    {
        $input = $request->except(['_token', 'ins']);
        switch ($input['obj_type']) {
            case 2 :
                $milestone = ProjectMileStone::find($input['object_id']);
                ProjectLog::create(array('project_id' => $milestone->project_id, 'value' => '[' . trans('projects.milestone') . '] ' . '[' . trans('general.delete') . '] ' . $milestone->name, 'user_id' => auth()->user()->id));
                $milestone->delete();
                return json_encode(array('status' => 'Success', 'message' => trans('general.delete'), 't_type' => 1, 'meta' => $input['object_id']));
                break;

        }

    }

    public function log_history(ManageProjectRequest $request)
    {
        $input = $request->except(['_token', 'ins']);

        $project_select = Project::where('id', '=', $input['project_id'])->with('history')->first();
        $h = $project_select->history;
        return DataTables::of($h)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('created_at', function ($project) {
                return dateTimeFormat($project->created_at);
            })
            ->addColumn('user', function ($project) {
                return user_data($project->user_id)['first_name'];

            })
            ->make(true);

    }

    public function tasks(TaskRepository $task)
    {
        $core = $task->getForDataTable();

        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('start', function ($task) {

                return '<span  class="font-size-small">' . dateTimeFormat($task->start) . '</span>';
            })
            ->addColumn('duedate', function ($task) {
                return '<span  class="font-size-small">' . dateTimeFormat($task->duedate) . '</span>';
            })->addColumn('status', function ($task) {
                $task_back = task_status($task->status, $task->cus);
                return '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span> ';
            })
            ->make(true);

    }

    public function load(ManageProjectRequest $request)
    {

        $project = Project::where('id', '=', $request->project_id)->first();
        $project['start_date'] = dateTimeFormat($project['start_date']);
        $project['end_date'] = dateTimeFormat($project['end_date']);
        $project['creator'] = $project->creator->first_name . ' ' . $project->creator->last_name;
        $c = '';
        foreach ($project->users as $row) {
            $c .= $row['first_name'] . ' ' . $row['last_name'] . ', ';
        }
        $project['assigned'] = $c;

        $task_back = task_status($project->status);
        $status = '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span> ';
        $project['status'] = $status;
        $s = '';
        foreach (status_list() as $row) {
            if ($row['id'] == $task_back->id) $s .= '<option value="' . $row['id'] . '" selected>--' . $row['name'] . '--</option>';
            $s .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }

        $project['status_list'] = $s;
        $project['view'] = route('biller.projects.show', [$project->id]);
        return json_encode($project->only('id', 'name', 'status', 'start_date', 'end_date', 'note', 'short_desc', 'priority', 'creator', 'assigned', 'status', 'status_list', 'view'));
    }

    public function update_status(ManageProjectRequest $request)
    {
        //Update the model using repository update method
        switch ($request->r_type) {
            case 1:
                $project = Project::find($request->project_id);
                $project->progress = $request->progress;
                if ($request->progress == 100) {
                    $status_code = ConfigMeta::where('feature_id', '=', 16)->first();
                    $project->status = $status_code->feature_value;
                }
                $project->save();
                return json_encode(array('status' => $project->progress));
                break;
            case 2:
                $project = Project::find($request->project_id);
                $project->status = $request->sid;
                $project->save();
                $task_back = task_status($project->status);
                $status = '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span> ';
                return json_encode(array('status' => $status));

                break;
        }


    }


}
