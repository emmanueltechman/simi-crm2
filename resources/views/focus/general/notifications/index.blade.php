<li class="dropdown-menu-header">
    <h6 class="dropdown-header m-0"><span
                class="grey darken-2">{{ trans('general.notifications')}}</span><span
                class="notification-tag badge badge-danger float-right m-0">{{ auth()->user()->unreadNotifications->count() }}</span>
    </h6>
</li>
@foreach(auth()->user()->unreadNotifications as $notification)
    <li class="scrollable-container media-list bg-lighten-5 bg-danger"><a href="javascript:void(0)"
                                                                          onclick="readNotifications('{{$notification->id}}')">
            <div class="media">
                <div class="media-left align-self-center"><i
                            class="fa {{ $notification->data['data']['icon'] }} icon-bg-circle {{ $notification->data['data']['background'] }}"></i>
                </div>
                <div class="media-body">
                    <h6 class="media-heading"> {{ $notification->data['data']['title'] }}</h6>
                    <p class="notification-text font-small-3 text-muted"> {{ \Illuminate\Support\Str::limit($notification->data['data']['data'],70) }}</p>
                    <small>
                        <time class="media-meta text-muted"
                              datetime="{{$notification->created_at}}"> {{ $notification->created_at->diffForHumans()}}
                        </time>
                    </small>
                </div>
            </div>
        </a></li>
@endforeach
@foreach(auth()->user()->readNotifications as $notification)
    <li class="scrollable-container media-list"><a href="javascript:void(0)"
                                                   onclick="readNotifications('{{$notification->id}}')">
            <div class="media">
                <div class="media-left align-self-center"><i
                            class="fa {{ $notification->data['data']['icon'] }} icon-bg-circle {{ $notification->data['data']['background'] }}"></i>
                </div>
                <div class="media-body">
                    <h6 class="media-heading"> {{ $notification->data['data']['title'] }}</h6>
                    <p class="notification-text font-small-3 text-muted"> {{ \Illuminate\Support\Str::limit($notification->data['data']['data'],70) }}</p>
                    <small>
                        <time class="media-meta text-muted"
                              datetime="{{$notification->created_at}}"> {{ $notification->created_at->diffForHumans()}}
                        </time>
                    </small>
                </div>
            </div>
        </a></li>
@endforeach

<li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                    href="{{route('biller.notification')}}">{{ trans('general.read_all')}}</a>
</li>
