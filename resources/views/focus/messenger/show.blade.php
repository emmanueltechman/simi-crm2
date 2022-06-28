@extends ('core.layouts.app')
@section ('title', trans('general.messages').' | '.trans('general.message_management'))
@section('content')

    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('general.messages') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.messenger.partials.menu')
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


                                    <h1>{{ $thread->subject }}</h1>
                                    @each('focus.messenger.partials.messages', $thread->messages, 'message')

                                    @include('focus.messenger.partials.form-message')

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-scripts')
    <script type="text/javascript">


        $(function () {
            'use strict';


            $(document).on('click', ".delete-message", function (e) {
                var result = confirm("{{trans('general.delete')}} ?");
                if (result) {
                    e.preventDefault();
                    var aurl = '{{route('biller.messages.destroy')}}';
                    var obj = $(this);
                    var obj_value = $(this).attr('data-thread');

                      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                    jQuery.ajax({
                        url: aurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {'id': obj_value},
                        success: function (data) {
                            obj.closest('.media-body').remove();
                            obj.remove();
                        }
                    });
                }
            });
        });
    </script>
@endsection
