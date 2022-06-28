@extends ('core.layouts.app')
@section ('title', trans('meta.not_applicable'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('meta.not_applicable') }}</h4>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>{{trans('meta.not_applicable_info')}}</h4>


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
