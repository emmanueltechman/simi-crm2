@extends ('core.layouts.app')
@section ('title', trans('update.about_system'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('update.about_system') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-block"><h6>{{trans('update.about_system')}}  </h6>

                            <hr>
                            <h3>Rose Business Suite</h3>
                            <hr>
                            <h6>{{trans('update.current_version')}} {{$version['version']}} / <small>
                                    Build: {{$version['build']}} </small></h6>
                            <hr>
                            <h6><small>&copy; {{date('Y')}} - ultimatekode.com </small>@if(single_ton()) <a
                                        class="btn btn-purple btn-sm" href="{{route('biller.server_info')}}"><i
                                            class="fa fa-server"></i> PHP Info</a>@endif</h6>


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{ Html::script('focus/js/loading-bar.js') }}
    <script>
        $(document).on('click', "#download_update", function (e) {
            e.preventDefault();
            var bar1 = new ldBar("#ldBar");

            setInterval(function () {
                bar1.set(Math.floor((Math.random() * 70) + 30));
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.download_update')}}',
                dataType: 'html',
                method: 'POST',
                data: {
                    'v': '5'
                },
                success: function (data) {
                    $('#step1').html(data);
                    var bar1 = new ldBar("#ldBar2");
                    bar1.set(100);
                    //     $('#step1').hide();
                    $('#step2').show();
                }
            });

        });


    </script>

@endsection
