@extends ('crm.layouts.app')

@section ('title', trans('labels.backend.customers.management')))


@section('content')
    <div class="a">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{ trans('customers.wallet') }}</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">

                                <div class="card-body">
                                    <h4>{{ trans('payments.wallet_balance') }} <span
                                                class="text-bold-700">{{amountFormat($user->balance)}}</span></h4>
                                    <hr>
                                    <h4>{{trans('dashboard.recent_transactions')}}</h4>
                                    <table class="table">
                                        @foreach($wallet_transactions as $row)
                                            <tr>
                                                <td>{{dateFormat($row['created_at'])}}</td>
                                                <td>{{$row['note']}}</td>
                                            </tr>

                                        @endforeach
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection