<div class="modal fade" id="pos_register" role="dialog">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-directional-purple white">

                <h4 class="modal-title" id="myModalLabel">{{trans('pos.register_status')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{trans('pos.pos')}}</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center m-1">{{trans('pos.opened_on')}} <span id="r_date"></span></div>
                <div class="row" id="register_items">
                    @foreach(payment_methods() as $row)
                        <div class="col-6">
                            <div class="form-group  text-bold-600 green">
                                <label for="{{$row}}">{{$row}}
                                </label>
                                <input type="text" class="form-control green" id="pm_{{$loop->iteration}}" value="0.00"
                                       readonly=""
                                       name="pm_{{$loop->iteration}}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>