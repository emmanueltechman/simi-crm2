<div class="card-content">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab"
                   aria-selected="true">{{trans('hrms.employee_details')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab"
                   aria-selected="false">{{trans('hrms.profile')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab"
                   aria-selected="false">{{trans('hrms.hrms')}}</a>
            </li>


        </ul>
        <div class="tab-content px-1 pt-1">
            <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">

                <div class='form-group'>
                    {{ Form::label( 'first_name', trans('hrms.first_name'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('first_name', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.first_name').'*','required'=>'required']) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'last_name', trans('hrms.last_name'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('last_name', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.last_name').'*','required'=>'required']) }}
                    </div>
                </div>

                <div class='form-group'>
                    {{ Form::label( 'email', trans('hrms.email'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('email', null, ['class' => 'form-control round', 'placeholder' => trans('hrms.email').'*','required'=>'required']) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'password', trans('hrms.password'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>


                        @if(@$hrms->id)
                            {{ Form::text('password', '', ['class' => 'form-control round', 'placeholder' => trans('hrms.password').' (Abc@1234)','id'=>'u_password'.'*']) }}
                            <small>{{trans('hrms.blank_field')}}</small>
                        @else
                            {{ Form::text('password', '', ['class' => 'form-control round', 'placeholder' => trans('hrms.password').' (Abc@1234)','id'=>'u_password'.'*','required'=>'required']) }}
                        @endif
                    </div>
                    <div id="errors" class="alert round p-1"></div>
                </div>

                <div class='form-group hide_picture'>
                    {{ Form::label( 'picture', trans('hrms.picture'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-6'>
                        {!! Form::file('picture', array('class'=>'input' )) !!}  @if(@$hrms->id)
                            <small>{{trans('hrms.blank_field')}}</small>
                        @endif
                    </div>
                </div>
                <div class='form-group hide_picture'>
                    {{ Form::label( 'signature', trans('hrms.signature'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-6'>
                        {!! Form::file('signature', array('class'=>'input' )) !!}  @if(@$hrms->id)
                            <small>{{trans('hrms.blank_field')}}</small>
                        @endif
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'role', trans('hrms.role'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        <select class="form-control" name="role"
                                id="{{ $general['create'] == 1 ? "new_emp_role" : "emp_role" }}">
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
                                            <input type="checkbox" name="permission[]" value="{{$row['id']}}"
                                                   @if(in_array_r($row['id'],@$permissions)) checked="checked" @endif>
                                            <label>{{trans('permissions.'.$row['name'])}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                <div class='form-group'>
                    {{ Form::label( 'contact', trans('hrms.phone'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('contact', @$hrms->profile['contact'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.phone')]) }}
                    </div>
                </div>

                <div class='form-group'>
                    {{ Form::label( 'company', trans('hrms.company'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('company', @$hrms->profile['address_1'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.company')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'address', trans('hrms.address_1'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('address_1', @$hrms->profile['address_1'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.address_1')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'city', trans('hrms.city'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('city', @$hrms->profile['city'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.city')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'state', trans('hrms.state'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('state', @$hrms->profile['state'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.state')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'country', trans('hrms.country'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('country', @$hrms->profile['country'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.country')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'postal', trans('hrms.postal'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('postal', @$hrms->profile['postal'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.postal')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'tax_id', trans('hrms.tax_id'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('tax_id', @$hrms->profile['tax_id'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.tax_id')]) }}
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                <div class='form-group'>
                    {{ Form::label( 'department', trans('departments.department'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        <select class="form-control" name="department_id" id="department">
                            @foreach(@$departments AS $department)
                                <option value="{{$department['id']}}"
                                        @if(@$hrms->meta['id']==$department['id']) selected @endif>{{$department['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class='form-group'>
                    {{ Form::label( 'salary', trans('hrms.salary'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('salary', @$hrms->meta['salary'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.salary')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'hra', trans('hrms.hra'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('hra', @$hrms->meta['hra'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.hra')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'entry_time', trans('hrms.entry_time'),['class' => 'col control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::time('entry_time', @$hrms->meta['entry_time'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.entry_time')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'exit_time', trans('hrms.exit_time'),['class' => 'col control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::time('exit_time', @$hrms->meta['exit_time'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.exit_time')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'sales_commission', trans('hrms.sales_commission'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('commission', @$hrms->meta['commission'], ['class' => 'form-control box-size', 'placeholder' => trans('hrms.sales_commission')]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('after-scripts')
    {{ Html::script('focus/js/jquery.password-validation.js') }}
    <script>
        $(document).ready(function () {
            $("#u_password").passwordValidation({
                minLength: 6,
                minUpperCase: 1,
                minLowerCase: 1,
                minDigits: 1,
                minSpecial: 1,
                maxRepeats: 5,
                maxConsecutive: 3,
                noUpper: false,
                noLower: false,
                noDigit: false,
                noSpecial: false,
                failRepeats: true,
                failConsecutive: true,
                confirmField: undefined
            }, function (element, valid, match, failedCases) {

                $("#errors").html("<pre>" + failedCases.join("\n") + "</pre>");

                if (valid) $(element).css("border", "2px solid green");
                if (!valid) {
                    $(element).css("border", "2px solid red");
                    $("#e_btn").prop('disabled', true);
                }
                if (valid && match) {
                    $("#u_password").css("border", "2px solid green");
                    $("#e_btn").prop('disabled', false);
                }
                if (!valid || !match) $("#u_password").css("border", "2px solid red");
            });
        });

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
        $(document.body).on('change', '#new_emp_role', function (e) {
            var pid = $(this).val();
            fresh_permission(pid);
        });

        function fresh_permission(pid = 1) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("biller.hrms.role_permission") }}',
                type: 'post',
                dataType: 'html',
                data: {'rid': pid, 'create': '{{$general['create']}}'},
                success: function (data) {
                    $('#permission_result').html(data)
                }
            });
        }

        @if(isset($hrms->role['id']))  fresh_permission({{$hrms->role['id']}});
        @else fresh_permission(2); @endif
    </script>
@endsection
