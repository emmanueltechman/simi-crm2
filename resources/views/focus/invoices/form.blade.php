<div class='form-group'>
    {{ Form::label( 'tid', trans('invoices.tid'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('tid', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.tid')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'invoicedate', trans('invoices.invoicedate'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('invoicedate', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.invoicedate')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'invoiceduedate', trans('invoices.invoiceduedate'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('invoiceduedate', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.invoiceduedate')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'subtotal', trans('invoices.subtotal'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('subtotal', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.subtotal')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'shipping', trans('invoices.shipping'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('shipping', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.shipping')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'ship_tax', trans('invoices.ship_tax'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('ship_tax', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.ship_tax')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'ship_tax_type', trans('invoices.ship_tax_type'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('ship_tax_type', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.ship_tax_type')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'discount', trans('invoices.discount'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('discount', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.discount')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'discount_rate', trans('invoices.discount_rate'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('discount_rate', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.discount_rate')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'tax', trans('invoices.tax'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('tax', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.tax')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'total', trans('invoices.total'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('total', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.total')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'pmethod', trans('invoices.pmethod'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('pmethod', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.pmethod')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'notes', trans('invoices.notes'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('notes', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.notes')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'status', trans('invoices.status'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('status', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.status')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'csd', trans('invoices.csd'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('csd', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.csd')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'eid', trans('invoices.eid'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('eid', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.eid')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'pamnt', trans('invoices.pamnt'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('pamnt', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.pamnt')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'items', trans('invoices.items'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('items', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.items')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'taxstatus', trans('invoices.taxstatus'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('taxstatus', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.taxstatus')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'discstatus', trans('invoices.discstatus'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('discstatus', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.discstatus')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'format_discount', trans('invoices.format_discount'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('format_discount', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.format_discount')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'refer', trans('invoices.refer'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('refer', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.refer')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'term', trans('invoices.term'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('term', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.term')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'multi', trans('invoices.multi'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('multi', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.multi')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'i_class', trans('invoices.i_class'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('i_class', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.i_class')]) }}
    </div>
</div>
<div class='form-group'>
    {{ Form::label( 'r_time', trans('invoices.r_time'),['class' => 'col-lg-2 control-label']) }}
    <div class='col-lg-10'>
        {{ Form::text('r_time', null, ['class' => 'form-control box-size', 'placeholder' => trans('invoices.r_time')]) }}
    </div>
</div>

@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $(document).ready(function () {
            //Everything in here would execute after the DOM is ready to manipulated.
        });
    </script>
@endsection
