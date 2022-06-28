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
namespace App\Http\Controllers\Focus\template;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\template\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\template\CreateResponse;
use App\Http\Responses\Focus\template\EditResponse;
use App\Repositories\Focus\template\TemplateRepository;

/**
 * TemplatesController
 */
class TemplatesController extends Controller
{
    /**
     * variable to store the repository object
     * @var TemplateRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TemplateRepository $repository ;
     */
    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\template\ManageTemplateRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageCompanyRequest $request)
    {
        return new ViewResponse('focus.templates.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\template\Template $template
     * @param EditTemplateRequestNamespace $request
     * @return \App\Http\Responses\Focus\template\EditResponse
     */
    public function edit(Template $template, ManageCompanyRequest $request)
    {
        return new EditResponse($template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTemplateRequestNamespace $request
     * @param App\Models\template\Template $template
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(ManageCompanyRequest $request, Template $template)
    {
        //Input received from the request
        $input = $request->only(['title', 'body']);
        //Update the model using repository update method
        $this->repository->update($template, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.templates.index'), ['flash_success' => trans('alerts.backend.templates.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteTemplateRequestNamespace $request
     * @param App\Models\template\Template $template
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Template $template, ManageCompanyRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.templates.view', compact('template'));
    }

}
