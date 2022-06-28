@extends ('core.layouts.app')

@section ('title', trans('labels.backend.projects.management') . ' | ' . trans('labels.backend.projects.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.projects.management') }}
        <small>{{ trans('labels.backend.projects.edit') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.projects.edit') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.projects.partials.projects-header-buttons')
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
                                    {{ Form::model($projects, ['route' => ['biller.projects.update', $projects], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-project']) }}

                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        @include("focus.projects.form")
                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.projects.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
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
    {!! Html::style('focus/css/bootstrap-colorpicker.min.css') !!}
@endsection
@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    {{ Html::script('core/app-assets/vendors/js/extensions/moment.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/fullcalendar.min.js') }}
    {{ Html::script('core/app-assets/vendors/js/extensions/dragula.min.js') }}
    {{ Html::script('core/app-assets/js/scripts/pages/app-todo.js') }}
    {{ Html::script('focus/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('focus/js/select2.min.js') }}
    <script>
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: '{{config('core.user_date_format')}}'
        });
        $('.from_date').datepicker('setDate', '{{dateFormat($projects->start_date)}}');
        $('.from_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
        $('.to_date').datepicker('setDate', '{{dateFormat($projects->end_date)}}');
        $('.to_date').datepicker({autoHide: true, format: '{{date(config('core.user_date_format'))}}'});
        $("#tags").select2();
        $("#employee").select2();
          $("#person").select2({
                tags: [],
                ajax: {
                    url: '{{route('biller.customers.select')}}',
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 50,
                    data: function (person) {
                        return {
                            person: person
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        $('#color').colorpicker();
    </script>
@endsection
