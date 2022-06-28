<ul class="list-group">
    @foreach($user as $payer)
        <li class="list-group-item"
            onClick="selectPayer({{json_encode(array('id'=>$payer->id,'name'=>$payer->name,'relation_id'=>$t))}})"><p>
                <strong>{{$payer->name}}</strong> {{$payer->email}}</p></li>
    @endforeach
</ul>