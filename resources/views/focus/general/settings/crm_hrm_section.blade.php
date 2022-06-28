@extends ('core.layouts.app')
@section ('title', trans('business.crm_hrm_settings'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.crm_hrm_section_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('meta.self_attendance') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class='row mb-1'>

                                        <div class='col-md-6'>

                                            {{ Form::label( 'token', trans('meta.self_attendance'),['class' => 'col-12 control-label']) }}
                                            <div class='col-12'>

                                                <select class="form-control round" name="self_attendance">
                                                    {!! $defaults[18][0]['feature_value']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                    <option value="1">{{trans('general.yes')}}</option>
                                                    <option value="0">{{trans('general.no')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class=''>
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom-blue-grey">
                                    <h4 class="card-title">{{ trans('meta.customer_login') }}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">

                                        <div class='row mb-1'>

                                            <div class='col-md-6'>

                                                {{ Form::label( 'token', trans('meta.customer_login'),['class' => 'col-12 control-label']) }}
                                                <div class='col-12'>

                                                    <select class="form-control round" name="customer_login">
                                                        {!! $defaults[18][0]['value2']  == 1 ? "<option value='1' selected>--".trans('general.yes')."--</option>" : "<option value='0' selected>--".trans('general.no')."--</option>" !!}

                                                        <option value="1">{{trans('general.yes')}}</option>
                                                        <option value="0">{{trans('general.no')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class=''>
                                            {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--edit-form-btn-->

                        </div>


                    </div>


                    {{ Form::close() }}
                </div>
            </div>
        </div>
@endsection
