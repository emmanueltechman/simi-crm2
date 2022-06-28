<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('customers.email_selected') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote">{{ trans('general.subject') }}</label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote">{{ trans('general.messages') }}</label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('general.close') }}</button>
                <button type="button" class="btn btn-primary"
                        id="sendNowSelected">{{ trans('general.send') }}</button>
            </div>
        </div>
    </div>
</div>