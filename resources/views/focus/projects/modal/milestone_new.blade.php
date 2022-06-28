<div class="modal" id="AddMileStoneModal" tabindex="-1" role="dialog" aria-labelledby="AddMileStoneLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <section class="todo-form">
                <form id="data_form_mile_stone" class="todo-input">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddMileStoneLabel">{{trans('projects.milestone_add')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <fieldset class="form-group col-12">
                                <input type="text" class="new-todo-item form-control"
                                       placeholder="{{trans('additionals.name')}}" name="name">
                            </fieldset>
                        </div>


                        <fieldset class="form-group">
                            <textarea class="new-todo-item form-control" placeholder="{{trans('tasks.description')}}"
                                      rows="6" name="description"></textarea>
                        </fieldset>
                        <div class="form-group row">

                            <div class="col-md-6 col-xs-12 mt-1">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-6  control-label"
                                           for="sdate">{{trans('general.due_date')}}</label>

                                    <div class="col-sm-6 col-xs-6 ">
                                        <input type="text" class="form-control required to_date"
                                               placeholder="End Date" name="duedate"
                                               data-toggle="datepicker" autocomplete="false">

                                        <input type="time" name="time_to" class="form-control" value="23:59">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 mt-1">
                                <div class='form-group row'>
                                    {{ Form::label( 'color', trans('miscs.color'),['class' => 'col-3 control-label']) }}
                                    <div class='col-6'>
                                        {{ Form::text('color', '#0b97f4', ['class' => 'form-control round', 'id'=>'color','placeholder' => trans('miscs.color'),'autocomplete'=>'off']) }}
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <button type="button" id="submit-data_mile_stone" class="btn btn-info add-todo-item"
                                    data-dismiss="modal"><i class="fa fa-paper-plane-o d-block d-lg-none"></i>
                                <span class="d-none d-lg-block">{{trans('general.add')}}</span></button>
                        </fieldset>
                    </div>
                    <input type="hidden" value="{{route('biller.projects.store_meta')}}" id="action-url">
                    <input type="hidden" value="{{$project->id}}" name="project_id">
                    <input type="hidden" value="2" name="obj_type">
                </form>
            </section>
        </div>
    </div>
</div>