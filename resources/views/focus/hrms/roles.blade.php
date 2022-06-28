@extends ('core.layouts.app')

@section ('title', trans('labels.backend.hrms.management') . ' | ' . trans('labels.backend.hrms.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.hrms.management') }}
        <small>{{ trans('labels.backend.hrms.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.hrms.create') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.hrms.partials.hrms-header-buttons')
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
                                    {{ Form::open(['route' => 'biller.hrms.roles', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'create-hrm']) }}


                                    <div class='form-group'>
                                        {{ Form::label( 'role', trans('hrms.role'),['class' => 'col-lg-2 control-label']) }}
                                        <div class='col-lg-10'>
                                            <select class="form-control" name="role" id="emp_role">
                                                @foreach($roles AS $role)
                                                    <option value="{{$role['id']}}"
                                                            @if(@$hrms->role['id']==$role['id']) selected @endif>{{$role['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="permission_result">   @if(@$hrms->role['id'])
                                                <div class="row p-1">
                                                    @foreach($permissions_all as $row)
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="permission[]"
                                                                       value="{{$row['id']}}"
                                                                       @if(in_array_r($row['id'],$permissions)) checked="checked" @endif>
                                                                <label> {{$row['display_name']}} </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                {{ Form::close() }}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('after-scripts')


    <script>
        $(document.body).on('change', '#emp_role', function (e) {
            var pid = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("biller.hrms.related_permission") }}',
                type: 'post',
                dataType: 'html',
                data: {'rid': pid, 'create': '{{$general['create']}}'},
                success: function (data) {
                    $('#permission_result').html(data)
                }
            });
        });
    </script>
@endsection
