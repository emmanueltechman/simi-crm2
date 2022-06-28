@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management') . ' | ' . trans('labels.backend.hrms.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.hrms.management') }}
        <small>{{ trans('hrms.attendance') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('hrms.attendance') }}</h4>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.hrms.partials.att-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    {{ Form::open(['route' => 'biller.hrms.attendance_store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}
                                    <div class="form-group">
                                        @if(isset($payroll))
                                            <input type="hidden" name="payer_type" value="employee">
                                        @endif
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    {{ Form::label( 'payer', trans('hrms.employee'),['class' => 'col-lg-12 control-label']) }}
                                                    <div class="col">
                                                        {{ Form::text('payer', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.employee'),'id'=>'payer','autocomplete'=>'off']) }}</div>
                                                </div>
                                                <div id="payer-box-result" class="offset-4"></div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    {{ Form::label( 'note', trans('general.note'),['class' => 'col-6 control-label']) }}
                                                    <div class='col'>
                                                        {{ Form::text('note', null, ['class' => 'form-control round', 'placeholder' => trans('general.note'),'autocomplete'=>'off']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class='col-md-12'>
                                                <div class='row'>
                                                    <div class='col-3'> {{trans('hrms.attendance_new')}}</div>
                                                    <div class='col-3'>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="text" class="form-control round required"
                                                                   placeholder="{{trans('general.date')}}*"
                                                                   name="att_date"
                                                                   data-toggle="datepicker" required="required">
                                                            <div class="form-control-position"><span
                                                                        class="fa fa-calendar"
                                                                        aria-hidden="true"></span></div>
                                                        </fieldset>
                                                    </div>
                                                    <div class='col-3'><input type="time" name="time_from"
                                                                              class="form-control  round"
                                                                              value="10:00"></div>
                                                    <div class='col-3'><input type="time" name="time_to"
                                                                              class="form-control  round"
                                                                              value="16:00"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.hrms.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                            {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-md','id'=>'e_btn']) }}
                                            <div class="clearfix"></div>
                                        </div><!--edit-form-btn-->
                                    </div><!-- form-group -->
                                    {{ Form::hidden('payer_id', 0, ['id' => 'payer_id']) }}
                                    {{ Form::hidden('relation_id', 0, ['id' => 'relation_id']) }}
                                    {{ Form::close() }}
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section("after-scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
        });

        function selectPayer(data) {
            $('#payer_id').val(data.id);
            $('#relation_id').val(data.relation_id);
            $('#payer').val(data.name);
            $("#payer-box-result").hide();
        }

        $("#payer").keyup(function () {
            if ($(this).val() == '') $("#payer-box-result").hide();
            if ($('input[name=payer_type]:checked').val()) {
                var p_t = $('input[name=payer_type]:checked').val();
            } else {
                var p_t = $('input[name=payer_type]').val();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route('biller.transactions.payer_search')}}',
                data: 'keyword=' + $(this).val() + '&payer_type=' + p_t,
                beforeSend: function () {
                    $("#payer").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#payer-box-result").show();
                    $("#payer-box-result").html(data);
                    $("#payer-box").css("background", "none");

                }
            });
        });
    </script>
@endsection