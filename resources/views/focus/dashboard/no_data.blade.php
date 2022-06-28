@extends ('core.layouts.app')
@section ('title', config('core.cname'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center purple">~{{config('core.cname')}}~</h1>
                    <hr>
                    <h2 class="text-center">{{trans('strings.backend.welcome')}}</h2>
                    <h3 class="text-center">{{auth()->user()->first_name}}</h3>
                </div>
            </div>

        </div>
    </div>

    <!-- END: Content-->
@endsection
