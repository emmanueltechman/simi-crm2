<ul>
    @foreach($user as $customer)
        @php  $customer['discount_c'] = numberFormat(@$customer->primary_group->group_data['disc_rate']); unset($customer->primary_group);@endphp
        <li onClick="selectCustomer({{json_encode($customer)}})"><p>{{$customer->name}} &nbsp;
                &nbsp {{$customer->phone}}</p></li>
    @endforeach
</ul>