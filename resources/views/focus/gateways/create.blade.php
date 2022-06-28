@extends ('core.layouts.app')
@section ('title', trans('labels.backend.usergatewayentries.management') . ' | ' . trans('labels.backend.usergatewayentries.create'))
@section('page-header')
    <h1>
        {{ trans('labels.backend.usergatewayentries.management') }}
        <small>{{ trans('labels.backend.usergatewayentries.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.usergatewayentries.create') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.gateways.partials.usergatewayentries-header-buttons')
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
                                    {{ Form::open(['route' => 'biller.usergatewayentries.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-usergatewayentry']) }}


                                    <div class='form-group'>
                                        {{ Form::label( 'enable', trans('usergatewayentries.gateway'),['class' => 'col-lg-2 control-label']) }}
                                        <div class='col-lg-10'>
                                            <select class="form-control round" name="user_gateway_id"
                                                    id="user_gateway_id">
                                                @foreach($gateways as $gateway)
                                                    @if(!@$gateway->config['id'])
                                                        <option value="{{@$gateway['id']}}">{{@$gateway['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Including Form blade file --}}
                                    @include("focus.gateways.form")
                                    <div class="edit-form-btn">
                                        {{ link_to_route('biller.usergatewayentries.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                                        <div class="clearfix"></div>
                                    </div><!--edit-form-btn-->


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

