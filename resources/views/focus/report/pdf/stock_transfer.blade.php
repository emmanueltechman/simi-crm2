@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('general.date')}}</td>
            <td>{{trans('products.product')}}</td>
            <td>{{trans('products.stock_transfer_from')}}</td>
            <td>{{trans('products.stock_transfer_to')}}</td>
            <td>{{trans('products.qty')}}</td>
            <td>{{trans('general.total')}}</td>
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
                  $balance += $row['value'];
                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row['created_at']) . '</td><td>' . @$row->product->product['name'] . ' ' . @$row->product['name'] . '</td><td>' . $row->from_warehouse['title'] . '</td><td>' . $row->to_warehouse['title'] . '</td><td>' . numberFormat($row['value']) . '</td><td>' . numberFormat($balance) . ' '.@$row->product->product['unit'].'</td></tr>';
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
            <td>{{trans('general.total')}}:</td>
            <td>{{numberFormat($balance)}}</td>
        </tr>

        </tbody>
    </table>
@endsection