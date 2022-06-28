@extends ('core.layouts.app')

@section ('title', trans('labels.backend.tasks.management') . ' | ' . trans('labels.backend.tasks.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.tasks.management') }}
        <small>{{ trans('labels.backend.tasks.edit') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.tasks.edit') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.projects.tasks.partials.tasks-header-buttons')
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
                                    {{ Form::model($tasks, ['route' => ['biller.tasks.update', $tasks], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-task']) }}

                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        @include("focus.projects.tasks.form")
                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.tasks.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                            {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                            <div class="clearfix"></div>
                                        </div><!--edit-form-btn-->
                                    </div><!--form-group-->

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
@section('after-styles')
    {{ Html::style('core/app-assets/css-'.visual().'/pages/app-todo.css') }}
    {{ Html::style('core/app-assets/css-'.visual().'/plugins/forms/checkboxes-radios.css') }}
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}
@endsection
@section('after-scripts')
    {{ Html::script('focus/js/select2.min.js') }}
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}
    <script type="text/javascript">

        (function (window, document, $) {
            'use strict';


            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('.from_date').datepicker('setDate', '{{dateFormat($tasks->start)}}');
            $('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
            $('.to_date').datepicker('setDate', '{{dateFormat($tasks->duedate)}}');
            $('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
            $("#tags").select2();
            $("#employee").select2();
            $("#projects").select2();
            $('#color_t').colorpicker();

        })(window, document, jQuery);


    </script>
@endsection