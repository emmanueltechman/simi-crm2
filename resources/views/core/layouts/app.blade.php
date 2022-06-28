@php
    use Illuminate\Support\Facades\Route;
$horizon=feature(12)['value2'];
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
          href="{{ Storage::disk('public')->url('app/public/img/company/ico/' . config('core.icon'))}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <script type="text/javascript">
        var baseurl = '{{route('biller.index')}}/';
        var crsf_token = 'csrf-token';
        var crsf_hash = '{{ csrf_token() }}';
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        var unit_load_data ={!!units() !!};
        var cur_dy='{{config('currency.symbol')}}';
    </script>
    <!-- BEGIN: Vendor CSS-->
{{ Html::style(mix('focus/app_end-'.visual().'.css')) }}
@if(($horizon=='v'))
    {!! Html::style('core/app-assets/css-'.visual().'/core/menu/menu-types/vertical-menu-modern.css') !!}
@else
    {!! Html::style('core/app-assets/css-'.visual().'/core/menu/menu-types/horizontal-menu.css') !!}
@endif
{!! Html::style('core/app-assets/vendors/css/forms/icheck/icheck.css') !!}
{!! Html::style('core/app-assets/vendors/css/forms/icheck/custom.css') !!}
@yield('after-styles')
<!-- END: Vendor CSS-->
    <!-- BEGIN: Custom CSS-->
{!! Html::style('core/assets/css/style-'.visual().'.css') !!}
<!-- END: Custom CSS-->
    <meta name="d_unit" content="{{trans('productvariables.unit_default')}}">
</head>
<!-- END: Head-->

@if(isset($page))
    <body {!!$page !!} >
    @if ($logged_in_user)
        @include('core.partials.menu')
    @endif
@else
@if($horizon=='v')
            <body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

            @if ($logged_in_user)
                @include('core.partials.menu_vertical')
            @endif


            @else
                <body class="horizontal-layout horizontal-menu 2-columns " data-open="click" data-menu="horizontal-menu"
                      data-col="2-columns">

                @if ($logged_in_user)
                    @include('core.partials.menu')
                @endif




        @endif




                @endif



        <div class="app-content content">
            <div id="c_body"></div>
            @if(session('flash_success'))
                <div class="alert bg-success alert-dismissible m-1" role="alert">
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
            @if($errors->any())
                <div class="alert bg-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {!! implode('', $errors->all('<div>:message</div>'))  !!}
                </div>
            @endif
            @yield('content')
        </div>
        {{ Html::script(mix('js/app_end.js')) }}
        {{ Html::script('focus/js/control.js?b='.config('version.build')) }}
        {{ Html::script('focus/js/custom.js?b='.config('version.build')) }}
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

            function editor() {
                $('.html_editor').summernote({
                    height: 60,
                    tooltip: false,
                    toolbar: [
                        {!! config('general.editor') !!}
                    ],
                    popover: {}

                });
            }
        </script>
        @yield('after-scripts')
        @yield('extra-scripts')

        </body>
</html>
