@extends ('core.layouts.app')
@section ('title', trans('general.new_message').' | '.trans('general.message_management'))
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


                                    <h1>{{ trans('general.new_message') }}</h1>
                                    <form action="{{ route('biller.messages.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="col">
                                            <!-- Subject Form Input -->
                                            <div class="form-group">
                                                <label class="control-label">{{ trans('general.subject') }}</label>
                                                <input type="text" class="form-control" name="subject"
                                                       placeholder="Subject"
                                                       value="{{ old('subject') }}">
                                            </div>

                                            <!-- Message Form Input -->
                                            <div class="form-group">
                                                <label class="control-label">{{ trans('general.message') }}</label>
                                                <textarea name="message"
                                                          class="form-control">{{ old('message') }}</textarea>
                                            </div>

                                            @if($users->count() > 0)
                                                <div class="checkbox">
                                                    @foreach($users as $user)
                                                        <label title="{{ $user->name }}" class="m-1"><input
                                                                    type="checkbox" name="recipients[]"
                                                                    value="{{ $user->id }}"> {!!$user->name!!}</label>
                                                    @endforeach
                                                </div>
                                        @endif

                                        <!-- Submit Form Input -->
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1"><i
                                                            class="fa fa-check"></i> {{trans('general.send')}}</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
