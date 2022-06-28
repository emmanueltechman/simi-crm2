@extends ('core.layouts.app')

@section ('title', trans('labels.backend.customergroups.management') . ' | ' . trans('labels.backend.customergroups.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.customergroups.management') }}
        <small>{{ trans('labels.backend.customergroups.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3>{{ trans('labels.backend.customergroups.create') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.customergroups.partials.customergroups-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card round">

                            <div class="card-content">

                                <div class="card-body">
                                    {{ Form::open(['route' => 'biller.customergroups.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-customergroup']) }}
                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        @include("focus.customergroups.form")
                                        <div class="edit-form-btn m-2">
                                            {{ link_to_route('biller.customergroups.index', trans('general.cancel'), [], ['class' => 'btn btn-danger btn-md round']) }}
                                            {{ Form::submit(trans('general.create'), ['class' => 'btn btn-success btn-md round']) }}
                                            <div class="clearfix"></div>
                                        </div><!--edit-form-btn-->
                                    </div><!-- form-group -->

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
