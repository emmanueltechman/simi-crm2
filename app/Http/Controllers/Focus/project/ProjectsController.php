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
namespace App\Http\Controllers\Focus\project;

use App\Models\Company\ConfigMeta;
use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\note\Note;
use App\Models\project\Project;
use App\Models\project\ProjectLog;
use App\Models\project\ProjectMileStone;
use App\Models\project\ProjectRelations;
use App\Repositories\Focus\invoice\InvoiceRepository;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\project\EditResponse;
use App\Repositories\Focus\project\ProjectRepository;
use App\Http\Requests\Focus\project\ManageProjectRequest;
use App\Http\Requests\Focus\project\CreateProjectRequest;
use App\Http\Requests\Focus\project\EditProjectRequest;
use App\Http\Requests\Focus\project\UpdateProjectRequest;
use App\Http\Requests\Focus\project\DeleteProjectRequest;
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
    public function index(ManageProjectRequest $request)
    {
        $mics = Misc::all();
        $employees = Hrm::all();
        return new ViewResponse('focus.projects.index', compact('mics', 'employees'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateProjectRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $result = $this->repository->create($input);
        //return with successfull message
        $tg = '';
        foreach ($result->tags as $row) {
            $tg .= '<span class="badge" style="background-color:' . $row['color'] . '">' . $row['name'] . '</span> ';
        }

        $p_status = task_status($result->status);
        $p_status = '<span class="badge" style="background-color:' . $p_status['color'] . '">' . $p_status['name'] . '</span> ' . numberFormat($result->progress) . ' %';

        $btn = '';
        $btn .= '<a href="' . route("biller.projects.show", [$result->id]) . '" data-toggle="tooltip" data-placement="top" title="View" class="success"><i  class="ft-eye"></i></a> ';
        $btn .= '&nbsp;&nbsp;<a href="' . route("biller.projects.edit", [$result->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i  class="ft-edit"></i></a>';
        $btn .= '&nbsp;&nbsp;<a class="danger" href="' . route("biller.projects.destroy", [$result->id]) . '" data-method="delete" data-trans-button-cancel="' . trans('buttons.general.cancel') . '" data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '" data-trans-title="' . trans('strings.backend.general.are_you_sure') . '" data-toggle="tooltip" data-placement="top" title="Delete"> <i  class="fa fa-trash"></i> </a>';


        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.projects.created') . ' <a href="' . route('biller.projects.show', [$result->id]) . '" class="btn btn-primary btn-md"><span class="fa fa-eye" aria-hidden="true"></span> ' . trans('general.view') . '  </a> &nbsp; &nbsp;', 'title' => $result->name, 'short_desc' => $result->short_desc, 'row' => '<tr><td><span class="badge badge-danger" >' . trans('general.new') . '</span></td><td><div class="todo-item media"><div class="media-body"><div class="todo-title"><a href="' . route("biller.projects.show", [$result->id]) . '" >' . $result->name . '</a><div class="float-right">' . $tg . '</div></div><span class="todo-desc">' . $result->short_desc . '</span></div> </div></td><td>' . $result->priority . '</td><td>' . $p_status . '</td><td>' . dateTimeFormat($result->end_date) . '</td><td>' . $btn . '</td></tr>'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\project\Project $project
     * @param EditProjectRequestNamespace $request
     * @return \App\Http\Responses\Focus\project\EditResponse
     */
    public function edit(Project $project, EditProjectRequest $request)
    {
        if ($project->creator->id == auth()->user()->id) {
            return new EditResponse($project);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequestNamespace $request
     * @param App\Models\project\Project $project
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        if ($project->creator->id == auth()->user()->id) {
            $this->repository->update($project, $input);
        }
        //return with successfull message
        return new RedirectResponse(route('biller.projects.index'), ['flash_success' => trans('alerts.backend.projects.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProjectRequestNamespace $request
     * @param App\Models\project\Project $project
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Project $project, DeleteProjectRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($project);
        //returning with successfull message
        return new RedirectResponse(route('biller.projects.index'), ['flash_success' => trans('alerts.backend.projects.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteProjectRequestNamespace $request
     * @param App\Models\project\Project $project
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Project $project, ManageProjectRequest $request)
    {

        if (project_view($project->id)) {
            //returning with successfull message
            $employees = Hrm::all();
            $mics = Misc::all();
            $user = auth()->user()->id;
            $features = ConfigMeta::where('feature_id', 9)->first();
            $project_select = Project::whereHas('users', function ($q) use ($user) {
                return $q->where('rid', '=', $user);
            })->get();
            return new ViewResponse('focus.projects.view', compact('project', 'employees', 'mics', 'project_select', 'features'));
        }
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

    public function invoices(InvoiceRepository $invoice)
    {
        $core = $invoice->getForDataTable();

        return Datatables::of($core)
            ->addIndexColumn()
            ->addColumn('tid', function ($invoice) {
                return '<a class="font-weight-bold" href="' . route('biller.invoices.show', [$invoice->id]) . '">' . $invoice->tid . '</a>';
            })
            ->addColumn('customer', function ($invoice) {
                return $invoice->customer->name . ' <a class="font-weight-bold" href="' . route('biller.customers.show', [$invoice->customer->id]) . '"><i class="ft-eye"></i></a>';
            })
            ->addColumn('invoicedate', function ($invoice) {
                return dateFormat($invoice->invoicedate);
            })
            ->addColumn('total', function ($invoice) {
                return amountFormat($invoice->total);
            })
            ->addColumn('status', function ($invoice) {
                return '<span class="st-' . $invoice->status . '">' . trans('payments.' . $invoice->status) . '</span>';
            })
            ->addColumn('invoiceduedate', function ($invoice) {
                return dateFormat($invoice->invoiceduedate);
            })
            ->addColumn('actions', function ($invoice) {
                return $invoice->action_buttons;
            })->rawColumns(['tid', 'customer', 'actions', 'status', 'total'])
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
