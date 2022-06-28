<div class="card-content">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab"
                   aria-selected="true">{{trans('customers.billing_address')}}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab"
                   aria-selected="false">{{trans('general.other')}}</a>
            </li>

        </ul>
        <div class="tab-content px-1 pt-1">
            <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                <div class='form-group'>
                    {{ Form::label( 'name', trans('customers.name'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.name').'*','required'=>'required']) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'phone', trans('customers.phone'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('phone', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.phone').'*','required'=>'required']) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'email', trans('customers.email'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::email('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.email').'*','required'=>'required']) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'company', trans('customers.company'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('company', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.company')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'address', trans('customers.address'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('address', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.address')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'city', trans('customers.city'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('city', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.city')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'region', trans('customers.region'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('region', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.region')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'country', trans('customers.country'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('country', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.country')]) }}
                    </div>
                </div>
                <div class='form-group'>
                    {{ Form::label( 'postbox', trans('customers.postbox'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('postbox', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.postbox')]) }}
                    </div>
                </div>


                <div class='form-group'>
                    {{ Form::label( 'taxid', trans('customers.taxid'),['class' => 'col-lg-2 control-label']) }}
                    <div class='col-lg-10'>
                        {{ Form::text('taxid', null, ['class' => 'form-control box-size', 'placeholder' => trans('customers.taxid')]) }}
                    </div>
                </div>


            </div>

            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">

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

            </div>
        </div>
    </div>
</div>


@section("after-scripts")
    {{ Html::script('focus/js/select2.min.js') }}
    <script type="text/javascript">
        $(document).ready(function () {
            $("#groups").select2({
                multiple: true
            });

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
