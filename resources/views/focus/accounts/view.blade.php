@extends ('core.layouts.app')

@section ('title', trans('labels.backend.accounts.management') . ' | ' . trans('labels.backend.accounts.create'))

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
                    <h3 class="mb-0">{{ trans('labels.backend.accounts.view') }}</h3>

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

                            <div class="card-content">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('accounts.number')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$account['number']}} <a class="btn btn-purple round"
                                                                            href="{{route('biller.transactions.index')}}?rel_type=9&rel_id={{$account['id']}}"
                                                                            title="List"><i class="fa fa-list"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('accounts.holder')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$account['holder']}} </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.debit')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{amountFormat($account['debit'])}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.credit')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{amountFormat($account['balance'])}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('accounts.code')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$account['code']}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('accounts.account_type')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$account['account_type']}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('accounts.note')}} </p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>   {{$account['note']}}
                                            </p>
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
