@extends('main.layouts.app')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header">
            </div>
            <div class="content-body">
                <section class="container ">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-lg-5 col-md-8 col-10 box-shadow-2 p-0 ">
                                <div class="card border-grey border-lighten-3 ">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <div class="p-1"><br><br><br><img class="card-img-100"
                                                                              src="{{ Storage::disk('public')->url('app/public/img/logo/' . $setting->logo) }}"
                                                                              alt="branding logo"></div>
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                            <span>{{app_name()}} {{ trans('labels.frontend.auth.register_box_title') }}</span>
                                        </h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">


                                            {{ Form::open(['route' => 'frontend.auth.register', 'class' => 'form-horizontal form-simple']) }}
                                            {!! csrf_field() !!}
                                            <fieldset class="form-group position-relative has-icon-left">
                                                {{ Form::input('name', 'first_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}

                                                @if($errors->first('first_name'))
                                                    <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{$errors->first('first_name')}}
                                                    </div>@endif
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left ">
                                                {{ Form::input('name', 'last_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.lastName')]) }}
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                                @if($errors->first('last_name'))
                                                    <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{$errors->first('last_name')}}
                                                    </div>@endif
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left ">
                                                {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                                @if($errors->first('email'))
                                                    <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{$errors->first('email')}}
                                                    </div>@endif
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left ">
                                                {{ Form::input('password', 'password', null, ['id'=>'password','class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                                                <div class="form-control-position">
                                                    <i class="ft-lock"></i>
                                                </div>
                                                <div id="errors"></div>
                                                @if($errors->first('password'))
                                                    <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{$errors->first('password')}}
                                                    </div>@endif
                                            </fieldset>


                                            <fieldset class="form-group position-relative has-icon-left ">
                                                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password_confirmation')]) }}
                                                <div class="form-control-position">
                                                    <i class="ft-lock"></i>
                                                </div>

                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <label class="col-md-12 control-label">
                                                    {!! Form::checkbox('is_term_accept',1,false) !!}
                                                    I
                                                    accept {!! link_to_route('frontend.pages.show', trans('validation.attributes.frontend.register-user.terms_and_conditions').'*', ['slug'=>'terms-and-conditions']) !!} </label>

                                            </fieldset>
                                            @if($errors->first('is_term_accept'))
                                                <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    {{$errors->first('is_term_accept')}}
                                                </div>@endif

                                            @if(config('master.captcha'))
                                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                                    <label class="col-md-4 control-label"></label>

                                                    <div class="col-md-6">
                                                        {!! app('captcha')->display() !!}
<input type="hidden" value="true" name="captcha_status">
                                                        @if ($errors->has('g-recaptcha-response'))
                                                            <span class="help-block">
<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            @endif


                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
                                                    {{ Form::submit(trans('labels.frontend.auth.register_button'), ['class' => 'btn btn-primary','id'=>'e_btn']) }}
                                                </div><!--col-md-6-->
                                            </div><!--form-group-->

                                            {{ Form::close() }}

                                        </div><!-- panel body -->

                                    </div><!-- panel -->

                                </div><!-- col-md-8 -->

                            </div><!-- row --></div><!-- row -->
                    </div>
                </section>
            </div>
        </div>
    </div>
                    @endsection

                    @section('after-scripts')
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        {{ Html::script('focus/js/jquery.password-validation.js') }}

                        <script type="text/javascript">
                            $(document).ready(function () {
                                $("#password").passwordValidation({
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
                                    $("#errors").show();
                                    $("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");

                                    if (valid) $(element).css("border", "2px solid green");
                                    if (!valid) {
                                        $(element).css("border", "2px solid red");
                                        $("#e_btn").prop('disabled', true);
                                    }
                                    if (valid && match) {
                                        $("#password").css("border", "2px solid green");
                                        $("#e_btn").prop('disabled', false);
                                        $("#errors").hide();
                                    }
                                    if (!valid || !match) $("#password").css("border", "2px solid red");
                                });
                            });
                        </script>
@endsection
