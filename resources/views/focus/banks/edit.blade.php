@extends ('core.layouts.app')

@section ('title', trans('labels.backend.banks.management') . ' | ' . trans('labels.backend.banks.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.banks.management') }}
        <small>{{ trans('labels.backend.banks.edit') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.banks.edit') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.banks.partials.banks-header-buttons')
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
                                    {{ Form::model($banks, ['route' => ['biller.banks.update', $banks], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-bank']) }}

                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        @include("focus.banks.form")
                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.banks.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
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
