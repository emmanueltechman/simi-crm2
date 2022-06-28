@extends ('core.layouts.app')
@section ('title', $lang['title'] . ' | ' .trans('features.reports'))
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
                        @if(isset($lang['calculate']))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert">x</a>

                                <div class="message">{!!$lang['calculate']!!}</div>
                            </div>
                        @endif
                        <div class="card-body">
                            {{ Form::open(['route' => array('biller.reports.summary_post',$lang['module']), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'statement']) }}


                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate">{{trans('meta.from_date')}}</label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control from_date required"
                                           placeholder="Start Date" name="from_date"
                                           autocomplete="false" data-toggle="datepicker">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="edate">{{trans('meta.to_date')}}</label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control required to_date"
                                           placeholder="End Date" name="to_date"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="View">
                                    <input type="hidden" name="calculate" value="yes">
                                </div>
                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });
        $('.from_date').datepicker('setDate', '{{dateFormat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))))}}');
        $('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
        $('.to_date').datepicker('setDate', 'today');
        $('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
    </script>
@endsection
