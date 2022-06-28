@extends('core.layouts.public_app',['page'=>'class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column   blank-page blank-page" data-open="click" data-menu="horizontal-menu" data-col="1-column" '])

@section('content')
    <div class="app-content container center-layout mt-2">
        <div class="content-wrapper">
            <div class="content-header row">

            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                <div class="card-header border-0 pb-0">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <div class="card-title text-center">
                                        <img class="avatar-100"
                                             src="{{ Storage::disk('public')->url('app/public/img/company/' . business()['logo']) }}"
                                             alt="Logo">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>{{ trans('labels.frontend.passwords.reset_password_box_title') }}</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        {{ Form::open($form) }}
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        {{ Form::input('hidden', 'email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}

                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="email" class="form-control form-control-lg" id="user-email"
                                                   placeholder="{{ trans('validation.attributes.frontend.register-user.email')}}"
                                                   value="{{$email}}" readonly>
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-md-12 control-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                                            </div><!--col-md-6-->
                                        </div><!--form-group-->

                                        <div class="form-group">
                                            {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.password_confirmation'), ['class' => 'col-md-12 control-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password_confirmation')]) }}
                                            </div><!--col-md-6-->
                                        </div><!--form-group-->

                                        {{ Form::submit(trans('labels.frontend.passwords.reset_password_button'), ['class' => 'btn btn-outline-primary btn-lg btn-block']) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <p class="text-center"><a href="{{route('biller.index')}}"
                                                              class="card-link">{{trans('navs.frontend.login')}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
