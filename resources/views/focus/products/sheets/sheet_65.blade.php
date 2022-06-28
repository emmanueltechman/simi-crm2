<html>

<head>
    <title>{{trans('products.standard_sheet') }} LP65/38</title>
    <style>


        /* Page Definitions */
        @page WordSection1 {
            size: 595.3pt 841.9pt;
            margin: 30.35pt 13.35pt 0in 13.35pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        table {
            width: 568.4pt;
            border-collapse: collapse;
            border: none;
            padding: 0;
        }

        tr {
            height: 60.1pt;
        }

        .label_box {
            width: 1.5in;
            padding: 0;
            height: 60.1pt;

            @if($style['border'])  border: 1px solid;
            @endif
 text-align: center;
            font-size: 8pt
        }

        .space_box {
            width: 7.1pt;
            padding: 0;
            height: 60.1pt;
        }
    </style>

</head>

<body>

<div class='WordSection1'>

    <div align='center'>

        <table>
            @for($i=0;$i<13;$i++)
                <tr>
                    <td class='label_box'>

                        <p>{{$product['name']}}</p>
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height="{{$style['bar_height']}}"></barcode>
                        @if ($style['product_code']) <p>{{$product['code']}}<p>@endif   @if ($style['product_price'])
                            <p>{{amountFormat($product['price'])}}</p>@endif
                    </td>
                    <td class='space_box'>
                        <p>&nbsp;</p>
                    </td>
                    <td class='label_box'>

                        <p>{{$product->product['name']}} {{$product['name']}}</p>
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height="{{$style['bar_height']}}"></barcode>
                        @if ($style['product_code']) <p>{{$product['code']}}<p>@endif   @if ($style['product_price'])
                            <p>{{amountFormat($product['price'])}}</p>@endif
                    </td>
                    <td class='space_box'>
                        <p>&nbsp;</p>
                    </td>
                    <td class='label_box'>

                        <p>{{$product->product['name']}} {{$product['name']}}</p>
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height="{{$style['bar_height']}}"></barcode>
                        @if ($style['product_code']) <p>{{$product['code']}}<p>@endif   @if ($style['product_price'])
                            <p>{{amountFormat($product['price'])}}</p>@endif
                    </td>
                    <td class='space_box'>
                        <p>&nbsp;</p>
                    </td>
                    <td class='label_box'>

                        <p>{{$product->product['name']}} {{$product['name']}}</p>
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height="{{$style['bar_height']}}"></barcode>
                        @if ($style['product_code']) <p>{{$product['code']}}<p>@endif   @if ($style['product_price'])
                            <p>{{amountFormat($product['price'])}}</p>@endif
                    </td>
                    <td class='space_box'>
                        <p>&nbsp;</p>
                    </td>
                    <td class='label_box'>

                        <p>{{$product->product['name']}} {{$product['name']}}</p>
                        <barcode code="{{$product['barcode']}}" type="{{$product->product['code_type']}}"
                                 height="{{$style['bar_height']}}"></barcode>
                        @if ($style['product_code']) <p>{{$product['code']}}<p>@endif   @if ($style['product_price'])
                            <p>{{amountFormat($product['price'])}}</p>@endif
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
