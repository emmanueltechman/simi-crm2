@extends('core.layouts.public_app',['page'=>' class="horizontal-layout horizontal-menu 2-columns bg-full-screen-image" data-open="click" data-menu="horizontal-menu" data-col="2-columns"'])
@section('icon',business()['icon'])
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"><img class="avatar-100"
                                                              src="{{ Storage::disk('public')->url('app/public/img/company/' . business()['logo']) }}"
                                                              alt="Logo"></div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>{{trans('navs.frontend.login')}}</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="post" class="form-horizontal form-simple"
                                              action="{{route('biller.login')}}" validate>
                                            {!! csrf_field() !!}
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" class="form-control form-control-lg" id="user-name"
                                                       name="email" placeholder="Your Email" required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>

                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg"
                                                       id="user-password" name="password" placeholder="Enter Password"
                                                       required>
                                                <div class="form-control-position">
                                                    <i class="fa fa-key"></i>
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
                                            @if(session('flash_user_error'))
                                                <div class="alert bg-warning alert-dismissible m-1" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    {{session('flash_user_error')}}
                                                </div>
                                            @endif
                                            @if(config('master.captcha'))
                                                <input type="hidden" value="true" name="captcha_status">
                                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                                    <label class="col-md-4 control-label"></label>

                                                    <div class="col-md-6">
                                                        {!! app('captcha')->display() !!}

                                                        @if ($errors->has('g-recaptcha-response'))
                                                            <span class="help-block">
<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group row">
                                                <div class="col-sm-6 col-12 text-center text-sm-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember"
                                                               name="remember">
                                                        <label for="remember-me"> {{ trans('labels.frontend.auth.remember_me') }}</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-sm-6 col-12 text-center text-sm-right"><a
                                                            href="{{route('frontend.auth.password.reset')}}"
                                                            class="card-link">{{trans('labels.frontend.passwords.forgot_password')}}</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                                        class="ft-unlock"></i> {{trans('navs.frontend.login')}}</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="">
                                        <a href="{{route('crm.login')}}"
                                           class="card-link">{{trans('meta.customer_login')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection