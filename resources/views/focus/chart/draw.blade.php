@extends ('core.layouts.app')
@section ('title',$lang['title'] . ' | ' .trans('features.reports'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h5> {{$lang['title']}}</h5>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <!-- basic buttons -->
                                <button type="button"
                                        class="update_chart btn btn-primary btn-min-width btn-lg mr-1 mb-1"
                                        data-val="week"><i
                                            class="fa fa-clock-o"></i> {{trans('meta.this_week')}}
                                </button>
                                <button type="button"
                                        class="update_chart btn btn-secondary btn-min-width  btn-lg mr-1 mb-1"
                                        data-val="month"><i
                                            class="fa fa-calendar"></i> {{trans('meta.this_month')}}
                                </button>
                                <button type="button"
                                        class="update_chart btn btn-success btn-min-width  btn-lg mr-1 mb-1"
                                        data-val="year"><i
                                            class="fa fa-book"></i> {{trans('meta.this_year')}}
                                </button>
                                <button type="button"
                                        class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1"
                                        data-val="custom"><i
                                            class="fa fa-address-book"></i> {{trans('meta.custom_date_range')}}
                                </button>

                            </div>
                            <form id="chart_custom">
                                <div id="custom_c" style="display: none ">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="basicInput">{{trans('meta.from_date')}}</label>
                                                <input type="text" class="form-control required from_date"
                                                       placeholder="Start Date" name="from_date"
                                                       data-toggle="datepicker" autocomplete="false">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="helpInputTop">{{trans('meta.to_date')}}</label>
                                                <input type="text" class="form-control required to_date"
                                                       placeholder="End Date" name="to_date"
                                                       data-toggle="datepicker" autocomplete="false">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-12 mb-1"><span class="mt-2"><br></span>
                                            <fieldset class="form-group">
                                                <input type="hidden" name="p"
                                                       value="custom">
                                                <button type="button" id="custom_update_chart"
                                                        class="btn btn-blue-grey"
                                                        data-val="custom_r">{{trans('general.view')}}
                                                </button>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <input type="hidden" id="interval" name="interval" value="week">

                                </div>
                            </form>

                            <div class="card-body">
                                <div class="card-block">
                                    <div id="result-chart" height="400"></div>
                                </div>
                            </div>
                            <div class="card-body alert-cyan">{{@$lang['note']}}</div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-styles')
    {!! Html::style('core/app-assets/vendors/css/charts/morris.css') !!}
@endsection

@section('extra-scripts')
    {{ Html::script('focus/js/select2.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/charts/morris.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/charts/raphael-min.js') }}

    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });
        $('.from_date').datepicker('setDate', '{{dateFormat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))))}}');
        $('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
        $('.to_date').datepicker('setDate', 'today');
        $('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});


        @include('focus.chart.'.$lang['module'])

        $(document).on('click', ".update_chart", function (e) {
            e.preventDefault();
            var a_type = $(this).attr('data-val');
            if (a_type == 'custom') {
                $('#custom_c').show();
                $('#interval').val('custom');
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('biller.reports.charts_post',[$lang['module']])}}',
                    dataType: 'json',
                    method: 'POST',
                    data: {
                        'interval': $(this).attr('data-val')

                    },
                    success: function (data) {
                        $('#result-chart').empty();
                        draw_c(data);
                    }
                });
            }
        });


        $(document).on('click', "#custom_update_chart", function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route('biller.reports.charts_post',[$lang['module']])}}',
                dataType: 'json',
                method: 'POST',
                data: $('#chart_custom').serialize(),
                success: function (data) {
                    draw_c(data);
                }
            });
        });

        function draw_cs(cat_data) {
            $('#result-chart').empty();
            Morris.Bar({
                element: 'result-chart',
                data: cat_data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['{{trans('general.amount')}}'],
                barColors: [
                    '#85362b',
                ],
                barFillColors: [
                    '#0089ce',
                ],
                barOpacity: 0.6,
            });
        }
    </script>
@endsection
