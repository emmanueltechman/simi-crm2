<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: {{$style['width']}}mm {{$style['height']}}mm;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<table cellpadding="{{$style['padding']}}" style="width: 100%">

    @foreach ($products as $lab)
        @for ($i = 0; $i <= $style['total_rows']; $i++)
            <tr>
                <td style="border: 1px solid;" class="text-center"><strong>{{$lab['name']}}</strong><br>
                    @if ($style['product_code']) <br>{{$lab['code']}}@endif
                    @if ($style['warehouse_name']) <br>{{$lab['warehouse']}} @endif
                    <br><br>
                   @if(strlen($lab['barcode'])>4)<barcode code="{{$lab['barcode']}}" text="1" class="barcode" height="{{$style['bar_height']}}"/></barcode><br><br>@endif
                    @if ($style['store_name']) {{$style['store']}}<br><br> @endif
                    @if ($lab['expiry']) {{trans('products.expiry')}}{{dateFormat($lab['expiry'])}} '<br><br>@endif

                    @if ($style['product_price']) <h3>{{amountFormat($lab['price'])}}<br><br></h3>@endif
                </td>
                @if ($style['items_per_row'] == 2)
                    <td style="border: 1px solid;" class="text-center"><strong>{{$lab['name']}}</strong><br>
                        @if ($style['product_code']) <br>{{$style['product_code']}} {{$lab['code']}}@endif
                        @if ($style['warehouse_name']) <br>{{$lab['warehouse']}} @endif
                        <br><br>
                        @if(strlen($lab['barcode'])>4)<barcode code="{{$lab['barcode']}}" text="1" class="barcode" height="{{$style['bar_height']}}"/></barcode><br><br>@endif
                        @if ($style['store_name']) {{$style['store']}}<br><br> @endif
                        @if ($lab['expiry']) {{trans('products.expiry')}}{{dateFormat($lab['expiry'])}} '<br><br>@endif

                        @if ($style['product_price']) <h3>{{amountFormat($lab['price'])}}<br><br></h3>@endif
                    </td>@endif
                @if ($style['items_per_row'] > 2)


                    <td style="border: 1px solid;" class="text-center"><strong>{{$lab['name']}}</strong><br>
                        @if ($style['product_code']) <br>{{$style['product_code']}} {{$lab['code']}}@endif
                        @if ($style['warehouse_name']) <br>{{$lab['warehouse']}} @endif
                        <br><br>
                         @if(strlen($lab['barcode'])>4)<barcode code="{{$lab['barcode']}}" text="1" class="barcode" height="{{$style['bar_height']}}"/></barcode><br><br>@endif
                        @if ($style['store_name']) {{$style['store']}}<br><br> @endif
                        @if ($lab['expiry']) {{trans('products.expiry')}}{{dateFormat($lab['expiry'])}} '<br><br>@endif

                        @if ($style['product_price']) <h3>{{amountFormat($lab['price'])}}<br><br></h3>@endif
                    </td>

                @endif
            </tr>
        @endfor
    @endforeach

</table>
</body>
</html>