<div id="pop_model_4" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">{{trans('invoices.subscription_status')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_4">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod">{{trans('general.mark_as')}}</label>
                            <select name="status" class="form-control mb-1">
                                <option value="2">{{trans('payments.active')}}</option>
                                <option value="3">{{trans('payments.recurred')}}</option>
                                <option value="4">{{trans('payments.stopped')}}</option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden"
                               name="bill_id" value="{{$invoice['id']}}">
                        <input type="hidden"
                               name="bill_type" value="2">
                        <button type="button" class="btn btn-warning"
                                data-dismiss="modal">{{trans('general.close')}}</button>
                        <input type="hidden" id="action-url_4" value="{{route('biller.bill_status')}}">
                        <button type="button" class="btn btn-primary submit_model"
                                id="submit_model_4" data-itemid="4">{{trans('general.change_status')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>