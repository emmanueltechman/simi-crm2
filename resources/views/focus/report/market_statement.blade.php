{{ Form::open(['route' => array('biller.reports.generate_market_statement','market'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'statement']) }}
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('sales_channel.sales_channel')}}</label>

    <div class="col-sm-6">
        <select name="channel" class="form-control">
           <option value='all'>{{trans('general.all')}}</option>";
            <?php
            foreach ($channels as $row) {
                $cid = $row['id'];
                $acn = $row['name'];
                echo "<option value='$cid'>$acn - $acn</option>";
            }
            ?>
        </select>


    </div>

</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('transactions.transaction_type')}}</label>

    <div class="col-sm-3">
        <select name="trans_type" class="form-control">
            <option value='invoice'>{{trans('invoices.invoice')}}</option>
            <option value='purchaseorders'>{{trans('purchaseorders.purchaseorders')}}</option>
        </select>


    </div>
</div>
<div class="form-group row">

    <label class="col-sm-3 control-label"
           for="sdate">{{trans('meta.from_date')}}</label>

    <div class="col-sm-3">
        <input type="text" class="form-control from_date required"
               placeholder="Start Date" name="from_date"
               autocomplete="false" data-toggle="datepicker">
    </div>
</div>
<div class="form-group row">

    <label class="col-sm-3 control-label"
           for="edate">{{trans('meta.to_date')}}</label>

    <div class="col-sm-3">
        <input type="text" class="form-control required to_date"
               placeholder="End Date" name="to_date"
               data-toggle="datepicker" autocomplete="false">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('meta.report_output_format')}}</label>

    <div class="col-sm-3">
        <select name="output_format" class="form-control">
            <option value='pdf_print'>{{trans('general.pdf_print')}}</option>
            <option value='pdf'>{{trans('general.pdf')}}</option>
            <option value='csv'>CSV</option>
        </select>


    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="pay_cat"></label>

    <div class="col-sm-4">
        <input type="submit" class="btn btn-primary btn-md" value="View">


    </div>
</div>

{{ Form::close() }}
