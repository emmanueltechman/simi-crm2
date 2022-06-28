@extends ('core.layouts.app')
@section ('title', trans('meta.default_status'))
@section('content')
    <div class="">
        <div class="content-wrapper">

            <div class="content-body "> {{ Form::open(['route' => 'biller.settings.status_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}

                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom-blue-grey">
                                <h4 class="card-title">{{ trans('meta.default_status') }}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {{trans('meta.default_status_info')}}
                                    <div class='row mb-1'>
                                        {{ Form::label( 'default_done_status', trans('meta.default_done_status'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'><a class="red"
                                                                 href="{{route('biller.miscs.create')}}?module=task"
                                            ><i
                                                        class="ft-plus-circle font-medium-1"></i> <i
                                                        class="ft-arrow-right font-medium-1"></i></a>
                                            <select class="form-control round" name="default_done_status">
                                                @foreach($data['status'] as $status)
                                                    @php
                                                        if($defaults[16][0]['feature_value'] == $status->id){
                                                         echo '<option value='.$status->id.' selected>--'.$status->name.'--</option>';

                                                        }
echo '<option value='.$status->id.' >'.$status->name.'</option>';
                                                    @endphp

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row mb-1'>
                                        {{ Form::label( 'default_cancelled_status', trans('meta.default_cancelled_status'),['class' => 'col-12 control-label']) }}
                                        <div class='col-md-6'>
                                            <select class="form-control round" name="default_cancelled_status">
                                                @foreach($data['status'] as $status)
                                                    @php
                                                        if($defaults[16][0]['value1'] == $status->id){
                                                         echo '<option value='.$status->id.' selected>--'.$status->name.'--</option>';

                                                        }
echo '<option value='.$status->id.' >'.$status->name.'</option>';
                                                    @endphp

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=''>
                                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'm-1 btn btn-info btn-md']) }}
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!--edit-form-btn-->

                    </div>


                </div>


                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
