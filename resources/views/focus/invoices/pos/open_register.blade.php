@extends ('core.layouts.app')

@section ('title', trans('pos.register'))


@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('pos.register_open') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    {{ Form::open(['route' => 'biller.register.open', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-tag']) }}
                                    @foreach(payment_methods() as $row)
                                        <div class='form-group'>
                                            {{ Form::label($row, $row,['class' => 'col-lg-2 control-label']) }}
                                            <div class='col-lg-6'>
                                                {{ Form::text('pm['.$row.']', 0, ['class' => 'form-control round', 'placeholder' => $row, 'onkeypress'=>"return isNumber(event)"]) }}
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        {{-- Including Form blade file --}}
                                        <div class="edit-form-btn">
                                            {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-purple btn-lg']) }}
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
