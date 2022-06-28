<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Balance Sheet</title>

    <style>
        body {
            font-size: 10pt;
            font-family: Helvetica;
        }


        table td {
            padding: 8pt;
        }

        .general {
            border: 1px solid;
            border-color: #ccc;

        }

        .general th {
            border: 1px solid;
            border-color: #ccc;
            padding: 5px;
        }

        .general td {
            border: 1px solid;
            border-color: #ccc;
            padding: 5px;
        }


    </style>
</head>
<body style=""><h2 style="text-align: center">
    {{trans('accounts.balance_sheet')}}
</h2>
<div style="text-align: center">{{trans('general.generated_on')}} : {{dateFormat(date('Y-m-d'))}}</div>
<h3>{{(config('core.cname'))}}</h3> {{(config('core.address'))}},<br>
{{(config('core.city'))}}, {{(config('core.region'))}}<br>
{{(config('core.cname'))}} - {{(config('core.postbox'))}}<br>
{{trans('general.phone')}}{{(config('core.cname'))}}: {{(config('core.phone'))}}<br>
{{trans('general.email')}}: {{(config('core.email'))}}<br>
@if(config('core.taxid'))
    {{trans('general.tax_id')}}: {{config('core.taxid')}}<br>
@endif

<hr>
@php
    $gross_ac=array();
@endphp
@foreach($account_types as $key => $t_row)
    <h3 class="title">
        {{$t_row}} {{trans('accounts.accounts')}}
    </h3>

    <table class="general" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>{{trans('accounts.holder')}}</th>
            <th>{{trans('accounts.account')}}</th>
            <th>{{trans('transactions.debit')}}</th>
            <th>{{trans('transactions.credit')}}</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1;
                    $gross = 0;
                    foreach ($account as $row) {
                        if ($row['account_type'] == $t_row) {
                            $aid = $row['id'];
                            $acn = $row['number'];
                            $holder = $row['holder'];
                            $balance = $row['balance'];
                            $debit = $row['debit'];
                            $qty = $row['created_at'];
                            echo "<tr>
                    <td>$i</td>
                    <td>$holder</td>
                    <td>$acn</td>

                    <td>" . amountFormat($debit) . "</td><td>" . amountFormat($balance) . "</td>
                    </tr>";
                            $i++;
                            $gross += $balance;
                        }

                    }
          $gross_ac[]=array('name'=>$t_row,'balance'=>$gross,'balance_debit'=>$gross_debit);
        @endphp
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th></th>

            <th></th>
 <th>
                                                <h3 class="text-xl-left">{{ amountFormat($gross_debit)}}</h3>
            <th>
                <h3 class="text-xl-left"><?php echo amountFormat($gross); ?></h3>
            </th>
        </tr>
        </tfoot>
    </table>
@endforeach

<br>
<h3> {{trans('general.summary')}} </h3><br>
<table class="general" width="100%">
    <thead>
    <tr>
        <th>{{trans('accounts.account_type')}}</th>
        <th>{{trans('transactions.debit')}}</th>
      <th>{{trans('transactions.credit')}}</th>
    </tr>
    </thead>
    <tbody>

    @foreach($gross_ac as $g_row)
        <tr>
            <td>{{$g_row['name']}}</td>
           <td>{{amountFormat($g_row['balance_debit'])}}</td>
                                                <td>{{amountFormat($g_row['balance'])}}</td>

        </tr>

    @endforeach
    </tbody>
    <tfoot>

    </tfoot>
</table>

</body>
