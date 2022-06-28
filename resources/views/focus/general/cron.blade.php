@extends ('core.layouts.app')
@section ('title', trans('meta.cron_info'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('meta.cron') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>{{trans('meta.cron_info')}}</h4>

                            <hr>
                            <p>The software utility Cron is a time-based job scheduler. People who set up and maintain
                                automated application task use cron to schedule jobs to run periodically at fixed times,
                                dates, or intervals. Recommended cron job scheduling is in midnight.</p>
                            <br> {{ Form::open(['route' => 'biller.cron_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}
                            <input type="hidden" name="update" value="1">
                            <button class="btn btn-primary btn-md rounded"><i class="fa fa-refresh"></i> Update
                                Cron Token
                            </button>

                            {{ Form::close() }}
                            <p></p> Cron Token
                            <h4 class="text-gray-dark">{{$key['value2']}}</h4>


                            @foreach($urls as $row)
                                <hr>
                                <a
                                        data-toggle="collapse" href="#accordion_{{$row['id']}}"
                                        aria-expanded="false" aria-controls="accordion_{{$row['id']}}"
                                        class="{{$row['btn']}} card-title font-size-large  collapsed"><i
                                            class="fa fa-plus-circle"></i> {{$row['title']}}</a>

                                <div id="accordion_{{$row['id']}}" role="tabpanel"
                                     class="card-collapse collapse mt-1">
                                    <pre class="card-block card">wget {{$row['url']}}</pre>
                                    <pre class="card-block card">get {{$row['url']}}</pre>
                                    <pre class="card-block card">curl {{$row['url']}}</pre>


                                </div>
                            @endforeach


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
