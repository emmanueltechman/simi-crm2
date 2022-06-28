<div class="modal" id="delete_model_2" tabindex="-1" role="dialog" aria-labelledby="delete_model_2Label"
     aria-hidden="true">
    <form id="delete_form_2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('general.delete')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                </div>

                <div class="modal-footer">

                    <input type="hidden" id="object-id_2" value="" name="object_id">
                    <input type="hidden" value="{{$project->id}}" name="project_id">
                    <input type="hidden" value="2" name="obj_type">
                    <input type="hidden" id="action-url_2" value="{{route('biller.projects.delete_meta')}}">
                    <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                            id="delete-confirm_2" data-object-type="2"
                            data-object-trigger="1">{{trans('general.delete')}}</button>
                    <button type="button" data-dismiss="modal"
                            class="btn">{{trans('general.cancel')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>