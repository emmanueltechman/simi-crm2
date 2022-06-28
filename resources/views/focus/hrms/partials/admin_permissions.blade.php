<div class="row p-1">
    @if(access()->allow('manage-hrm'))
        @foreach($permissions_all as $row)
            <div class="col-md-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="permissions[]" value="{{$row['id']}}" checked="">
                    <label> {{trans('permissions.'.$row['name'])}}</label>
                </div>
            </div>
        @endforeach
    @endif
</div>