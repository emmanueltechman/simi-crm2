@foreach($wallet_transactions as $row)
    <tr>
        <td>{{dateFormat($row['created_at'])}}</td>
        <td>{{$row['note']}}</td>
        <td class="info">{{$row->user->first_name}}</td>
    </tr>
@endforeach