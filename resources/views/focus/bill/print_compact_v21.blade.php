<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print {{$general['bill_type']}} {{$invoice['tid']}}</title>
    <style>
        @page {
            margin: 0 auto; /* imprtant to logo margin */
            sheet-size: 300px 250mm; /* imprtant to set paper size */
        }

        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
            font-family: '{{config('pdf.default_font')}}';
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 250mm;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 15pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body dir="{{$general['direction']}}">
<h3 id="logo" class="text-center"><br><img style="max-height:100px;"
                                           src='{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}'
                                           alt='Logo'></h3>
<div id='printbox'>
    <h2 style="margin-top:0" class="text-center">{{$company['cname']}}</h2>

    <table class="inv_info">
        @if($company['taxid'])
            <tr>
                <td> {{trans('general.tax_id')}}</td>
                <td>{{$company['taxid']}}</td>
            </tr>
        @endif
        <tr>
            <td>{{$general['lang_bill_number']}}</td>
            <td>: {{prefix($general['prefix'],$invoice['ins'])}} # {{$invoice['tid']}}</td>
        </tr>
        <tr>
            <td>{{$general['lang_bill_date']}}</td>
            <td>: {{dateFormat($invoice['invoicedate'],$company['main_date_format'])}} - {{date('H:i:s')}}<br></td>
        </tr>
        <tr>
            <td>{{$general['person']}}</td>
            <td>{{$invoice->customer->name}}</td>
        </tr>

    </table>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td><b>{{trans('products.product_des')}}</b></td>
            <td><b>{{trans('products.qty')}}&nbsp;</b></td>
            <td><b>{{trans('general.subtotal')}}</b></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <?php
        $this->pheight = 0;
        foreach ($invoice->products as $row) {
            $this->pheight = $this->pheight + 8;
            echo '<tr>
            <td >' . $row['product_name'] . '</td>
             <td>' . +$row['product_qty'] . ' ' . $row['unit'] . '</td>
            <td>' . amountFormat($row['product_subtotal'], $invoice['currency']) . '</td>
        </tr><tr><td colspan="3">&nbsp;</td></tr>';
        } ?>
    </table>
    <hr>
    <table class="inv_info">

        <tr>
            <td><b>{{trans('general.tax')}}</b></td>
            <td><b><?php echo amountFormat($invoice['tax'], $invoice['currency']) ?></b></td>
        </tr>
        <tr>
            <td><b>{{trans('general.discount')}}</b></td>
            <td><b><?php echo amountFormat($invoice['discount'], $invoice['currency']) ?></b></td>
        </tr>
        <tr>
            <td><b>{{trans('general.grand_total')}}</b></td>
            <td><b><?php echo amountFormat($invoice['total'], $invoice['currency']) ?></b></td>
        </tr>
    </table>

    <hr>
    <div class="text-center">{{trans('invoices.thank_you_note')}}</div>
    @if(@$qrc AND $invoice['status'] != 'paid')

        @php
            $this->pheight = $this->pheight + 40;
        @endphp
        <div class="text-center"><br>
            <small>{{trans('invoices.scan_pay')}}</small>
            <img style="max-height:230px;" src='{{Storage::disk('public')->path('qr/' . $qrc . '.png')}}' alt='QR'>
        </div>
    @else
        <div class="stamp"> {{trans('payments.'.$invoice['status'])}}</div>
    @endif
</div>
</body>
</html>
