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
namespace App\Http\Controllers\Focus\tag;

use App\Models\tag\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\tag\CreateResponse;
use App\Http\Responses\Focus\tag\EditResponse;
use App\Repositories\Focus\tag\TagRepository;
use App\Http\Requests\Focus\tag\ManageTagRequest;
use App\Http\Requests\Focus\tag\CreateTagRequest;
use App\Http\Requests\Focus\tag\StoreTagRequest;
use App\Http\Requests\Focus\tag\EditTagRequest;
use App\Http\Requests\Focus\tag\UpdateTagRequest;
use App\Http\Requests\Focus\tag\DeleteTagRequest;

/**
 * TagsController
 */
class TagsController extends Controller
{
    /**
     * variable to store the repository object
     * @var TagRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TagRepository $repository ;
     */
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\tag\ManageTagRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageTagRequest $request)
    {
        $input['json'] = "module:'tags'";
        $input['title'] = trans('labels.backend.tags.management');
        $input['col1'] = trans('tags.tag');
        $input['col2'] = trans('general.color');
        if ($request->module == 'task') {
            $input['title'] = trans('tasks.status_management');
            $input['col1'] = trans('tasks.status');

            $input['json'] = "module:'task'";
        }

        return new ViewResponse('focus.tags.index', compact('input'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateTagRequestNamespace $request
     * @return \App\Http\Responses\Focus\tag\CreateResponse
     */
    public function create(ManageTagRequest $request)
    {
        return new CreateResponse('focus.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(ManageTagRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        $input['ins'] = auth()->user()->ins;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.tags.index'), ['flash_success' => trans('alerts.backend.tags.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\tag\Tag $tag
     * @param EditTagRequestNamespace $request
     * @return \App\Http\Responses\Focus\tag\EditResponse
     */
    public function edit(Tag $tag, ManageTagRequest $request)
    {
        return new EditResponse($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTagRequestNamespace $request
     * @param App\Models\tag\Tag $tag
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageTagRequest $request, Tag $tag)
    {
        //Input received from the request
        $input = $request->except(['_token', 'ins']);
        //Update the model using repository update method
        $this->repository->update($tag, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.tags.index'), ['flash_success' => trans('alerts.backend.tags.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTagRequestNamespace $request
     * @param App\Models\tag\Tag $tag
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Tag $tag, ManageTagRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($tag);
        //returning with successfull message
        return new RedirectResponse(route('biller.tags.index'), ['flash_success' => trans('alerts.backend.tags.deleted')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTagRequestNamespace $request
     * @param App\Models\tag\Tag $tag
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Tag $tag, ManageTagRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.tags.view', compact('tag'));
    }

}
