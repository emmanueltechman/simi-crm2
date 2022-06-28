<div id="sendEmail" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{trans('general.email')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div id="request" class="m-2 text-center">
                <span class="fa fa-hourglass-half spinner font-large-2 blue"
                      aria-hidden="true"></span>
            </div>
            <div class="modal-body" id="email_body" style="display: none;">
                <form id="send_bill">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mail_to"
                                       value="{{$invoice->customer->email}}">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="customer_name">{{trans('customers.name')}}</label>
                            <input type="text" class="form-control"
                                   name="customer_name" value="{{$invoice->customer->name}}"></div>
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
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden"
                           id="bill_id" name="bill_id" value="{{$invoice['id']}}">
                    <input type="hidden"
                           id="template_type" name="template_type" value="">
                    <input type="hidden" name="template_category" value="1">
                    <input type="hidden" id="action_url" value="{{route('biller.load_template')}}">
                    <input type="hidden" id="action_url_send" value="{{route('biller.send_bill')}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning"
                        data-dismiss="modal">{{trans('general.close')}}</button>
                <button type="button" class="btn btn-primary"
                        id="sendNow">{{trans('general.send')}}</button>
            </div>
        </div>
    </div>
</div>