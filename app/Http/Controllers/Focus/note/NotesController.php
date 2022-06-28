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
namespace App\Http\Controllers\Focus\note;

use App\Models\note\Note;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Focus\note\CreateResponse;
use App\Http\Responses\Focus\note\EditResponse;
use App\Repositories\Focus\note\NoteRepository;
use App\Http\Requests\Focus\note\ManageNoteRequest;
use App\Http\Requests\Focus\note\CreateNoteRequest;
use App\Http\Requests\Focus\note\EditNoteRequest;


/**
 * NotesController
 */
class NotesController extends Controller
{
    /**
     * variable to store the repository object
     * @var NoteRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param NoteRepository $repository ;
     */
    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Focus\note\ManageNoteRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageNoteRequest $request)
    {
        return new ViewResponse('focus.notes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateNoteRequestNamespace $request
     * @return \App\Http\Responses\Focus\note\CreateResponse
     */
    public function create(CreateNoteRequest $request)
    {
        return new CreateResponse('focus.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNoteRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(CreateNoteRequest $request)
    {
        //Input received from the request
        $input = $request->only(['title', 'content']);
        $input['ins'] = auth()->user()->ins;
        $input['user_id'] = auth()->user()->id;
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('biller.notes.index'), ['flash_success' => trans('alerts.backend.notes.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\note\Note $note
     * @param EditNoteRequestNamespace $request
     * @return \App\Http\Responses\Focus\note\EditResponse
     */
    public function edit(Note $note, EditNoteRequest $request)
    {
        return new EditResponse($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNoteRequestNamespace $request
     * @param App\Models\note\Note $note
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(EditNoteRequest $request, Note $note)
    {
        //Input received from the request

        $input = $request->only(['title', 'content']);
        //Update the model using repository update method
        $this->repository->update($note, $input);
        //return with successfull message
        return new RedirectResponse(route('biller.notes.index'), ['flash_success' => trans('alerts.backend.notes.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteNoteRequestNamespace $request
     * @param App\Models\note\Note $note
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Note $note, EditNoteRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($note);
        //returning with successfull message
        return json_encode(array('status' => 'Success', 'message' => trans('alerts.backend.notes.deleted')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteNoteRequestNamespace $request
     * @param App\Models\note\Note $note
     * @return \App\Http\Responses\RedirectResponse
     */
    public function show(Note $note, ManageNoteRequest $request)
    {

        //returning with successfull message
        return new ViewResponse('focus.notes.view', compact('note'));
    }

}
