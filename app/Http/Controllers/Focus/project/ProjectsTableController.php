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

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\project\ProjectRepository;
use App\Http\Requests\Focus\project\ManageProjectRequest;

/**
 * Class ProjectsTableController.
 */
class ProjectsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProjectRepository
     */
    protected $project;

    /**
     * contructor to initialize repository object
     * @param ProjectRepository $project ;
     */
    public function __construct(ProjectRepository $project)
    {
        $this->project = $project;
    }

    /**
     * This method return the data of the model
     * @param ManageProjectRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProjectRequest $request)
    {
        //
        $core = $this->project->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('name', function ($project) {
                $tg = '';
                $user = '';
                foreach ($project->tags as $row) {
                    $tg .= '<span class="badge" style="background-color:' . $row['color'] . '">' . $row['name'] . '</span> ';
                }

                return '<div class="todo-item media"><div class="media-body"><div class="todo-title"><a href="' . route("biller.projects.show", [$project->id]) . '" >' . $project->name . '</a><div class="float-right">' . $tg . '</div></div><span class="todo-desc">' . $project->short_desc . '</span></div> </div>';
            })
            ->addColumn('priority', function ($project) {
                return '<span class="">' . $project->priority . '</span> ';
            })
            ->addColumn('progress', function ($project) {
                $task_back = task_status($project->status);
                return '<a href="#" class="view_project"  data-toggle="modal"
                                        data-target="#ViewProjectModal" data-item="' . $project->id . '"><span class="badge" style="background-color:' . $task_back['color'] . '">' . $task_back['name'] . '</span></a> ' . numberFormat($project->progress) . ' %';
            })
            ->addColumn('deadline', function ($project) {
                return dateTimeFormat($project->end_date);
            })
            ->addColumn('actions', function ($project) {
                $btn = '';
                $btn .= '<a href="#" title="View" class="view_project success" data-toggle="modal"
                                        data-target="#ViewProjectModal" data-item="' . $project->id . '"><i  class="ft-eye"></i></a> ';
                if ($project->creator->id == auth()->user()->id) {
                    $btn .= '&nbsp;&nbsp;<a href="' . route("biller.projects.edit", [$project->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i  class="ft-edit"></i></a>';

                    $btn .= '&nbsp;&nbsp;<a class="danger" href="' . route("biller.projects.destroy", [$project->id]) . '" data-method="delete" data-trans-button-cancel="' . trans('buttons.general.cancel') . '" data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '" data-trans-title="' . trans('strings.backend.general.are_you_sure') . '" data-toggle="tooltip" data-placement="top" title="Delete"> <i  class="fa fa-trash"></i> </a>';
                }

                return $btn;
            })
            ->make(true);
    }
}
