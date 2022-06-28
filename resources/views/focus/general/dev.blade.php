@extends ('core.layouts.app')
@section ('title', trans('currencies.currency_exchange'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.business.dev_manager_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">Troubleshoot Section</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                               <p>The section is designed to troubleshoot the app, not fore general purpose user. </p>

                                    <div class='row mb-1'>
                                        {{ Form::label( 'dev_mode', 'Development Mode',['class' => 'col-12 control-label']) }}
                                        <div class='col-6'>
                                            <select class="form-control round" name="dev_mode">
                                                  @if(config('app.debug')))<option value="1" selected>--Dev Mode is enabled--</option>@endif
                                                      <option value="0" >{{trans('general.no')}}</option>
                                                <option value="1">{{trans('general.yes')}}</option>

                                            </select>
                                        </div>
                                    </div>

                   <div class='row mb-1'>
                                        {{ Form::label( 'create_link', 'Create Link',['class' => 'col-12 control-label']) }}
                                        <div class='col-6'>
                                            <select class="form-control round" name="create_link">
   <option value="0" selected>{{trans('general.no')}}</option>
                                                <option value="1">{{trans('general.yes')}}</option>

                                            </select>
                                        </div>
                                    </div>
     <div class="row form-group">
                                                {{ Form::label('from_path', 'Original Link', ['class' => 'col-lg-12 control-label required']) }}

                                                <div class="col-lg-10">
                                                    {{ Form::text('from_path', storage_path(), ['class' => 'form-control box-size', 'placeholder' =>'Original Path', 'required' => 'required']) }}
                                                </div><!--col-lg-10-->
                                            </div><!--form control-->


                                     <div class="row form-group">
                                                {{ Form::label('to_path', 'Target Link Path', ['class' => 'col-lg-12 control-label required']) }}

                                                <div class="col-lg-10">
                                                    {{ Form::text('to_path', public_path().'/storage', ['class' => 'form-control box-size', 'placeholder' =>'Target Path', 'required' => 'required']) }}
                                                </div><!--col-lg-10-->
                                            </div><!--form control-->

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
    </div>
@endsection
