@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('general.date')}}</td>
            <td>{{trans('orders.order')}}#</td>
            <td>{{$lang['party_2']}}</td>
            <td>{{trans('general.total')}}</td>
            <td>{{trans('general.tax')}}</td>
            <td>{{trans('accounts.balance')}}</td>
        </tr>
        @php
            $fill = false;
            $balance=0;
            foreach ($account_details as $row) {
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }
                  $balance += $row['tax'];
                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row['invoicedate']) . '</td><td>' . $row['tid'] . '</td><td>' . $row->customer->name . '</td><td>' . amountFormat($row['total']) . '</td><td>' . amountFormat($row['tax']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
                $fill = !$fill;
            }
        @endphp
    </table>
    <br>
    <table class="subtotal">
        <thead>
        <tbody>
        <tr>
            <td class="myco2" rowspan="2"><br>
            </td>
            <td class="summary"><strong>{{trans('general.summary')}}</strong></td>
            <td class="summary"></td>
        </tr>
        <tr>
            <td>{{trans('accounts.balance')}}:</td>
            <td>{{amountFormat($balance)}}</td>
        </tr>

        </tbody>
    </table>
@endsection