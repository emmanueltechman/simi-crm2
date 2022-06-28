@php
    use Illuminate\Support\Facades\Route;
@endphp
        <!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Geo')">
    @yield('meta')
    <title>@yield('title', app_name())</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <script type="text/javascript">
        var baseurl = '{{route('biller.index')}}/';
        var crsf_token = 'csrf-token';
        var crsf_hash = '{{ csrf_token() }}';
        window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};

    </script>
    <!-- BEGIN: Vendor CSS-->
{{ Html::style(mix('focus/app_end-'.visual().'.css')) }}
<!-- END: Vendor CSS-->




@yield('after-styles')

<!-- BEGIN: Custom CSS-->
{!! Html::style('core/assets/css/style'.visual().'.css') !!}
<!-- END: Custom CSS-->
</head>@if(isset($page))
    <body {!!$page !!} > @else
        <body class="horizontal-layout horizontal-menu 2-columns  " data-open="click" data-menu="horizontal-menu"
              data-col="2-columns"> @endif

        <div id="c_body"></div>
        @if(session('flash_success'))
            <div class="alert bg-success alert-dismissible m-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong> {{session('flash_success')}}
            </div>

        @endif
        @yield('content')

        {{ Html::script('core/app-assets/vendors/js/vendors.min.js') }}


        @yield('after-scripts')
        @yield('extra-scripts')
        </body>
</html>
