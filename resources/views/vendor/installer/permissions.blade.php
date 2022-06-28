@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.permissions.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-key fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.permissions.title') }}
@endsection

@section('container')

    <ul class="list">
        @foreach($permissions['permissions'] as $permission)
            <li class="list__item list__item--permissions {{ $permission['isSet'] ? 'success' : 'error' }}">
                {{ $permission['folder'] }}
                <span>
                @php
                    $flag=true;
                        if($permission['isSet']) {
            echo '<i class="fa fa-fw fa-check-circle-o"></i>'.$permission['permission'];
        } else {
                            $flag=false;
            echo '<i class="fa fa-fw fa-exclamation-circle"></i>'.$permission['permission'];
        }
                @endphp
            </span>
            </li>

        @endforeach
        @if(!$flag)
            <li class="alert alert-danger"> Please set 775 for all sub-directories of storage/app/public manually to
                avoid file upload error.
            </li> @endif
    </ul>

    @if ( ! isset($permissions['errors']))
        <div class="buttons">
            <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="button">
                {{ trans('installer_messages.permissions.next') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection
