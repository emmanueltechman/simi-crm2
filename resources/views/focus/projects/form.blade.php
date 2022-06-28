<div>
    <div class="row">
        <fieldset class="form-group col-12">
            <input type="text" class="new-todo-item form-control required"
                   placeholder="{{trans('projects.name')}}" name="name" value="{{$projects->name}}">
        </fieldset>
    </div>
    <div class="row">
        <fieldset class="form-group col-md-4">

            <select class="custom-select" id="todo-select" name="status">
                @php
                    $task_back = task_status($projects->status);
                @endphp
                <option value="{{$task_back['id']}}">--{{$task_back['name']}}--</option>
                @foreach($mics->where('section','=',2) as $row)
                    <option value="{{$row['id']}}">{{$row['name']}}</option>
                @endforeach


            </select>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <select class="custom-select" id="todo-select" name="priority">
                <option value="{{$projects->priority}}">--{{trans('tasks.'.$projects->priority)}}--</option>
                <option value="Low">{{trans('tasks.Low')}}</option>
                <option value="Medium">{{trans('tasks.Medium')}}</option>
                <option value="High">{{trans('tasks.High')}}</option>
                <option value="Urgent">{{trans('tasks.Urgent')}}</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-md-4">
            <select class="form-control select-box" name="tags[]" id="tags"
                    data-placeholder="{{trans('tags.select')}}" multiple>
                @foreach($projects->tags as $row)
                    <option value="{{$row['id']}}" selected>{{$row['name']}}</option>
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
        <input type="text" id="new-todo-desc" class="new-todo-desc form-control required"
               placeholder="{{trans('tasks.short_desc')}}" name="short_desc" value="{{$projects->short_desc}}">

    </fieldset>
    <fieldset class="form-group col-12">
                            <textarea class="new-todo-item form-control required"
                                      placeholder="{{trans('tasks.description')}}"
                                      rows="6" name="note">{{$projects->note}}</textarea>
    </fieldset>
    <div class="form-group row">
        <div class="col-md-4 col-xs-12 mt-1">
            <div class="row">
                <label class="col-sm-4 col-xs-6 control-label"
                       for="sdate">{{trans('meta.from_date')}}</label>

                <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control from_date required"
                           placeholder="Start Date" name="start_date"
                           autocomplete="false" data-toggle="datepicker">

                    <input type="time" name="time_from" class="form-control"
                           value="{{timeFormat($projects->start_date)}}">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 mt-1">
            <div class="row">
                <label class="col-sm-4 col-xs-6  control-label"
                       for="sdate">{{trans('meta.to_date')}}</label>

                <div class="col-sm-6 col-xs-6 ">
                    <input type="text" class="form-control required to_date"
                           placeholder="End Date" name="end_date"
                           data-toggle="datepicker" autocomplete="false">

                    <input type="time" name="time_to" class="form-control" value="{{timeFormat($projects->end_date)}}">
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12 mt-1">
            <div class="row">
                <label class="col-sm-4 col-xs-6 control-label"
                       for="sdate">{{trans('tasks.link_to_calender')}}</label>
                @if($projects->events)
                    <div class="col-sm-6 col-xs-6">
                        <input type="checkbox" class="form-control"
                               name="link_to_calender" checked>
                        {{ Form::text('color', $projects->events['color'],['class' => 'form-control round', 'id'=>'color','placeholder' => trans('miscs.color'),'autocomplete'=>'off','value'=>$projects->events['color']]) }}
                    </div>
                @else
                    <div class="col-sm-6 col-xs-6">
                        <input type="checkbox" class="form-control" name="link_to_calender">
                        {{ Form::text('color', '#0b97f4', ['class' => 'form-control round', 'id'=>'color','placeholder' => trans('miscs.color'),'autocomplete'=>'off']) }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="row">
        <fieldset class="form-group col-md-6">
            <input type="text" class="new-todo-item form-control"
                   placeholder="{{trans('projects.phase')}}" name="phase" value="{{$projects->phase}}">
        </fieldset>

        <fieldset class="form-group col-md-3">
            <input type="text" class="new-todo-item form-control"
                   placeholder="{{trans('projects.worth')}}" name="worth" value="{{$projects->worth}}">
        </fieldset>
        <fieldset class="form-group col-md-3">
            <select class="form-control select-box" name="project_share"
                    data-placeholder="{{trans('projects.project_share')}}">
                <option value="{{$projects->share}}" selected>--{{trans('projects.project_share')}}--</option>
                <option value="0">{{trans('projects.private')}}</option>
                <option value="1">{{trans('projects.internal')}}</option>
                <option value="2">{{trans('projects.external')}}</option>
                <option value="3">{{trans('projects.internal_participate')}}</option>
                <option value="4">{{trans('projects.external_participate')}}</option>
                <option value="5">{{trans('projects.global_participate')}}</option>
                <option value="6">{{trans('projects.global_view')}}</option>
            </select>
        </fieldset>
    </div>

         <div class="row">
    <fieldset class="form-group position-relative has-icon-left col-md-6">

        <select class="form-control  select-box" name="employees[]" id="employee"
                data-placeholder="{{trans('tasks.assign')}}" multiple>
            @foreach($projects->users as $employee)
                <option value="{{$employee['id']}}"
                        selected>{{$employee['first_name']}} {{$employee['last_name']}}</option>
            @endforeach
            @foreach($employees as $employee)
                <option value="{{$employee['id']}}">{{$employee['first_name']}} {{$employee['last_name']}}</option>
            @endforeach
        </select>
    </fieldset>

<fieldset class="form-group position-relative has-icon-left  col-md-6">

                                <select id="person" name="customer" class="form-control required select-box"  data-placeholder="{{trans('customers.customer')}}" >
                                       <option value="{{$projects->customer->id}}"
                        selected>{{$projects->customer->name}} - {{$projects->customer->company}}</option>
                                </select>
                            </fieldset>
</div>
</div>
