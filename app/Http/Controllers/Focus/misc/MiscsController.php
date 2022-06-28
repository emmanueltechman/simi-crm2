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
namespace App\Http\Controllers\Focus\misc;

use App\Models\misc\Misc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\misc\CreateResponse;
use App\Http\Responses\Focus\misc\EditResponse;
use App\Repositories\Focus\misc\MiscRepository;
use App\Http\Requests\Focus\misc\ManageMiscRequest;
use App\Http\Requests\Focus\misc\CreateMiscRequest;
use App\Http\Requests\Focus\misc\EditMiscRequest;


/**
 * MiscsController
 */
class MiscsController extends Controller
{
    /**
     * variable to store the repository object
     * @var MiscRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param MiscRepository $repository ;
     */
    public function __construct(MiscRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\misc\ManageMiscRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageMiscRequest $request)
    {
        $input['json'] = "module:'tags'";
        $input['title'] = trans('labels.backend.tags.management');
        $input['col1'] = trans('tags.tag');
        $input['col2'] = trans('general.color');
        $input['module'] = "tag";
        if ($request->module == 'task') {
            $input['title'] = trans('tasks.status_management');
            $input['col1'] = trans('tasks.status');
            $input['module'] = "task";
            $input['json'] = "module:'task'";
        }
        return new ViewResponse('focus.miscs.index', compact('input'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateMiscRequestNamespace $request
     * @return \App\Http\Responses\Focus\misc\CreateResponse
     */
    public function create(CreateMiscRequest $request)
    {

        return new CreateResponse('focus.miscs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMiscRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateMiscRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;

        if ($input['section'] == 'tag') $input['section'] = 1; else   $input['section'] = 2;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.miscs.index') . '?module=' . $request->section, ['flash_success' => trans('alerts.backend.miscs.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\misc\Misc $misc
     * @param EditMiscRequestNamespace $request
     * @return \App\Http\Responses\Focus\misc\EditResponse
     */
    public function edit(Misc $misc, EditMiscRequest $request)
    {
        return new EditResponse($misc);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMiscRequestNamespace $request
     * @param App\Models\misc\Misc $misc
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditMiscRequest $request, Misc $misc)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($misc, $input);
        //return with successfull message
        if ($misc->section == 2) return new RedirectResponse(route('biller.miscs.index') . '?module=task', ['flash_success' => trans('alerts.backend.miscs.updated')]);
        return new RedirectResponse(route('biller.miscs.index'), ['flash_success' => trans('alerts.backend.miscs.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteMiscRequestNamespace $request
     * @param App\Models\misc\Misc $misc
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Misc $misc, EditMiscRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($misc);
        //returning with successfull message
        return json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.miscs.deleted')));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteMiscRequestNamespace $request
     * @param App\Models\misc\Misc $misc
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Misc $misc, ManageMiscRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.miscs.view', compact('misc'));
    }

}
