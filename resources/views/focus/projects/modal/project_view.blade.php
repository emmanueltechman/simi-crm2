<div class="modal" id="ViewProjectModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <section class="todo-form">
                <form id="data_form_task_view" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">{{trans('projects.project')}} : <span
                                    id="p_name"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">{{trans('projects.start_date')}} <span class="font-weight-bold"
                                                                                         id="p_start"></span></div>
                            <div class="col-md-3">{{trans('projects.end_date')}} <span class="font-weight-bold"
                                                                                       id="p_end"></span></div>
                            <div class="col-md-3"> <span class="font-weight-bold"
                                                         id="p_status"></span></div>
                            <div class="col-md-3"><select class="custom-select" id="p_status_list" name="status"
                                                          onchange="update_status(this.value)">


                                </select></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">{{trans('projects.owner')}} <span class="font-weight-bold"
                                                                                   id="p_creator"></span></div>
                            <div class="col-md-6">{{trans('projects.users')}} <span class="font-weight-bold"
                                                                                    id="p_assigned"></span></div>
                        </div>
                        <hr>

                        <hr>
                        <p class="info" id="ps_description"></p>
                        <hr>
                        <p id="p_description"></p>


                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <a href=""
                               class="btn btn-blue" id="d_view">{{trans('projects.detailed_view')}}</a>
                            <button type="button" data-dismiss="modal"
                                    class="btn btn-default">{{trans('general.close')}}</button>
                        </fieldset>
                    </div>
                    <input type="hidden" value="" id="p_id">
                </form>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
    function update_status(did) {
        $.ajax({
            url: '{{route('biller.projects.update_status')}}',
            type: 'POST',
            dataType: 'json',
            data: {'project_id': $('#p_id').val(), 'r_type': 2, 'sid': did},
            success: function (data) {
                $('#p_status').html(data.status);
                $('#projects-table').DataTable().ajax.reload();
            }
        });
    }
</script>