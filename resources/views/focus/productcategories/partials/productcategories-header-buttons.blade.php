<!--Action Button-->
<div class="">
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route( 'biller.productcategories.index' ) }}" class="btn btn-info  btn-lighten-2"><i
                    class="fa fa-list-alt"></i> {{trans( 'general.list' )}}</a>
        @permission( 'productcategory-data' ) <a href="{{ route( 'biller.productcategories.create' ) }}"
                                                 class="btn btn-pink  btn-lighten-3"><i
                    class="fa fa-plus-circle"></i> {{trans( 'general.create' )}}</a> @endauth
    </div>
</div>
<div class="clearfix"></div>
