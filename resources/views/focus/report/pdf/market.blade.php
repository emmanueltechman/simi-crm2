@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('general.date')}}</td>
            <td>{{$lang['bill_type']}}</td>
            <td>{{trans('general.amount')}}</td>
            <td>{{trans('accounts.balance')}}</td>
        </tr>
        @php
            $fill = false;
            $balance=0;
            foreach ($transactions as $row) {
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }
                $balance += $row->invoice['total'];
                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row->invoice['invoicedate']) . '</td><td>' . $row->invoice['tid'] . '</td><td>' . amountFormat($row->invoice['total']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
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