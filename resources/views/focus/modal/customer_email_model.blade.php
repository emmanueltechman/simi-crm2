<div id="sendEmailCustomer" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{trans('general.email')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_sendEmailCustomer">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="{{trans('customers.email')}}"
                                       name="mail_to"
                                       value="{{$customer->email}}">
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
                            <textarea name="text" class="summernote" id="contents" title="Contents" rows="6"></textarea>
                        </div>
                    </div>

                    <input type="hidden"
                           id="bill_id" name="bill_id" value="{{$customer->id}}">


                    <input type="hidden" id="sendEmailCustomer_url" value="{{route('biller.customer_send_email')}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning"
                        data-dismiss="modal">{{trans('general.close')}}</button>
                <button type="button" class="btn btn-primary"
                        id="sendGeneral" data-name="sendEmailCustomer">{{trans('general.send')}}</button>
            </div>
        </div>
    </div>
</div>