@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('pos.opened_on')}}</td>
            <td>{{trans('pos.closed_on')}}</td>
            <td>{{trans('general.employee')}}</td>
            <td>{{trans('general.description')}}</td>
        </tr>
        @php
            $fill = false;

            foreach ($register_entries as $row) {
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }

                $balance=json_decode($row->data,true);
                $bal='';
                foreach ($balance as $key=>$amount_row){
                    $bal.=$key.' : '.amountFormat($amount_row).' ';
                }

                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row['created_at']) . '</td><td>' . dateFormat($row['closed_at']) . '</td><td>' . $row->user->first_name.' '.$row->user->last_name . '</td><td>' . $bal . '</td></tr>';
                $fill = !$fill;
            }
        @endphp
    </table>
    <br>

@endsection