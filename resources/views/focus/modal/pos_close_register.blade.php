<div class="modal fade" id="close_register" role="dialog">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-directional-pink white">

                <h4 class="modal-title" id="myModalLabel">{{trans('pos.register_close')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{trans('pos.pos')}}</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="text-center">
                    <a class="btn btn-success btn-lg" href="{{route('biller.register.close')}}">&nbsp;<i
                                class="icon-close"></i> {{trans('general.yes')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>