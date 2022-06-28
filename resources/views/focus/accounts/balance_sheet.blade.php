@extends ('core.layouts.app')
@section ('title', trans('accounts.balance_sheet').' | ' . trans('labels.backend.accounts.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.accounts.management') }}
        <small>{{ trans('labels.backend.accounts.create') }}</small>
    </h1>
@endsection
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="mb-0"> {{trans('accounts.balance_sheet')}} <a class="btn btn-success btn-sm"
                                                                             href="{{ route( 'biller.accounts.balance_sheet',['p']) }}">
                            <i class="fa fa-print"></i> {{ trans('general.print') }}</a></h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.accounts.partials.accounts-header-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @php
                                $gross_ac=array();
                            @endphp
                            @foreach($account_types as $key => $t_row)
                                <div class="card-content print_me">
                                    <h5 class="title {{ isset($bg_styles[$key]) ? $bg_styles[$key] : 'bg-gradient-x-info' }} p-1 white">
                                        {{$t_row}} {{trans('accounts.accounts')}}
                                    </h5>
                                    <p>&nbsp;</p>
                                    <table class="table">
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
                    $gross_debit = 0;
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
                    <td>".strip_tags($holder)."</td>
                    <td>".strip_tags($acn)."</td>

                    <td>" . amountFormat($debit) . "</td>  <td>" . amountFormat($balance) . "</td>
                    </tr>";
                            $i++;
                            $gross += $balance;
                            $gross_debit+=$debit;



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
                                            </th>
                                            <th>
                                                <h3 class="text-xl-left">{{ amountFormat($gross)}}</h3>
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    @endforeach

                                    <table class="table table-striped">
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
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-scripts')
    <script type="text/javascript">
        $(function () {
            // $(".print_me").printThis();
        });
    </script>
@endsection
