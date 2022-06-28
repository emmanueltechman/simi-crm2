<form id="data_form_task" class="todo-input">

    <div class="card-body">
        <div class="row">
            <fieldset class="form-group col-12">
                <input type="text" class="new-todo-item form-control"
                       placeholder="{{trans('tasks.name')}}" name="name" value="{{$tasks->name}}">
            </fieldset>
        </div>
        <div class="row">
            <fieldset class="form-group col-md-4">
                <select class="custom-select" id="todo-select" name="status">
                    <option value="{{$tasks->status}}" selected>--{{$tasks->task_status->name}}--</option>
                    @foreach($mics->where('section','=',2) as $row)
                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                    @endforeach


                </select>
            </fieldset>

            <fieldset class="form-group col-md-4">
                <select class="custom-select" id="todo-select" name="priority">
                    <option value="{{$tasks->priority}}" selected>--{{trans('tasks.'.$tasks->priority)}}--</option>
                    <option value="Medium">{{trans('tasks.priority')}}</option>
                    <option value="Low">{{trans('tasks.Low')}}</option>
                    <option value="Medium">{{trans('tasks.Medium')}}</option>
                    <option value="High">{{trans('tasks.High')}}</option>
                    <option value="Urgent">{{trans('tasks.Urgent')}}</option>
                </select>
            </fieldset>
            <fieldset class="form-group col-md-4">

                <select class="form-control  select-box" name="tags[]" id="tags"
                        data-placeholder="{{trans('tags.select')}}" multiple>

                    @foreach($tasks->tags as $tag)
                        <option value="{{$tag['id']}}" selected>{{$tag['name']}}</option>
                    @endforeach
                    @foreach($mics->where('section','=',1) as $tag)
                        <option value="{{$tag['id']}}">{{$tag['name']}}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <fieldset class="form-group position-relative has-icon-left col-12">
            <div class="form-control-position">
                <i class="icon-emoticon-smile"></i>
            </div>
            <input type="text" id="new-todo-desc" class="new-todo-desc form-control"
                   placeholder="{{trans('tasks.short_desc')}}" name="short_desc" value="{{$tasks->short_desc}}">

        </fieldset>
        <fieldset class="form-group col-12">
                            <textarea class="new-todo-item form-control" placeholder="{{trans('tasks.description')}}"
                                      rows="6" name="description">{{$tasks->description}}</textarea>
        </fieldset>
        <div class="form-group row">
            <div class="col-md-4 col-xs-12 mt-1">
                <div class="row">
                    <label class="col-sm-4 col-xs-6 control-label"
                           for="sdate">{{trans('meta.from_date')}}</label>

                    <div class="col-sm-4 col-xs-6">
                        <input type="text" class="form-control from_date required"
                               placeholder="Start Date" name="start"
                               autocomplete="false" data-toggle="datepicker">

                        <input type="time" name="time_from" class="form-control" value="{{timeFormat($tasks->start)}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6 mt-1">
                <div class="row">
                    <label class="col-sm-4 col-xs-6  control-label"
                           for="sdate">{{trans('meta.to_date')}}</label>

                    <div class="col-sm-6 col-xs-6">
                        <input type="text" class="form-control required to_date"
                               placeholder="End Date" name="duedate"
                               data-toggle="datepicker" autocomplete="false">

                        <input type="time" name="time_to" class="form-control" value="{{timeFormat($tasks->duedate)}}">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 mt-1">
                <div class="row">
                    <label class="col-sm-4 col-xs-6 control-label"
                           for="sdate">{{trans('tasks.link_to_calender')}}</label>
                    @if($tasks->events)
                        <div class="col-sm-6 col-xs-6">
                            <input type="checkbox" class="form-control"
                                   name="link_to_calender" checked>
                            {{ Form::text('color', $tasks->events['color'],['class' => 'form-control round', 'id'=>'color_t','placeholder' => trans('miscs.color'),'autocomplete'=>'off','value'=>$tasks->events['color']]) }}
                        </div>
                    @else
                        <div class="col-sm-6 col-xs-6">
                            <input type="checkbox" class="form-control"
                                   name="link_to_calender">
                            {{ Form::text('color', '#0b97f4',['class' => 'form-control round', 'id'=>'color_t','placeholder' => trans('miscs.color'),'autocomplete'=>'off']) }}
                        </div>
                    @endif
                </div>
            </div>

        </div>


        <fieldset class="form-group position-relative has-icon-left">

            <select class="form-control  select-box" name="employees[]" id="employee"
                    data-placeholder="{{trans('tasks.assign')}}" multiple>
                @foreach($tasks->users as $employee)
                    <option value="{{$employee['id']}}"
                            selected>{{$employee['first_name']}} {{$employee['last_name']}}</option>
                @endforeach
                @foreach($employees as $employee)
                    <option value="{{$employee['id']}}">{{$employee['first_name']}} {{$employee['last_name']}}</option>
                @endforeach
            </select>
        </fieldset>
        @if(isset($project->id))  <input name="projects[]" type="hidden"
                                         value="{{$project->id}}"> @elseif(isset($project_select[0]))
            <fieldset class="form-group position-relative has-icon-left">

                <select class="form-control  select-box" name="projects[]" id="projects"
                        data-placeholder="{{trans('projects.projects')}}" multiple>
                    @foreach($tasks->projects as $p_row)
                        <option value="{{$p_row['id']}}" selected>{{$p_row['name']}}</option>
                    @endforeach
                    @foreach($project_select as $p_row)
                        <option value="{{$p_row['id']}}">{{$p_row['name']}}</option>
                    @endforeach
                </select>
            </fieldset>

        @endif
    </div>

    <input type="hidden" value="{{route('biller.tasks.store')}}" id="action-url_task">
</form>