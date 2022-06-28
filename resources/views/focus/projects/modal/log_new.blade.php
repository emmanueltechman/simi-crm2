<div class="modal" id="AddLogModal" tabindex="-1" role="dialog" aria-labelledby="AddLogLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <section class="todo-form">
                <form id="data_form_log" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddLogLabel">{{trans('projects.activity')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <fieldset class="form-group col-12">
                                <input type="text" class="new-todo-item form-control"
                                       placeholder="{{trans('general.description')}}" name="name" maxlength="250">
                            </fieldset>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" id="submit-data_log" class="btn btn-info add-todo-item"
                                    data-dismiss="modal"><i class="fa fa-paper-plane-o d-block d-lg-none"></i>
                                <span class="d-none d-lg-block">{{trans('general.add')}}</span></button>
                        </fieldset>
                    </div>
                    <input type="hidden" value="{{route('biller.projects.store_meta')}}" id="action-url_5">
                    <input type="hidden" value="{{$project->id}}" name="project_id">
                    <input type="hidden" value="5" name="obj_type">
                </form>
            </section>
        </div>
    </div>
</div>