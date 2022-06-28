@extends ('core.layouts.app')
@section ('title', 'Super Admin Installer')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">Super Admin Installer</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>Application Upgrade Wizard</h4>

                            <hr>


                            <span id="ldBar2" class="text-center" style="width:100%;height:30px"></span>
                            <p id="step1"><span id="ldBar" class="text-center" style="width:100%;height:30px"></span>


                            <div class="row" id="trs">
                                <div class="col-md-6">
                                    <input type="text" id="code" name="code" class="form-control "
                                           placeholder="Purchase Code"></div>
                                <div class="col-md-6">
                                    <button type="button"
                                            class="update_chart btn btn-primary btn-min-width mr-1 mb-1"
                                            id="download_update"><i class="fa fa-download"></i>
                                        &nbsp;Upgrade
                                    </button>
                                </div>
                            </div>
                            <p>
                                <span id="insldBar2" class="text-center" style="width:100%;height:30px"></span>
                            </p>
                            <hr>
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
                url: '{{route('biller.super_update')}}',
                dataType: 'html',
                method: 'POST',
                data: 'v=5&c=' + $('#code').val(),
                success: function (data) {
                    $('#step1').html(data);
                    var bar1 = new ldBar("#ldBar2");
                    bar1.set(100);
                    $('#trs').remove();
                    $('#step2').show();
                }
            });

        });

        $(document).on('click', "#install_update", function (e) {
            e.preventDefault();
            $('#ldBar2').html('');

            var bar1 = new ldBar("#insldBar");

            setInterval(function () {
                bar1.set(Math.floor((Math.random() * 70) + 30));
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.install_update')}}',
                dataType: 'html',
                method: 'POST',
                data: {'v': 5},
                success: function (data) {
                    $('#step2').html(data);
                    var bar1 = new ldBar("#insldBar2");
                    bar1.set(100);
                    //    $('#step2').hide();
                    $('#step3').show();
                }
            });

        });
        $(document).on('click', "#db_update", function (e) {
            e.preventDefault();
            $('#ldBar2').html('');
            $('#insldBar').html('');

            var bar1 = new ldBar("#dbldBar");

            setInterval(function () {
                bar1.set(Math.floor((Math.random() * 70) + 30));
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.update_db')}}',
                dataType: 'html',
                method: 'POST',
                data: {'v': 5},
                success: function (data) {
                    $('#step3').html(data);
                    var bar1 = new ldBar("#dbldBar2");
                    bar1.set(100);
                }
            });

        });
    </script>

@endsection
