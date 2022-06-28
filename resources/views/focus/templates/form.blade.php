<div class='form-group'>
    {{ Form::label( 'title', trans('templates.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control round', 'placeholder' => trans('templates.title')]) }}
    </div>
</div>
<div class='form-group mb-3'>
    {{ Form::label( 'body', trans('templates.body'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::textarea('body', null, ['class' => 'form-control round html_editor', 'placeholder' => trans('templates.body'),'rows'=>15]) }}
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $(document).ready(function () {
          $('.html_editor').summernote({
                    height: 260,
                    tooltip: false,
                    toolbar: [
                        <?php echo config('general.editor'); ?>

                    ],
                    popover: {}

                });
        });
    </script>
@endsection
