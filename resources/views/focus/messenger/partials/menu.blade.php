<div class="">
    <div class="btn-group" role="group">
        <a href="{{ route( 'biller.messages' ) }}" class="btn btn-info btn-lighten-2 round"><i
                    class="fa fa-list-alt"></i> {{trans( 'general.messages' )}}
            ( @include('focus.messenger.unread-count'))</a>


        <a href="{{route('biller.messages.create')}}"
           class="btn btn-pink  btn-lighten-3 round"><i
                    class="fa fa-plus-circle"></i> {{trans( 'general.new_message' )}}</a>

    </div>
</div>
<div class="clearfix"></div>

