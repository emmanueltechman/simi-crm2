<!-- cancel -->
<div id="pop_model_2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">{{trans('general.cancel_bill')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_model_2">

                    <div class="alert alert-danger p-1 round">
                        {{trans('general.irreversible_action')}}
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="bill_id" value="{{$invoice['id']}}">
                        <input type="hidden" name="bill_type" value="{{$invoice['bill_type']}}">
                        <input type="hidden" id="action-url_2" value="{{route('biller.bill_cancel')}}">
                        <button type="button" class="btn btn-info"
                                data-dismiss="modal">{{trans('general.close')}}</button>
                        <button type="button" class="btn btn-danger submit_model"
                                id="submit_model_2" data-itemid="2">{{trans('general.cancel_bill')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
