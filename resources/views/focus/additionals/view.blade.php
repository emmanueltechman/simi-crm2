@extends ('core.layouts.app')

@section ('title', trans('labels.backend.additionals.management') . ' | ' . trans('labels.backend.additionals.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.additionals.management') }}
        <small>{{ trans('labels.backend.additionals.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ trans('labels.backend.additionals.view') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.additionals.partials.additionals-header-buttons')
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


                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('additionals.name')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$additional['name']}}</p>
                                        </div>
                                    </div>
                                    @if($additional['class']==1)
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{trans('additionals.value')}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>{{numberFormat($additional['value'])}}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('additionals.class')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>@php
                                                    switch ($additional['class']){
                                                    case 1 : echo trans('general.tax');
                                                    break;
                                                    case 2  : echo trans('general.discount');
                                                     break;
                                                    }
                                                @endphp</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('additionals.type1')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>@php
                                                    switch (@$additional['type1']){
                                                    case '%' : echo  '%';
                                                    break;
                                                    case 'flat' : echo  trans('additionals.flat');
                                                    break;
                                                     case 'b_flat' : echo trans('additionals.b_flat');
                                                    break;
                                                    case 'b_per' : echo  trans('additionals.b_per');
                                                    break;
                                                    }
                                                @endphp</p>
                                        </div>
                                    </div>
                                    @if($additional['class']==1)
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{trans('additionals.type2')}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>@php
                                                        switch (@$additional['type2']){
                                                        case 'inclusive' : echo  trans('additionals.inclusive');
                                                        break;
                                                         case 'exclusive' : echo trans('additionals.exclusive');
                                                        break;
                                                        }
                                                    @endphp</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{trans('additionals.type3')}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>@php
                                                        switch (@$additional['type3']){
                                                        case 'inclusive' : echo  trans('additionals.inclusive');
                                                        break;
                                                         case 'exclusive' : echo trans('additionals.exclusive');
                                                        break;
                                                         case 'cgst' : echo trans('additionals.cgst');
                                                        break;
                                                             case 'igst' : echo trans('additionals.igst');
                                                        break;
                                                        }
                                                    @endphp</p>
                                            </div>
                                        </div>
                                    @endif


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
