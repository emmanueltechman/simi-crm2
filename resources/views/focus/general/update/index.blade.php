@extends ('core.layouts.app')
@section ('title', trans('update.web_updater'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('update.web_updater') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>{{trans('update.application_update')}}</h4>

                            <hr>
                            <h5>{{trans('update.current_version')}} {{$version['version']}} / <small>
                                    Build: {{$version['build']}} </small></h5>
                            <hr>

                            <span id="ldBar2" class="text-center" style="width:100%;height:30px"></span>
                            <p id="step1"><span id="ldBar" class="text-center" style="width:100%;height:30px"></span>
                                {{trans('update.updater_info')}}
                                <br><br>
                                <button type="button"
                                        class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1"
                                        id="download_update"><i class="fa fa-download"></i>
                                    &nbsp; {{trans('update.step_1')}}
                                </button>

                            </p>


                            <hr>
                            <p>
                                <span id="insldBar2" class="text-center" style="width:100%;height:30px"></span>
                            </p>
                            <p id="step2" style="display:none;"><span id="insldBar" class="text-center"
                                                                      style="width:100%;height:30px"></span><br>
                                <br> {{trans('update.files_downloaded')}} <br><br>
                                <button type="button"
                                        class="update_chart btn btn-success btn-min-width btn-lg mr-1 mb-1"
                                        id="install_update"><i class="fa fa-file-text"></i>
                                    &nbsp; {{trans('update.step_2')}}
                                </button>
                            </p>

                            <hr>

                            <span id="dbldBar2" class="text-center"
                                  style="width:100%;height:30px" ,

                            ></span>
                            <p id="step3" style="display:none;">
            <span id="dbldBar" class="text-center"
                  style="width:100%;height:30px" ,

            ></span><br>
                                <br>Database update available, ready to install.. </br><br>
                                <button type="button"
                                        class="update_chart btn btn-red btn-min-width btn-lg mr-1 mb-1"
                                        id="db_update"><i class="fa fa-stack"></i> &nbsp; 3. Update Database
                                </button>
                            </p>
                        </div>


                    </div>
                </div>

            </div><div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">Application Backup</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>Database Backup</h4>

                            <hr>


                            <span id="ldBar2" class="text-center" style="width:100%;height:30px"></span>
                            <p id="step1"><span id="ldBar" class="text-center" style="width:100%;height:30px"></span>
                             Database Backup will be stored in your_project/storage directory, you should keep backup of entire your_project/storage folder to save images and uploaded file.
                                <br><br>
                                <button type="button"
                                        class="update_chart btn btn-success btn-min-width btn-lg mr-1 mb-1"
                                        id="db_backup"><i class="fa fa-database"></i>
                                    &nbsp; Backup
                                </button>

                            </p>


                            <hr>
                            <p>
                                <span id="OpldBar3" class="text-center" style="width:100%;height:30px"></span>
                            </p>





                        </div>


                    </div>
                </div>

            </div><div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">Application Optimizations</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>Optimize the application performance</h4>

                            <hr>


                            <span id="ldBar2" class="text-center" style="width:100%;height:30px"></span>
                            <p id="step1"><span id="ldBar" class="text-center" style="width:100%;height:30px"></span>
                                You can optimize the app speed (if server has proper support), in some shared hosting accounts, it may crash the application,  data will be safe but you may need to install the application.
                                <br><br>
                                <button type="button"
                                        class="update_chart btn btn-danger btn-min-width btn-lg mr-1 mb-1"
                                        id="optimize"><i class="fa fa-flash"></i>
                                    &nbsp; Optimize
                                </button>

                            </p>


                            <hr>
                            <p>
                                <span id="OpldBar2" class="text-center" style="width:100%;height:30px"></span>
                            </p>





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
                },
                error: function (xhr, status, error) {
                    $('#step1').html(xhr.responseText);
                    var bar1 = new ldBar("#ldBar2");
                    bar1.set(100);

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

            $(document).on('click', "#optimize", function (e) {
            e.preventDefault();
            var bar1 = new ldBar("#OpldBar2");


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.optimize')}}',
                dataType: 'html',
                method: 'POST',
                data: {
                    'v': '5',
                    'type': 'backup'
                },
                success: function (data) {
                    bar1.set(100);
                    $('#optimize_done').show();
                },
                error: function (xhr, status, error) {


                }
            });

        });

        $(document).on('click', "#db_backup", function (e) {
            e.preventDefault();
            var bar1 = new ldBar("#OpldBar3");


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.optimize')}}',
                dataType: 'html',
                method: 'POST',
                data: {
                    'v': '5'
                },
                success: function (data) {
                    bar1.set(100);
                    $('#backup_done').show();
                },
                error: function (xhr, status, error) {


                }
            });

        });
    </script>

@endsection
