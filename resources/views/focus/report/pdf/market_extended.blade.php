@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('sales_channel.sales_channel')}}</td>
            <td>{{trans('general.amount')}}</td>
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

                echo '<tr class="item' . $flag . '"><td>' . $row['name'] . '</td><td>' . amountFormat($row['total_sales']) . '</td></tr>';
                $fill = !$fill;
                $balance+=$row['total_sales'];
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
            <td>{{trans('general.total')}}:</td>
            <td>{{amountFormat($balance)}}</td>
        </tr>

        </tbody>
    </table>
@endsection