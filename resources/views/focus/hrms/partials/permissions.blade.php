<div class="row p-1">
    @foreach($permissions_all as $row)
        <div class="col-md-6">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="permission[]" value="{{$row['id']}}"
                       @if(in_array_r($row['id'],$permissions)) checked="" @endif>
                <label> {{$row['display_name']}} </label>
            </div>
        </div>
    @endforeach
</div>