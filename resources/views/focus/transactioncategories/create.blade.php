@extends ('core.layouts.app')

@section ('title', trans('labels.backend.transactioncategories.management') . ' | ' . trans('labels.backend.transactioncategories.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.transactioncategories.management') }}
        <small>{{ trans('labels.backend.transactioncategories.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.transactioncategories.create') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.transactioncategories.partials.transactioncategories-header-buttons')
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
                                    {{ Form::open(['route' => 'biller.transactioncategories.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-transactioncategory']) }}


                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        @include("focus.transactioncategories.form")
                                        <div class="edit-form-btn">
                                            {{ link_to_route('biller.transactioncategories.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                            {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
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
