@extends ('core.layouts.app')
@section ('title', Auth::user()->newThreadsCount().' '.trans('general.messages').' | '.trans('general.message_management'))
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


                                    @include('focus.messenger.partials.flash')

                                    @each('focus.messenger.partials.thread', $threads, 'thread', 'focus.messenger.partials.no-threads')

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
