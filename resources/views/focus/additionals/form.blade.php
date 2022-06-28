<div class='form-group'>
    {{ Form::label( 'name', trans('additionals.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('additionals.name')]) }}
    </div>
</div>
<div class='form-group' id="value1">
    {{ Form::label( 'value', trans('additionals.value'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('value', null, ['class' => 'form-control round', 'placeholder' => trans('additionals.value')]) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label( 'class', trans('terms.type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="class" id='class_m'>
            @php
                switch (@$additionals['class']){
                case 1 : echo  '<option value="1">--'.trans('general.tax').'--</option>';
                break;
                case 2  : echo  '<option value="2">--'.trans('general.discount').'--</option>';
                 break;
                }
            @endphp
            <option value="1">{{trans('general.tax')}}</option>
            <option value="2">{{trans('general.discount')}}</option>
        </select>
    </div>
</div>

<div class="form-group">
    {{ Form::label( 'type1', trans('additionals.type1'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="type1" id='type1'>
            @php
                switch (@$additionals['type1']){
                case '%' : echo  '<option value="%">--%-</option>';
                break;
                case 'flat' : echo  '<option value="flat">--'.trans('additionals.flat').'--</option>';
                break;
                 case 'b_flat' : echo  '<option value="b_flat">--'.trans('additionals.b_flat').'--</option>';
                break;
                case 'b_per' : echo  '<option value="b_per">--'.trans('additionals.b_per').'--</option>';
                break;

                }
            @endphp
            <option value="%">%</option>
            <option value="flat">{{trans('additionals.flat')}}</option>

        </select>
    </div>
</div>

<div class="form-group" id="type2">
    {{ Form::label( 'type2', trans('additionals.type2'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="type2">
            @php
                switch (@$additionals['type2']){

                case 'inclusive' : echo  '<option value="inclusive">--'.trans('additionals.inclusive').'--</option>';
                break;
                 case 'exclusive' : echo  '<option value="exclusive">--'.trans('additionals.exclusive').'--</option>';
                break;
                }
            @endphp

            <option value="inclusive">{{trans('additionals.inclusive')}}</option>
            <option value="exclusive">{{trans('additionals.exclusive')}}</option>

        </select>
    </div>
</div>

<div class="form-group" id="type3">
    {{ Form::label( 'type3', trans('additionals.type3'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        <select class="form-control round" name="type3">
            @php
                switch (@$additionals['type3']){

                case 'inclusive' : echo  '<option value="inclusive">--'.trans('additionals.inclusive').'--</option>';
                break;
                 case 'exclusive' : echo  '<option value="exclusive">--'.trans('additionals.exclusive').'--</option>';
                break;
                 case 'cgst' : echo  '<option value="cgst">--'.trans('additionals.cgst').'--</option>';
                break;
                }
            @endphp

            <option value="inclusive">{{trans('additionals.inclusive')}}</option>
            <option value="exclusive">{{trans('additionals.exclusive')}}</option>
            <option value="cgst">{{trans('additionals.cgst')}}</option>
            <option value="igst">{{trans('additionals.igst')}}</option>

        </select>
    </div>
</div>



@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $(document).ready(function () {
            $("#class_m").on('change', function () {
                if ($(this).val() == '2') {
                    $('#type1').find('option').remove().end().append('<option value="%">%</option><option value="flat">{{trans('additionals.flat')}}</option><option value="b_flat">{{trans('additionals.b_flat')}}</option><option value="b_per">{{trans('additionals.b_per')}}</option>').val('%');
                    $("#type3").hide();
                    $("#type2").hide();
                    $("#value1").hide();
                } else {
                    $('#type1').find('option').remove().end().append('<option value="%">%</option><option value="flat">{{trans('additionals.flat')}}</option>').val('%');
                    $("#type2").show();
                    $("#type3").show();
                    $("#value1").show();
                }

            });


            if ($("#class_m :selected").val() == '2') {
                $('#type1').find('option').remove().end().append('<option value="%">%</option><option value="flat">{{trans('additionals.flat')}}</option><option value="b_flat">{{trans('additionals.b_flat')}}</option><option value="b_per">{{trans('additionals.b_per')}}</option>').val('{{@$additionals['type1']}}');
                $("#type3").hide();
                $("#type2").hide();
                $("#value1").hide();
            }

        });


    </script>
@endsection
