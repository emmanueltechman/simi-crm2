@extends ('core.layouts.app')

@section ('title', trans('labels.backend.transactions.management') . ' | ' . trans('labels.backend.transactions.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.transactions.management') }}
        <small>{{ trans('labels.backend.transactions.create') }}</small>
    </h1>
@endsection

@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">{{ trans('labels.backend.transactions.view') }}</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('focus.transactions.partials.transactions-header-buttons')
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
                                    <a href="{{route('biller.print_payslip',[$transaction['id'],1,1])}}"
                                       class="btn btn-blue btn-md offset-11"><span class="fa fa-print"
                                                                                   aria-hidden="true"></span></a>

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.account_id')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$transaction->account['holder']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.trans_category_id')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$transaction->category['name']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.debit')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{amountFormat($transaction['debit'])}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.credit')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{amountFormat($transaction['credit'])}}</p>
                                        </div>
                                    </div>
                                    @php
                                        $payer='';
                                        $payer_lang='';
                                        $related_bill='';
                                        $related_bill_lang='';

                                    if ($transaction['payer_id']) {
                                                 switch ($transaction->relation_id) {
                                                     case 1 :
                                                         $payer= '<a href="'.route('biller.customers.show',[$transaction->customer->id]).'">'.$transaction->customer->name.'</a>';
                                                          $payer_lang=trans('customers.customer');
                                                          $related_bill_lang=trans('invoices.invoice');
                                                           $related_bill= '<a href="'.route('biller.invoices.show',[$transaction['bill_id']]).'">#'.$transaction->invoice->tid.'</a>';
                                                         break;
                                                 }
                                             }
                                             else if ($transaction->payer) {
                                             $payer= $transaction->payer;
                                              $payer_lang=trans('transactions.payer');
}
                                    @endphp
                                    @if($payer)
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{$payer_lang}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>{!!$payer!!}
                                                </p>
                                            </div>
                                        </div>  @endif
                                    @if($related_bill)
                                        <div class="row">
                                            <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                                <p>{{$related_bill_lang}}</p>
                                            </div>
                                            <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                                <p>{!! $related_bill !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.method')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{trans('payments.'.$transaction['method'])}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('transactions.payment_date')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{dateFormat($transaction['payment_date'])}}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('general.employee')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$transaction->user['first_name'].' '.$transaction->user['last_name']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 border-blue-grey border-lighten-5  p-1">
                                            <p>{{trans('general.note')}}</p>
                                        </div>
                                        <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                                            <p>{{$transaction['note']}}</p>
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
