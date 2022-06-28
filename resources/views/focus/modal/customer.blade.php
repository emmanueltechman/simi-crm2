<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        {{ Form::open(['route' => 'biller.customers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'data_form_model_1']) }}

        <!-- Modal Header -->
            <div class="modal-header bg-gradient-directional-purple white">

                <h4 class="modal-title" id="myModalLabel">{{trans('invoices.add_client')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{trans('general.close')}}</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                @include("focus.customers.form")
                <p id="statusMsg"></p><input type="hidden" id="mcustomer_id" value="0">

            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{trans('general.close')}}</button>
                <input type="hidden" id="action-url-model_1" value="{{route('biller.customers.store')}}">
                <input type="submit" id="submit-data-model" class="btn btn-primary submit_data_model_page"
                       value="ADD" data-model_id="1"/>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>