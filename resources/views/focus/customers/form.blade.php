<div class="card-content">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab"
                   aria-selected="true">{{trans('customers.billing_address')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab"
                   aria-selected="false">{{trans('customers.shipping_address')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab"
                   aria-selected="false">{{trans('general.other')}}</a>
            </li>

        </ul>
        <div class="tab-content px-1">
            <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'name', trans('customers.name'),['class' => 'col-lg-2 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name').'*','required'=>'required']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'phone', trans('customers.phone'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('phone', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone').'*','required'=>'required']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'email', trans('customers.email'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::email('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email').'*']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'company', trans('customers.company'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('company', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.company')]) }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class='form-group'>
                    {{ Form::label( 'address', trans('customers.address'),['class' => 'col-lg-6 control-label']) }}
                    <div class='col-lg-12'>
                        {{ Form::text('address', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address')]) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'city', trans('customers.city'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('city', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'region', trans('customers.region'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('region', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region')]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'country', trans('customers.country'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('country', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'postbox', trans('customers.postbox'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-md-12'>
                                {{ Form::text('postbox', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox')]) }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">

                        <div class="form-group">
                            {{ Form::label( 'gid', trans('customers.gid'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-lg-12'>
                                <select class="form-control select-box col-12" name="groups[]" id="groups"
                                        multiple="multiple" data-placeholder="{{trans('customers.gid')}}">
                                    @if(@$current_groups) @foreach($current_groups as $group)
                                        <option value="{{$group->group_data->id}}"
                                                selected>{{$group->group_data->title}}</option>
                                    @endforeach
                                    @endif
                                    @foreach($customergroups as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'taxid', trans('customers.taxid'),['class' => 'col-lg-6 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('taxid', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.taxid')]) }}
                            </div>
                        </div>

                    </div>


                </div>


            </div>
            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'name_s', trans('customers.name_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('name_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name_s')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'phone_s', trans('customers.phone_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('phone_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone_s')]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'email_s', trans('customers.email_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('email_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email_s')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'address_s', trans('customers.address_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('address_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address_s')]) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'city_s', trans('customers.city_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('city_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city_s')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'region_s', trans('customers.region_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('region_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region_s')]) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'country_s', trans('customers.country_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('country_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country_s')]) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='form-group'>
                            {{ Form::label( 'postbox_s', trans('customers.postbox_s'),['class' => 'col-lg-12 control-label']) }}
                            <div class='col-lg-12'>
                                {{ Form::text('postbox_s', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox_s')]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                {!! $fields !!}
                <div class='form-group'>
                    {{ Form::label( 'docid', trans('customers.docid'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('docid', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.docid')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'custom1', trans('customers.custom1'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('custom1', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.custom1')]) }}
                    </div>
                </div>

                <div class='form-group hide_picture'>
                    {{ Form::label( 'picture', trans('customers.picture'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-6'>
                        {!! Form::file('picture', array('class'=>'input' )) !!}
                    </div>
                </div>

                <div class='form-group'>
                    {{ Form::label( 'password', trans('customers.password'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('password', '', ['class' => 'form-control box-size', 'placeholder' => trans('customers.password')]) }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@section("after-scripts")
    {{ Html::script('focus/js/select2.min.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            $("#groups").select2();

            $("#groups").on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);
                $element.detach();
                $(this).append($element);

                $(this).trigger("change");
            });


        });


    </script>
@endsection
