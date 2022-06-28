@extends ('focus.customers.layout.view')
@section('customer_view')
    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified"
        role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="active-tab1" data-toggle="tab"
               href="#active1" aria-controls="active1" role="tab"
               aria-selected="true">{{ trans('payments.client_balance') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="active-tab2" data-toggle="tab"
               href="#active2" aria-controls="active2"
               role="tab">{{ trans('transactions.wallet_transactions') }}</a>
        </li>

        <li class="nav-item">
            <a class="nav-link " id="active-tab4" data-toggle="tab"
               href="#active4" aria-controls="active4"
               role="tab">{{ trans('transactions.wallet_recharge') }}</a>
        </li>

    </ul>
    <div class="tab-content px-1 pt-1">
        <div class="tab-pane active in" id="active1"
             aria-labelledby="active-tab1" role="tabpanel">
            <div class="row">

                <div class="col border-blue-grey border-lighten-5  p-1 font-weight-bold">
                    <h4>{{ trans('payments.wallet_balance') }} <span
                                class="purple"> {{amountFormat($customer['balance'])}} </span></h4>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="active2" aria-labelledby="link-tab2"
             role="tabpanel">
            <table class="table" id="trans">
            </table>
        </div>
        <div class="tab-pane" id="active4" aria-labelledby="link-tab3"
             role="tabpanel">

            {{ Form::open(['route' => 'biller.customers.wallet_post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'wallet-customer']) }}
            <div class='form-group'>
                {{ Form::label( 'amount', trans('general.amount'),['class' => 'col-lg-2 control-label']) }}
                <div class='col-lg-2'>
                    {{ Form::text('amount', null, ['class' => 'form-control box-size', 'placeholder' => trans('general.amount'),'onkeypress'=>"return isNumber(event)"]) }}
                </div>
            </div>
            <input type="hidden" name="wid" value=" {{$customer['id']}}">
            <div class='form-group'>
                {{ Form::submit(trans('general.add'), ['class' => 'btn ml-2 btn-primary btn-md']) }}   </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection
@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
    <script>

        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {

            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('biller.customers.wallet_load')}}',
                    dataType: "html",
                    method: 'post',
                    data: {'rel_id': '{{$customer['id']}}'},
                    success: function (data) {

                        $('#trans').html(data);
                    }
                })
            }, 1000);
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen', ['fullscreen']],
                    ['codeview', ['codeview']]
                ],
                popover: {}
            });
        });


    </script>

@endsection
