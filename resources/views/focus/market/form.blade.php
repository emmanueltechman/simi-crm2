<div class='form-group'>
    {{ Form::label( 'name', trans('additionals.name'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('name', null, ['class' => 'form-control round', 'placeholder' => trans('additionals.name')]) }}
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
