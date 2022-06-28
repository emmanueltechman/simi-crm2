@extends ('crm.layouts.app')

@section ('title', trans('labels.backend.customers.management')))


@section('content')
    <div class="a">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('hrms.update_profile') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    {{ Form::open(array('url' => route('crm.user.update_post'),'method' => 'post','files'=>true)) }}


                                    <div class="form-group">

                                        <div class="card-content">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="base-tab1" data-toggle="tab"
                                                           aria-controls="tab1" href="#tab1" role="tab"
                                                           aria-selected="true">{{trans('customers.billing_address')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="base-tab2" data-toggle="tab"
                                                           aria-controls="tab2" href="#tab2" role="tab"
                                                           aria-selected="false">{{trans('customers.shipping_address')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="base-tab3" data-toggle="tab"
                                                           aria-controls="tab3" href="#tab3" role="tab"
                                                           aria-selected="false">{{trans('general.other')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="base-tab4" data-toggle="tab"
                                                           aria-controls="tab4" href="#tab4" role="tab"
                                                           aria-selected="false">{{trans('labels.frontend.user.passwords.change')}}</a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content px-1 pt-1">
                                                    <div class="tab-pane active" id="tab1" role="tabpanel"
                                                         aria-labelledby="base-tab1">
                                                        <div class='form-group'>
                                                            {{ Form::label( 'name', trans('customers.name'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('name', $user->name, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name').'*','required'=>'required']) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'phone', trans('customers.phone'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('phone', $user->phone, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone').'*','required'=>'required']) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'email', trans('customers.email'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::email('email', $user->email, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email'),'readonly'=>'']) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'company', trans('customers.company'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('company', $user->company, ['class' => 'form-control box-size', 'placeholder' => trans('customers.company')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'address', trans('customers.address'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('address', $user->address, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'city', trans('customers.city'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('city', $user->city, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'region', trans('customers.region'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('region', $user->region, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'country', trans('customers.country'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('country', $user->country, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'postbox', trans('customers.postbox'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('postbox', $user->postbox, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox')]) }}
                                                            </div>
                                                        </div>


                                                        <div class='form-group'>
                                                            {{ Form::label( 'taxid', trans('customers.taxid'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('taxid', $user->taxid, ['class' => 'form-control box-size', 'placeholder' => trans('customers.taxid')]) }}
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane" id="tab2" role="tabpanel"
                                                         aria-labelledby="base-tab2">
                                                        <div class='form-group'>
                                                            {{ Form::label( 'name_s', trans('customers.name_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('name_s', $user->name_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'phone_s', trans('customers.phone_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('phone_s', $user->phone_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'email_s', trans('customers.email_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('email_s',  $user->email_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'address_s', trans('customers.address_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('address_s', $user->address_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'city_s', trans('customers.city_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('city_s', $user->city_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'region_s', trans('customers.region_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('region_s', $user->region_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'country_s', trans('customers.country_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('country_s', $user->country_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country_s')]) }}
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            {{ Form::label( 'postbox_s', trans('customers.postbox_s'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('postbox_s',  $user->postbox_s, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox_s')]) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab3" role="tabpanel"
                                                         aria-labelledby="base-tab3">

                                                        <div class='form-group'>
                                                            {{ Form::label( 'docid', trans('customers.docid'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-10'>
                                                                {{ Form::text('docid', $user->docid, ['class' => 'form-control box-size', 'placeholder' => trans('customers.docid'),'readonly'=>'']) }}
                                                            </div>
                                                        </div>


                                                        <div class='form-group hide_picture'>
                                                            {{ Form::label( 'picture', trans('customers.picture'),['class' => 'col-lg-2 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {!! Form::file('picture', array('class'=>'input' )) !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="tab4" role="tabpanel"
                                                         aria-labelledby="base-tab4">
                                                        <div class='form-group'>
                                                            {{ Form::label( 'password', trans('customers.password'),['class' => 'col-lg-6 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {{ Form::password('current_password',  ['class' => 'form-control box-size', 'placeholder' => trans('customers.password')]) }}
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            {{ Form::label( 'new_password', trans('validation.attributes.frontend.register-user.new_password'),['class' => 'col-lg-6 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {{ Form::password('new_password',  ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.register-user.new_password')]) }}
                                                            </div>
                                                        </div>

                                                        <div class='form-group'>
                                                            {{ Form::label( 'new_confirm_password', trans('validation.attributes.frontend.register-user.new_password_confirmation'),['class' => 'col-lg-6 control-label']) }}
                                                            <div class='col-lg-6'>
                                                                {{ Form::password('new_confirm_password',  ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.register-user.new_password_confirmation')]) }}
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="edit-form-btn">
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
