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

use App\Models\hrm\Hrm;
use App\Models\misc\Misc;
use App\Models\project\Project;
use App\Models\project\Task;
use App\Models\tag\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\task\CreateResponse;
use App\Http\Responses\Focus\task\EditResponse;
use App\Repositories\Focus\project\TaskRepository;
use App\Http\Requests\Focus\project\ManageTaskRequest;
use App\Http\Requests\Focus\project\CreateTaskRequest;
use App\Http\Requests\Focus\project\StoreTaskRequest;
use App\Http\Requests\Focus\project\EditTaskRequest;
use App\Http\Requests\Focus\project\UpdateTaskRequest;
use App\Http\Requests\Focus\project\DeleteTaskRequest;

/**
 * TasksController
 */
class TasksController extends Controller
{
    /**
     * variable to store the repository object
     * @var TaskRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TaskRepository $repository ;
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\project\ManageTaskRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageTaskRequest $request)
    {
        $mics = Misc::all();
        $employees = Hrm::all();
        $user = auth()->user()->id;
        $project_select = Project::whereHas('users', function ($q) use ($user) {
            return $q->where('rid', '=', $user);
        })->get();


        return new ViewResponse('focus.projects.tasks.index', compact('mics', 'employees', 'project_select'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateTaskRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        $input['creator_id'] = auth()->user()->id;
        //Create the model using repository create method
        $result = $this->repository->create($input);
        //return with successfull message
        //return new RedirectResponse(route('biller.tasks.index'), ['flash_success' => trans('alerts.backend.tasks.created')]);
        $tg = '';
        foreach ($result->tags as $row) {
            $tg .= '<span class="badge" style="background-color:' . $row['color'] . '">' . $row['name'] . '</span> ';
        }

        $btn = '';
        $btn .= '<a href="' . route("biller.tasks.edit", [$result->id]) . '" data-toggle="tooltip" data-placement="top" title="View" class="success"><i  class="ft-eye"></i></a> ';
        $btn .= '&nbsp;&nbsp;<a href="' . route("biller.tasks.edit", [$result->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i  class="ft-edit"></i></a>';
        $btn .= '&nbsp;&nbsp;<a class="danger" href="' . route("biller.tasks.destroy", [$result->id]) . '" table-method="delete" data-trans-button-cancel="' . trans('buttons.general.cancel') . '" data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '" data-trans-title="' . trans('strings.backend.general.are_you_sure') . '" data-toggle="tooltip" data-placement="top" title="Delete"> <i  class="fa fa-trash"></i> </a>';
        $task_back = task_status($result->status);
        $status = '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span>';
        echo json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.tasks.created') . ' &nbsp; &nbsp;', 'title' => $result->name, 'short_desc' => $result->short_desc, 'row' => '<tr><td><div class="todo-item media"><div class="media-body"><div class="todo-title"><a href="' . route("biller.tasks.show", [$result->id]) . '" >' . $result->name . '</a><div class="float-right">' . $tg . '</div></div><span class="todo-desc">' . $result->short_desc . '</span></div> </div></td><td>' . dateTimeFormat($result->start) . '</td><td>' . dateTimeFormat($result->duedate) . '</td><td>' . $status . '</td><td>' . $btn . '</td></tr>', 't_type' => 3));

        $feature = feature(11);
        $alert = json_decode($feature->value2, true);
        if ($alert['task_new']) {
            $mail = array();
            $mail['mail_to'] = $feature->value1;
            $mail['customer_name'] = trans('tasks.task');
            $mail['subject'] = trans('tasks.task') . '#' . $result->name;
            $mail['text'] = trans('tasks.task') . ' #' . $result->name . '<br>' . trans('tasks.duedate') . '<br> ' . dateTimeFormat($result->duedate) . ' <br> - ' . $result->short_desc;
            business_alerts($mail);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\project\Task $task
     * @param EditTaskRequestNamespace $request
     * @return \App\Http\Responses\Focus\project\EditResponse
     */
    public function edit(Task $task, EditTaskRequest $request)
    {
        return new EditResponse($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequestNamespace $request
     * @param App\Models\project\Task $task
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditTaskRequest $request, Task $task)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($task, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.tasks.index'), ['flash_success' => trans('alerts.backend.tasks.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTaskRequestNamespace $request
     * @param App\Models\project\Task $task
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Task $task, DeleteTaskRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($task);

        return json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.tasks.deleted')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTaskRequestNamespace $request
     * @param App\Models\project\Task $task
     * @return \App\Http\Responses\RedirectResponse
     */
    public function load(ManageTaskRequest $request)
    {

        $task = Task::where('id', '=', $request->id)->first();
        $task['start'] = dateTimeFormat($task['start']);
        $task['duedate'] = dateTimeFormat($task['duedate']);
        $task['creator'] = $task->creator->first_name . ' ' . $task->creator->last_name;
        $c = '';
        foreach ($task->users as $row) {
            $c .= $row['first_name'] . ' ' . $row['last_name'] . ', ';
        }
        $task['assigned'] = $c;

        $task_back = task_status($task->status);
        $status = '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span> ';
        $task['status'] = $status;
        $s = '';
        foreach (status_list() as $row) {
            if ($row['id'] == @$task_back->id) $s .= '<option value="' . $row['id'] . '" selected>--' . $row['name'] . '--</option>';
            $s .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }

        $task['status_list'] = $s;
        return json_encode($task->only('id', 'name', 'status', 'start', 'duedate', 'description', 'short_desc', 'priority', 'creator', 'assigned', 'status', 'status_list'));
    }

    public function update_status(Request $request)
    {
        $flag = false;
        if (access()->allow('update-task')) $flag = true;
        if ($request->id and !$flag) {
            $task = Task::find($request->id);
            if ($task->creator_id == auth()->user()->id) $flag = true;
            $assigned = $task->users->where('id', '=', auth()->user()->id)->first();
            if (isset($assigned->id)) {
                $flag = true;
            }
        }
        //Update the model using repository update method
        if ($flag) {
            $task = Task::find($request->id);
            $task->status = $request->sid;
            $task->save();
            $task_back = task_status($task->status);
            $status = '<span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span> ';
            return json_encode(array('status' => $status));
        }
    }

}
