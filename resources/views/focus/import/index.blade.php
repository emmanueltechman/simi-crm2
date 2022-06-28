@extends ('core.layouts.app')
@section ('title', trans('import.import'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('features.import') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>{{$words['title']}}</h4>

                            <hr>
                            <p class="alert alert-light mb-3">{{trans('import.as_per_template')}}. <a
                                        href="{{route('biller.import.sample',[$words['template_path'].'.csv'])}}"
                                        target="_blank"><strong>{{trans('import.download_template')}}</strong>
                                    ({{$words['title']}})</a>. </p>
                            <p><strong class="mb-2">File : csv, xls or xlsx</strong></p>
                            @include('focus.import.partials.'.$words['template_path'])


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
