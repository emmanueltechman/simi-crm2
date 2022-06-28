<div class='form-group'>
    {{ Form::label( 'title', trans('general.title'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('title', null, ['class' => 'form-control round', 'placeholder' => trans('general.title')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'content', trans('general.note'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::textarea('content', null, ['class' => 'form-control round summernote', 'placeholder' => trans('general.note')]) }}
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            'use strict';
            $('.summernote').summernote({
                height: 300,
                tooltip: false,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ],
                popover: {}
            });
        });
    </script>
@endsection
