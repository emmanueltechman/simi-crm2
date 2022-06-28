@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')


    <h5 style="color: green" class="text-center">
        <i class="status fa fa-check-circle-o"> </i> <span
        >Congratulation! You have successfully installed.</span>

    </h5>


    <p class="text-center">
        <strong><strong class="text-danger">Note</strong>: Please read the help/troubleshoot_guide , public tickets on
            the helpdesk before
            sending any support request.</strong>
    </p>
    <p class="text-center">
        <strong><span style="color: green;">Tip</span>: Please check the .env to change configuration and set email
            config. If you are not able to see it, enable the show hidden dot(.) files in your file manager's
            settings</strong>
    </p>

    <p class="text-center">
        <strong><strong class="text-danger" style="color: purple;">Info: </strong><span style="color: red;" >{{$ln}}</span></strong>
    </p>
    <a class="go-to-login-page" href="{{ url('/') }}">
        <div class="text-center">
            <div style="font-size: 100px;"><i class="fa fa-desktop"></i></div>
            <div>GO TO YOUR LOGIN PAGE</div>
        </div>
    </a>
    <div class="text-center" style="margin: 15px 0 15px 60px; font-size: 16px">
        <p>
            Login ID is your entered email and default password is 123456.
        </p>
    </div>


    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer_messages.final.exit') }}</a>
    </div>

@endsection
