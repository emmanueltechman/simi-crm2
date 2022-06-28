{{ Form::open(['route' => array('biller.reports.generate_stock_statement','stock_transfer'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','files' => false, 'id' => 'statement']) }}
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('products.stock_transfer_from')}}</label>

    <div class="col-sm-6">
        <select name="from_warehouse" class="form-control">
            <option value='all'>{{trans('general.all')}}</option>
            <?php
            foreach ($warehouses as $row) {
                $id = $row['id'];
                $title = $row['title'];
                echo "<option value='$id'>$title</option>";
            }
            ?>
        </select>
    </div>

</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label"
           for="pay_cat">{{trans('products.stock_transfer_to')}}</label>

    <div class="col-sm-6">
        <select name="to_warehouse" class="form-control">
            <option value='all'>{{trans('general.all')}}</option>
            <?php
            foreach ($warehouses as $row) {
                $id = $row['id'];
                $title = $row['title'];
                echo "<option value='$id'>$title</option>";
            }
            ?>
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
        <input type="hidden" value="warehouse" name="stock_action">


    </div>
</div>

{{ Form::close() }}
