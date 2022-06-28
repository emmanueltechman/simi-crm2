@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management') . ' | ' . trans('labels.backend.hrms.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.hrms.management') }}
        <small>{{ trans('labels.backend.hrms.edit') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.hrms.edit') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    {{ Form::model($hrms, ['route' => ['biller.edit_profile_post', $hrms], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'id' => 'edit-hrm','files' => true]) }}

                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        <div class="card-content">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="base-tab1" data-toggle="tab"
                                                           aria-controls="tab1" href="#tab1" role="tab"
                                                           aria-selected="true">{{trans('hrms.employee_details')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="base-tab2" data-toggle="tab"
                                                           aria-controls="tab2" href="#tab2" role="tab"
                                                           aria-selected="false">{{trans('hrms.profile')}}</a>
                                                    </li>


                                                </ul>
                                                <div class="tab-content px-1 pt-1">
                                                    <div class="tab-pane active" id="tab1" role="tabpanel"
                                                         aria-labelledby="base-tab1">

                                                        <div class='form-group'>
                                                            {{ Form::label( 'first_name', trans('hrms.first_name'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('first_name', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.first_name').'*','required'=>'required']) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'last_name', trans('hrms.last_name'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('last_name', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.last_name').'*','required'=>'required']) }}
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            {{ Form::label( 'email', trans('hrms.email'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('email', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.email').'*','readonly'=>'readonly']) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'password', trans('hrms.password'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>


                                                                @if(@$hrms->id)
                                                                    {{ Form::text('password', '', ['class' => 'form-control round', 'placeholder' => trans('hrms.password'),'id'=>'u_password'.'*']) }}
                                                                    <small>{{trans('hrms.blank_field')}}</small>
                                                                @else
                                                                    {{ Form::text('password', '', ['class' => 'form-control round', 'placeholder' => trans('hrms.password'),'id'=>'u_password'.'*','required'=>'required']) }}
                                                                @endif
                                                            </div>
                                                            <div id="errors" class="alert round p-1"></div>
                                                        </div>

                                                        <div class='form-group hide_picture'>
                                                            {{ Form::label( 'picture', trans('hrms.picture'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {!! Form::file('picture', array('class'=>'input' )) !!}  @if(@$hrms->id)
                                                                    <small>{{trans('hrms.blank_field')}}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class='form-group hide_picture'>
                                                            {{ Form::label( 'signature', trans('hrms.signature'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {!! Form::file('signature', array('class'=>'input' )) !!}  @if(@$hrms->id)
                                                                    <small>{{trans('hrms.blank_field')}}</small>
                                                                @endif
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane" id="tab2" role="tabpanel"
                                                         aria-labelledby="base-tab2">
                                                        <div class='form-group'>
                                                            {{ Form::label( 'contact', trans('hrms.phone'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('contact', @$hrms->profile['contact'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.phone')]) }}
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            {{ Form::label( 'company', trans('hrms.company'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('company', @$hrms->profile['company'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.company')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'address', trans('hrms.address_1'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('address_1', @$hrms->profile['address_1'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.address_1')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'city', trans('hrms.city'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('city', @$hrms->profile['city'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.city')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'state', trans('hrms.state'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('state', @$hrms->profile['state'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.state')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'country', trans('hrms.country'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('country', @$hrms->profile['country'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.country')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'postal', trans('hrms.postal'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('postal', @$hrms->profile['postal'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.postal')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'tax_id', trans('hrms.tax_id'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('tax_id', @$hrms->profile['tax_id'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.tax_id')]) }}
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.hrms.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                            {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                            <div class="clearfix"></div>
                                        </div><!--edit-form-btn-->
                                    </div><!--form-group-->

                                    {{ Form::close() }}
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    {{ Html::script('focus/js/jquery.password-validation.js') }}
    <script>
        $(document).ready(function () {
            $("#u_password").passwordValidation({
                minLength: 6,
                minUpperCase: 1,
                minLowerCase: 1,
                minDigits: 1,
                minSpecial: 1,
                maxRepeats: 5,
                maxConsecutive: 3,
                noUpper: false,
                noLower: false,
                noDigit: false,
                noSpecial: false,
                failRepeats: true,
                failConsecutive: true,
                confirmField: undefined
            }, function (element, valid, match, failedCases) {

                $("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");

                if (valid) $(element).css("border", "2px solid green");
                if (!valid) {
                    $(element).css("border", "2px solid red");
                    $("#e_btn").prop('disabled', true);
                }
                if (valid && match) {
                    $("#u_password").css("border", "2px solid green");
                    $("#e_btn").prop('disabled', false);
                }
                if (!valid || !match) $("#u_password").css("border", "2px solid red");
            });
        });


    </script>
@endsection
