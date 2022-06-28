<html>
<head>
    <title>{{trans('products.standard_sheet') }} LP24/134</title>
    <style>

        @page WordSection1 {
            size: 595.3pt 841.9pt;
            margin: 48.2pt 107.75pt 0in 107.75pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        table {
            width: 379.85pt;
            border-collapse: collapse;
            border: none;
        }

        tr {
            height: 31.2pt;
        }

        td {
            width: 379.85pt;
            padding: 0;
            height: 31.2pt;
            @if($style['border'])  border: 1px solid;
            @endif
 text-align: center;
            font-size: 8pt
        }
    </style>

</head>

<body>

<div class='WordSection1'>
    <div align='center'>
        <table>
            @for($i=0;$i<24;$i++)
                <tr>
                    <td>
                        {{$product->product['name']}}
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height=".3"></barcode> {{amountFormat($product['price'])}}
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <p class=MsoNormal style='margin-top:0in;margin-right:4.5pt;margin-bottom:8.0pt;
margin-left:4.5pt'><span lang=EN-GB style='display:none'>&nbsp;</span></p>
</div>

</body>

</html>
