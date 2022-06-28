<div class="modal" id="AddNoteModal" tabindex="-1" role="dialog" aria-labelledby="AddNoteLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <section class="todo-form">
                <form id="data_form_note" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddNoteLabel">{{trans('general.note')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <fieldset class="form-group col-12">
                                <input type="text" class="new-todo-item form-control"
                                       placeholder="{{trans('general.title')}}" name="title">
                            </fieldset>
                        </div>


                        <fieldset class="form-group">
                            <textarea class="new-todo-item form-control summernote"
                                      placeholder="{{trans('tasks.description')}}"
                                      rows="6" name="content"></textarea>
                        </fieldset>


                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" id="submit-data_note" class="btn btn-info add-todo-item"
                                    data-dismiss="modal"><i class="fa fa-paper-plane-o d-block d-lg-none"></i>
                                <span class="d-none d-lg-block">{{trans('general.add')}}</span></button>
                        </fieldset>
                    </div>
                    <input type="hidden" value="{{route('biller.projects.store_meta')}}" id="action-url_6">
                    <input type="hidden" value="{{$project->id}}" name="project_id">
                    <input type="hidden" value="6" name="obj_type">
                </form>
            </section>
        </div>
    </div>
</div>