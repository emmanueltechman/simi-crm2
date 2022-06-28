@extends('general.layout.app')
@section('menu')
    @include('general.partial.menu',array('home'=>route('main.home')))
@endsection
@section('content')
    <header id="header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>&nbsp;</h3>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->

    <div>

        @if(session('flash_success'))
            <div class="alert bg-warning alert-dismissible m-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong> {!!session('flash_success')!!}
            </div>

        @endif
        @if(session('flash_error'))
            <div class="alert bg-danger alert-dismissible m-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Error!</strong> {!!session('flash_error')!!}
            </div>
        @endif


        <div>
            <div class="container">
                <div class="row">
                    <button title="Close (Esc)" type="button" class="mfp-close x-button">×</button>
                    <div class="col-lg-6">
                        <div class="image-container">
                            <img class="img-fluid"
                                 src="{{Storage::disk('public')->url('app/public/img/general/login.svg')}}"
                                 alt="alternative">
                        </div> <!-- end of image-container -->
                    </div> <!-- end of col -->
                    <div class="col-lg-6"><h3 class="text-center mb-3">{{trans('navs.frontend.login')}}</h3>
                        {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form-horizontal']) }}

                        <div class="form-group">
                            {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-4 control-label']) }}
                            <div class="col">
                                {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                            </div><!--col-md-6-->
                        </div><!--form-group-->

                        <div class="form-group">
                            {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-md-4 control-label']) }}
                            <div class="col">
                                {{ Form::input('password', 'passwordc', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                            </div><!--col-md-6-->
                        </div><!--form-group-->
                        @if($errors->first('email'))
                            <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{$errors->first('email')}}
                            </div>@endif
                        <div class="form-group">
                            <div class="col">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                                    </label>
                                </div>
                            </div><!--col-md-6-->
                        </div><!--form-group-->
                        @if(config('master.captcha'))
                            <input type="hidden" value="true" name="captcha_status">
                            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">


                                <div class="col">
                                    {!! app('captcha')->display() !!}

                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
</span>
                                    @endif

                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="col">
                                {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn-solid-reg', 'style' => 'margin-right:15px']) }}
                                {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }}
                            </div><!--col-md-6-->
                        </div><!--form-group-->

                        {{ Form::close() }}

                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of popup -->


    </div><!-- panel -->

    </div>




@endsection
@section('after-scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function () {
            $('.popup-with-move-anim').trigger('click');
        });
    </script>
@endsection