@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('general.date')}}</td>
            <td>{{trans('general.description')}}</td>
            <td>{{trans('transactions.debit')}}</td>
            <td>{{trans('transactions.credit')}}</td>
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
                $balance += $row['credit'] - $row['debit'];
                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row['payment_date']) . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
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