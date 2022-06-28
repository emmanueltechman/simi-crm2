<div id="sendEmailGroup" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{trans('general.email')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body" id="email_body">
                <form id="form_sendEmailGroup">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mail_to"
                                       value="{{$customergroup->title}} {{trans('customergroups.members')}}">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="subject">{{trans('general.subject')}}</label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="contents">{{trans('general.body')}}</label>
                            <textarea name="text" class="summernote" id="contents" title="Contents" rows="3"></textarea>
                        </div>
                    </div>

                    <input type="hidden"
                           id="bill_id" name="bill_id" value="{{$customergroup->id}}">
                    <input type="hidden" id="sendEmailGroup_url" value="{{route('biller.group_send_email')}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning"
                        data-dismiss="modal">{{trans('general.close')}}</button>
                <button data-name="sendEmailGroup" type="button" class="btn btn-primary"
                        id="sendGeneral">{{trans('general.send')}}</button>
            </div>
        </div>
    </div>
</div>