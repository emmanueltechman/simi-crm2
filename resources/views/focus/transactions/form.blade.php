<div class='row'>
    <div class='col-md-6'>
        <div class='form-group'>
            {{ Form::label( 'account_id', trans('transactions.account_id'),['class' => 'col-12 control-label']) }}
            <div class="col">
                <select name="account_id" class='form-control round'>
                    @foreach($accounts as $account)
                        <option value="{{$account['id']}}">{{$account['holder'].' '.$account['number']}}</option>
                    @endforeach
                </select></div>
        </div> @if($dual_entry->feature_value)
            <div class='form-group'>
                {{ Form::label( 'account_id', trans('transactions.account_id2'),['class' => 'col-12 control-label']) }}
                <div class="col">
                    <select name="account_id2" class='form-control round'>
                        @foreach($accounts as $account)
                            <option value="{{$account['id']}}">{{$account['holder'].' '.$account['number']}}</option>
                        @endforeach
                    </select></div>
            </div>
        @endif
    </div>
    <div class='col-md-6'>
        <div class='form-group'>
            {{ Form::label( 'trans_category_id', trans('transactions.trans_category_id'),['class' => 'col-12 control-label']) }}
            <div class="col">
                <select name="trans_category_id" class='col form-control round'>
                    @foreach($transaction_categories as $category)
                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md-3'>
        <div class='form-group'>
            {{ Form::label( 'debit', trans('transactions.debit'),['class' => 'col control-label']) }}
            <div class="col">
                {{ Form::text('debit', numberFormat(0), ['class' => 'form-control round', 'placeholder' => trans('transactions.debit').'*','required'=>'required','onkeypress'=>"return isNumber(event)"]) }}</div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='form-group'>
            {{ Form::label( 'credit', trans('transactions.credit'),['class' => 'col control-label']) }}
            <div class="col">
                {{ Form::text('credit', numberFormat(0), ['class' => 'form-control round', 'placeholder' => trans('transactions.credit').'*','required'=>'required','onkeypress'=>"return isNumber(event)"]) }}</div>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='form-group'>
            {{ Form::label( 'method', trans('transactions.method'),['class' => 'col-12 control-label']) }}
            <div class="col">
                <select name="method" class='col form-control round'>
                    @foreach(payment_methods() as $payment_method)
                        <option value="{{$payment_method}}">{{$payment_method}}</option>
                    @endforeach
                    <option value="Card">Card</option>

                </select>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md-6'>
        <div class='col m-1'>
            @if(isset($payroll))
                <input type="hidden" name="payer_type" value="employee">
            @else
                {{ Form::label( 'method', trans('transactions.payer_type'),['class' => 'col-12 control-label']) }}
                <div class="d-inline-block custom-control custom-checkbox mr-1">
                    <input type="radio" class="custom-control-input bg-primary" name="payer_type" id="colorCheck1"
                           value="none" checked="">
                    <label class="custom-control-label" for="colorCheck1">None</label>
                </div>
                <div class="d-inline-block custom-control custom-checkbox mr-1">
                    <input type="radio" class="custom-control-input bg-success" name="payer_type" value="customer"
                           id="colorCheck2">
                    <label class="custom-control-label" for="colorCheck2">{{trans('customers.customer')}}</label>
                </div>
                <div class="d-inline-block custom-control custom-checkbox mr-1">
                    <input type="radio" class="custom-control-input bg-purple" name="payer_type" value="supplier"
                           id="colorCheck3">
                    <label class="custom-control-label" for="colorCheck3">{{trans('suppliers.supplier')}}</label>
                </div>
                <div class="d-inline-block custom-control custom-checkbox mr-1">
                    <input type="radio" class="custom-control-input bg-blue-grey" name="payer_type" value="employee"
                           id="colorCheck4">
                    <label class="custom-control-label" for="colorCheck4">{{trans('hrms.employee')}}</label>
                </div>
            @endif
        </div>

    </div>
    <div class='col-md-6'>
        <div class='form-group'>
            {{ Form::label( 'payer', trans('transactions.payer'),['class' => 'col-lg-12 control-label']) }}
            <div class="col">
                {{ Form::text('payer', null, ['class' => 'form-control round', 'placeholder' => trans('transactions.payer'),'id'=>'payer','autocomplete'=>'off']) }}</div>
        </div>
    </div>
    <div id="payer-box-result" class="offset-4"></div>
</div>


<div class="row">
    <div class='col-md-6'>
        <div class='form-group'>
            {{ Form::label( 'note', trans('general.note'),['class' => 'col-6 control-label']) }}
            <div class='col'>
                {{ Form::text('note', null, ['class' => 'form-control round', 'placeholder' => trans('general.note'),'autocomplete'=>'off']) }}
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <div class='form-group'>
            {{ Form::label( 'payment_date', trans('transactions.payment_date'),['class' => 'col control-label']) }}
            <div class='col-6'>
                <fieldset class="form-group position-relative has-icon-left">
                    <input type="text" class="form-control round required"
                           placeholder="{{trans('general.payment_date')}}*" name="payment_date"
                           data-toggle="datepicker" required="required">
                    <div class="form-control-position">
                      <span class="fa fa-calendar"
                            aria-hidden="true"></span>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>

</div>

{{ Form::hidden('payer_id', 0, ['id' => 'payer_id']) }}
{{ Form::hidden('relation_id', 0, ['id' => 'relation_id']) }}

@section("after-scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: '{{config('core.user_date_format')}}'
            });
            $('[data-toggle="datepicker"]').datepicker('setDate', '{{date(config('core.user_date_format'))}}');
        });

        function selectPayer(data) {
            $('#payer_id').val(data.id);
            $('#relation_id').val(data.relation_id);
            $('#payer').val(data.name);
            $("#payer-box-result").hide();
        }

        $("#payer").keyup(function () {
            if ($(this).val() == '') $("#payer-box-result").hide();
            if ($('input[name=payer_type]:checked').val()) {
                var p_t = $('input[name=payer_type]:checked').val();
            } else {
                var p_t = $('input[name=payer_type]').val();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route('biller.transactions.payer_search')}}',
                data: 'keyword=' + $(this).val() + '&payer_type=' + p_t,
                beforeSend: function () {
                    $("#payer").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#payer-box-result").show();
                    $("#payer-box-result").html(data);
                    $("#payer-box").css("background", "none");

                }
            });
        });
    </script>
@endsection
