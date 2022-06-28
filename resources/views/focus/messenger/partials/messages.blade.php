<div class="card-header p-1">
    <div class="collapsed email-app-sender media border-0 bg-blue-grey bg-lighten-5 p-1">

        <div class="media-left pr-1">
            <span class="avatar avatar-md"><img class="media-object rounded-circle"
                                                src="{{ Storage::disk('public')->url('app/public/img/users/' . @user_data($message->user_id)->picture) }}"></span>
        </div>

        <div class="media-body w-100">
            <h6 class="list-group-item-heading">{{ @user_data($message->user_id)->first_name }}</h6>
            <p class="list-group-item-text">{{ $message->body }}<span class="float-right text muted">{{ $message->created_at->diffForHumans() }}

                    @if($message->user_id==auth()->user()->id)<a href="#" class="delete-message"
                                                                 data-thread="{{$message->id}}"><i
                                class="fa fa-trash danger"></i> </a>
                    @endif
                                                </span></p>
        </div>

    </div>
</div>