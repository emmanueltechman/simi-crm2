@extends ('core.layouts.public_app')
@section('content')
    <article class="content">
        <div class="offset-md-3 col-md-6">
            <div class="card card-block">
                <div class="card-body">
                    <h4 class="text-center">{{$company['company']['cname']}}</h4><br>
                    <h5>{{trans('banks.payable_accounts')}}</h5>
                    <hr>
                    <br>
                    @foreach ($banks as $account)
                        <div class="card">
                            <div class="card-block">

                                <div class="row">
                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name"> {{trans('banks.number')}}:</div>
                                            <div class="value">{{$account['number']}}</div>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name">  {{trans('banks.name')}}:</div>
                                            <div class="value">{{ $account['name']}}</div>
                                            <hr>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name">{{trans('banks.code')}}:</div>
                                            <div class="value"> {{$account['code']}}</div>
                                            <hr>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name"> {{trans('banks.note')}}:</div>
                                            <div class="value"> {{$account['note']}}</div>
                                            <hr>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name"> {{trans('banks.branch')}}:</div>
                                            <div class="value"> {{$account['branch']}}</div>
                                            <hr>
                                        </div>

                                    </div>

                                    <div class="col-12">

                                        <div class="stat">
                                            <div class="name"> {{trans('banks.address')}}:</div>
                                            <div class="value"> {{$account['address']}}</div>
                                            <hr>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    @endforeach
                </div>

            </div>

        </div>

    </article>@endsection