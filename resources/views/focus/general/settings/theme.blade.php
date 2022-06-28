@extends ('core.layouts.app')
@section ('title', trans('business.theme_settings'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.theme_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('business.theme_settings') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class='row mb-1'>
                                        {{ Form::label( 'theme_direction', trans('meta.theme_direction'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select name="theme_direction"
                                                    class="round form-control">
                                                {!! $defaults[15][0]['value1']  == 'ltr' ? "<option value='ltr' selected>--".trans('meta.ltr')."--</option>" : "<option value='rtl' selected>--".trans('meta.rtl')."--</option>" !!}
                                                <option value="ltr">{{trans('meta.ltr')}}</option>
                                                <option value="rtl">{{trans('meta.rtl')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'theme_direction', 'Theme Style',['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select name="theme_style"
                                                    class="round form-control">
                                                {!! $defaults[12][0]['value2']  == 'h' ? "<option value='h' selected>--Horizontal--</option>" : "<option value='v' selected>--Vertical--</option>" !!}
                                                <option value="h">Horizontal - Default</option>
                                                <option value="v">Vertical</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=''>
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('business.bill_style') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class='row mb-1'>
                                        {{ Form::label( 'bill_style', trans('business.bill_style'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select name="bill_style"
                                                    class="round form-control">
                                                {!! $defaults[5][0]['value2']  == '1' ? "<option value='1' selected>--".trans('meta.print_style_1')."--</option>" : "<option value='2' selected>--".trans('meta.print_style_2')."--</option>" !!}
                                                <option value="1">{{trans('meta.print_style_1')}}</option>

                                            </select>
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

@endsection
