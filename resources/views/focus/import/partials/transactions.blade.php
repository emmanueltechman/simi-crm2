{{ Form::open(['route' => ['biller.import.general_post','transactions'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => true, 'id' => 'import-data']) }}
<input type="hidden" name="update" value="1">
{!! Form::file('import_file', array('class'=>'form-control input col-md-6 mb-1' )) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label( 'account', trans('accounts.account'),['class' => 'col control-label']) }}
            <div class='col'>
                <select class="form-control" name="account">
                    @foreach($data['accounts'] as $account)
                        <option value="{{$account['id']}}">{{$account['holder'].' '.$account['number']}}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='form-group'>
            {{ Form::label( 'trans_category_id', trans('transactions.trans_category_id'),['class' => 'col-12 control-label']) }}
            <div class="col">
                <select name="trans_category" class='col form-control'>
                    @foreach($data['transaction_categories'] as $category)
                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
{{ Form::submit(trans('import.upload_import'), ['class' => 'btn btn-primary btn-md']) }}
{{ Form::close() }}
