<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Statement</title>

    <style>
        body {
            color: #2B2000;
            font-family: '{{config('pdf.default_font')}}';
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: right;
            border-collapse: collapse;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 0mm;
            border: 0;
            font-size: 16pt;
            line-height: 24pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 17pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
        }

        .invoice-box table td {
            padding: 8pt 4pt 5pt 4pt;
            vertical-align: top;

        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        .invoice-box table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #fff;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 500pt;
        }

        .myco2 {
            width: 290pt;
        }

        .myw {
            width: 230pt;
            font-size: 16pt;
            line-height: 30pt;
        }

        .summary {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }
    </style>
</head>
<body dir="{{visual()}}">
<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="{{ Storage::disk('public')->url('app/public/img/company/' . config('core.logo')) }}"
                     style="max-width:100px;">
            </td>
            <td>
            </td>
            <td class="myw">{{$lang['title']}}<br><small>{{trans('meta.generated_on')}}
                    : {{dateFormat(date('Y-m-d'))}}</small></td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
        <tr class="heading">
            <td> {{trans('general.business_info')}}:</td>

            <td>{{$lang['title2']}}:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><h4>{{(config('core.cname'))}}</h4>
                {{(config('core.address'))}}<br>{{(config('core.city'))}}, {{(config('core.region'))}}
                <br>{{trans('general.phone')}}: {{(config('core.phone'))}}<br> {{trans('general.email')}}
                : {{(config('core.email'))}}  @if(config('core.taxid'))
                    <br>    {{trans('general.tax_id')}}: {{config('core.taxid')}}
                @endif</td>

            <td>
                {!!$lang['party']!!}
            </td>
        </tr>
        </tbody>
    </table>
    @yield('statement_body')
    <br>
    <div class="sign">{{trans('general.authorized_person')}}</div>
    <div class="sign1"></div>
    <div class="sign2"></div>
    <div class="sign3"></div>
    <br>
    <hr>
</div>
</body>
</html>
