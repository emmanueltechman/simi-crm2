@extends('emails.layouts.app')
@section('content')
    <div class="content">
        <td align="left">
            <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #504f4f; width:20px; font-size: 16px; line-height: 24px;">

                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0"
                               style="margin-bottom:20px;border-radius: 5px;">

                            <tr>
                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                            </tr>

                            <tr>
                                <td
                                        style="font-size: 14px; line-height: 22px;letter-spacing: 1px;">
                                    <!-- main section button -->
                                    <div style="line-height: 22px;">
                                        {!! $body !!}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                            </tr>

                        </table>


                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
