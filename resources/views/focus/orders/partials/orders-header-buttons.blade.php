<div class="">
    <div class="btn-group" role="group" aria-label="orders">
        <a href="{{ route( 'biller.orders.index')}}{{$words['section_url']}}" class="btn btn-info  btn-lighten-2 round"><i
                    class="fa fa-list-alt"></i> {{trans( 'general.list' )}}</a>
        @if(access()->allow('data-creditnote') || access()->allow('stockreturn-data'))
            <a href="{{route( 'biller.orders.create' )}}{{$words['section_url']}}"
               class="btn btn-pink  btn-lighten-3 round"><i
                        class="fa fa-plus-circle"></i> {{trans( 'general.create' )}}</a>
        @endauth
    </div>
</div>
<div class="clearfix"></div>

