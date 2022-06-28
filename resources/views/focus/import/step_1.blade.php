@extends ('core.layouts.app')
@section ('title', trans('import.import'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('import.import') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card card-block">
                    <div id="notify" class="alert" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"></div>
                    </div>@if ($response == 1)
                        <div id="ups" class="card-body">
                            <h6>{{ trans('import.import_process_started') }}</h6>
                            <hr>

                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="card card-block">

                        <span id="ldBar" class="ldBar text-center success text-bold-700"
                              style="width:100%;height:80px"></span>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-body"><a class="btn btn-primary btn-lg"
                                                  href="{{route('biller.import.general',[$section])}}">{!!  trans('pagination.previous') !!}</a>
                        </div>
                    @else
                        <div class="card-body">
                            <h6>Import Process Failed! Either you have uploaded an incorrect file format or invalid
                                template for
                                uploading!</h6>
                            <hr>

                            <div class="row sameheight-container">
                                <div class="col-md-12">
                                    <div class="card card-block">

                                        <span id="ldBar" class="ldBar text-xs-center "
                                              style="width:100%;height:30px"></span>

                                    </div>
                                </div>

                            </div>
                            <h6>Import Process Failed! Either you have uploaded an incorrect file format or invalid
                                template for
                                uploading!</h6>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    {{ Html::script('focus/js/loading-bar.js') }}
    @if ($response == 1)
        <script type="text/javascript">
            var bar1 = new ldBar("#ldBar");

            setInterval(function () {
                bar1.set(Math.floor((Math.random() * 70) + 30));
            }, 500);

            setTimeout(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('biller.import.import_process')}}/{{$section}}',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        'name': '{{$file_value}}',
                        @foreach($data as $key  => $row)'{{$key}}': '{{$row}}', @endforeach
                    },
                    success: function (data) {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);

                        $("#ldBar").hide();
                        if (data.status == 'Success') {
                            $("#notify").addClass("alert-info white").fadeIn();
                            $("html, body").scrollTop($("body").offset().top);
                            setTimeout(function () {
                                window.location.href = '{{route('biller.import.general')}}/{{$section}}';
                            }, 2000);
                        } else {
                            $("#notify").addClass("alert-danger white").fadeIn();
                            $("html, body").scrollTop($("body").offset().top);
                        }


                    },
                    error: function (data) {
                        var message = '';
                        $.each(data.responseJSON.errors, function (key, value) {
                            message += value + ' ';
                        });
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + message);
                        $("#notify").removeClass("alert-info").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $("#submit-data").show();
                        $("#ups").hide();
                    }
                });
            }, 2000);

        </script>
    @endif
@endsection