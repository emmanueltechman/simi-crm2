<div id="sendSmsS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">{{ trans('customers.sms_selected') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendsms_form">
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote">{{ trans('general.message') }}</label>
                            <textarea name="message" class="form-control" rows="3" cols="60"></textarea></div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('general.close') }}</button>
                <button type="button" class="btn btn-primary"
                        id="sendSmsSelected">{{ trans('general.send') }}</button>
            </div>
        </div>
    </div>

</div>