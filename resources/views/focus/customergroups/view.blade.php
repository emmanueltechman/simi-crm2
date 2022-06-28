@extends ('core.layouts.app')

@section ('title', trans('labels.backend.customergroups.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.customergroups.management') }}</h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('labels.backend.customergroups.management') }}</h4>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.customergroups.partials.customergroups-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-content">

                    <div class="card-body">
                        <a href="#sendEmailGroup" data-toggle="modal"
                           data-remote="false"
                           data-type="1"
                           data-type1="notification" class="btn btn-primary btn-lg my-1"><i
                                    class="fa fa-paper-plane-o"></i> {{trans('customergroups.group_message')}}
                        </a>
                        <div class="row">
                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                <p>{{trans('customergroups.title')}}</p>
                            </div>
                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                <p>   {{$customergroup->title}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                <p>{{trans('customergroups.members')}}</p>
                            </div>
                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                <p>   {{$customergroup->customers->count('id')}} </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                <p>{{trans('customergroups.summary')}}</p>
                            </div>
                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                <p>   {{$customergroup->summary}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                <p>{{trans('customergroups.disc_rate')}}</p>
                            </div>
                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                <p>   {{numberFormat($customergroup->disc_rate)}}%</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@include("focus.modal.group_email_model")
@section('after-scripts')
    <script type="text/javascript">
        $(function () {
            $('.summernote').summernote({
                height: 150,
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
