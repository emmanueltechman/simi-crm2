@php
    use Illuminate\Support\Facades\Route;
@endphp
        <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="{{visual()}}">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Rose Billing')">

    @yield('meta')
    <title>@yield('title', app_name())</title>
    <link rel="shortcut icon" type="image/x-icon"
          href="{{ Storage::disk('public')->url('app/public/img/company/ico/' . config('core.icon')) }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <script type="text/javascript">
        var baseurl = '{{route('biller.index')}}/';
        var asset_url = '{{Storage::disk('public')->url('app/public/')}}';
        var crsf_token = 'csrf-token';
        var crsf_hash = '{{ csrf_token() }}';
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        var unit_load_data ={!!units() !!};
        var cur_dy='{{config('currency.symbol')}}';
    </script>
    <!-- BEGIN: Vendor CSS-->
    {{ Html::style(mix('focus/app_end-'.visual().'.css')) }}
    {!! Html::style('core/app-assets/css-'.visual().'/core/menu/menu-types/horizontal-menu.css') !!}
    {!! Html::style('core/app-assets/vendors/css/forms/icheck/icheck.css') !!}
    {!! Html::style('core/app-assets/vendors/css/forms/icheck/custom.css') !!}
    <style type="text/css">.header-navbar.navbar-brand-center .navbar-header {
            position: relative
        }</style>
@yield('after-styles')

<!-- BEGIN: Custom CSS-->
{!! Html::style('core/assets/css/style-'.visual().'.css') !!}
<!-- END: Custom CSS-->
    <meta name="d_unit" content="{{trans('productvariables.unit_default')}}">
</head>@if(isset($page))
    <body {!!$page !!} > @else
        <body class="horizontal-layout horizontal-menu 2-columns" data-open="click" data-menu="horizontal-menu"
              data-col="2-columns"> @endif

        <!-- BEGIN: Header-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link open-navbar-container"
                                                                              data-toggle="collapse"
                                                                              data-target="#navbar-mobile"><i
                                        class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item d-md-none "><a class="navbar-brand"
                                                           href="{{route('biller.dashboard')}}"><img
                                        class="brand-logo"
                                        alt="Brand Logo"
                                        src="{{ Storage::disk('public')->url('app/public/img/company/theme/' . config('core.theme_logo')) }}">

                            </a></li>
                        <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                          data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-container content">
                    <div class="collapse navbar-collapse" id="navbar-mobile">
                        <ul class="nav navbar-nav mr-auto float-left">


                            <li class="nav-item">
                                <a href="{{route('biller.index')}}" class="btn btn-blue-grey round mt_6 "
                                   title="{{trans('dashboard.dashboard')}}">&nbsp;<i class="ficon ft-home"></i></a></li>&nbsp;
                            <li class="nav-item"><a class="btn btn-success round mt_6" onclick="loadRegister();"
                                                    title="{{trans('pos.register')}}">&nbsp;<i
                                            class="icon-drawer font-medium-1"></i></a></li>&nbsp;
                            <li class="nav-item"><a href="{{route('biller.invoices.pos')}}"
                                                    class="btn btn-blue-grey round mt_6"
                                                    title="{{trans('invoices.create')}}">&nbsp; <i
                                            class="fa fa-plus-circle font-medium-1"></i></a></li>
                        </ul>

                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-notification nav-item"><a class="btn btn-info mt_6 round"
                                                                                   data-toggle="modal"
                                                                                   data-target="#close_register"
                                                                                   title="{{trans('pos.register_close')}}">&nbsp;<i
                                            class="icon-close"></i></a>

                            </li>

                            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                                                                   href="#"
                                                                                   data-toggle="dropdown"
                                                                                   onclick="loadNotifications()"><i
                                            class="ficon ft-bell"></i><span
                                            class="badge badge-pill badge-danger badge-up"
                                            id="n_count">{{ auth()->user()->unreadNotifications->count() }}</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"
                                    id="user_notifications">

                                </ul>
                            </li>
                            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                                                                   href="#"
                                                                                   data-toggle="dropdown">@if(session('clock', false))
                                        <i
                                                class="ficon ft-clock spinner"></i>
                                        <span
                                                class="badge badge-pill badge-info badge-up">{{trans('general.on') }}</span>
                                    @else
                                        <i
                                                class="ficon ft-clock"></i>
                                        <span
                                                class="badge badge-pill badge-danger badge-up"> {{trans('general.off') }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                                    <li class="scrollable-container media-list">
                                        <div class="media">

                                            <div class="media-body text-center">
                                                @if(!session('clock', false)) <a href="{{route('biller.clock')}}"
                                                                                 class="btn btn-success"><i
                                                            class="ficon ft-clock spinner"></i> {{trans('hrms.clock_in') }}
                                                </a>
                                                @else
                                                    <a href="{{route('biller.clock')}}" class="btn btn-secondary"><i
                                                                class="ficon ft-clock"></i> {{trans('hrms.clock_out') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </li>

                            <li class="dropdown dropdown-user nav-item"><a
                                        class="dropdown-toggle nav-link dropdown-user-link"
                                        href="#" data-toggle="dropdown"><span
                                            class="avatar avatar-online"><img
                                                src="{{ Storage::disk('public')->url('app/public/img/users/' . @$logged_in_user->picture) }}"
                                                alt=""><i></i></span><span
                                            class="user-name">{{ $logged_in_user->name }}</span></a>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                                  href="{{ route('biller.profile') }}"><i
                                                class="ft-user"></i> {{ trans('navs.frontend.user.account')}}</a><a
                                            class="dropdown-item" href="{{route('biller.messages')}}"><i
                                                class="ft-mail"></i> My
                                        Inbox</a><a
                                            class="dropdown-item" href="{{route('biller.todo')}}"><i
                                                class="ft-check-square"></i>
                                        {{ trans('general.tasks')}}</a><a
                                            class="dropdown-item" href="{{route('biller.attendance')}}"><i
                                                class="ft-activity"></i>
                                        {{ trans('hrms.attendance')}}</a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('biller.logout') }}"><i
                                                class="ft-power"></i> {{  trans('navs.general.logout') }}</a>


                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- END: Header-->
        <div id="c_body"></div>
        <div>
            @yield('content')
        </div>
        {{ Html::script(mix('js/app_end.js')) }}
        {{ Html::script('focus/js/control.js') }}
        {{ Html::script('focus/js/custom.js') }}
        {{ Html::script('focus/js/printThis.js') }}
        <script type='text/javascript'>
            accounting.settings = {
                number: {
                    precision: '{{config('currency.precision_point')}}',
                    thousand: '{{config('currency.thousand_sep')}}',
                    decimal: '{{config('currency.decimal_sep')}}'
                }
            };
            var two_fixed ={{config('currency.precision_point')}};
            var currency = '{{config('currency.symbol')}}';
            load_pos_config();
            setTimeout(function () {
                load_pos();
                $("#p_loader").remove();
            }, 1000);
        </script>
        @yield('after-scripts')
        @yield('extra-scripts')

        </body>
</html>
