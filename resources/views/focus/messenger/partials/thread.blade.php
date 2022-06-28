<?php $class = $thread->isUnread(Auth::id()) ? 'avatar-away' : '';
$class_alert = $thread->isUnread(Auth::id()) ? 'alert alert-light ' : '';

?>
@if($thread->messages($thread->participants->first()->user_id)->count())
<div class="m-1 pb-1 border-bottom-blue-grey border-bottom-lighten-5 {{$class_alert}}">
    <a href="{{ route('biller.messages.show', $thread->id) }}" class="media border-0">
        <div class="media-left pr-1">
                                    <span class="avatar avatar-md {{$class}}"><img class="media-object rounded-circle"
                                                                                   src="{{ Storage::disk('public')->url('app/public/img/users/' . user_data($thread->participants->first()->user_id)->picture) }}"
                                                                                   alt="{{ user_data($thread->participants->first()->user_id)->first_name}}">
                                        <i></i>
                                    </span>
        </div>
        <div class="media-body w-100">
            <h6 class="list-group-item-heading">{{ $thread->subject }}<span
                        class="font-small-3 float-right primary">{{@$thread->latestMessage->updated_at}}</span></h6>
            <p class="list-group-item-text text-muted mb-0">@if(!$class)<i
                        class="ft-check primary font-small-2"></i>@endif {{ @$thread->latestMessage->body }} <span
                        class="float-right primary"><span class="badge badge-pill badge-danger">     ({{ $thread->userUnreadMessagesCount($thread->participants->first()->user_id) }})</span></span>
            </p><small>{{ user_data($thread->participants->first()->user_id)->first_name }}  {{ user_data($thread->participants->first()->user_id)->last_name }}</small>
            <small><strong> </strong> {{ @$thread->participants($thread->participants->first()->user_id,array('first_name','last_name')) }}
            </small>
        </div>
    </a></div>
    @endif