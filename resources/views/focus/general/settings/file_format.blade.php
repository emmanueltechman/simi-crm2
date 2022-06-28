@extends ('core.layouts.app')
@section ('title', trans('business.theme_settings'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.theme', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('business.theme_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class='row mb-1'>
                                        {{ Form::label( 'token', trans('meta.file_format'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <small>Example: jpeg,gif,png,pdf,xls</small>
                                            <input class="form-control round" name="file_format" type="text"
                                                   value="{{$defaults[9][0]['value1']}}">
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'theme_direction', trans('meta.theme_direction'),['class' => 'col-12 control-label']) }}
                                        <div class='col-12'>
                                            <select name="theme_direction"
                                                    class="round form-control">
                                                {!! $defaults[15][0]['value1']  == 'ltr' ? "<option value='ltr' selected>--".trans('meta.ltr')."--</option>" : "<option value='rtl' selected>--".trans('meta.rtl')."--</option>" !!}
                                                <option value="ltr">{{trans('meta.ltr')}}</option>
                                                <option value="rtl">{{trans('meta.rtl')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=''>
                                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                            </div>
                        </div>


                        <!--edit-form-btn-->

                    </div>


                </div>


                {{ Form::close() }}
            </div>
        </div>

@endsection
