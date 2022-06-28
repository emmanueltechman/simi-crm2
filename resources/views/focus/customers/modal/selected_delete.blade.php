<div id="deleteSelected" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">{{trans('customers.delete_selected')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>{{trans('customers.delete_selected')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="confirmDeleteSelected">{{trans('general.delete')}}</button>
                <button type="button" data-dismiss="modal" class="btn">{{trans('general.close')}}</button>
            </div>
        </div>
    </div>
</div>