<?php

namespace App\Repositories\Focus\order;


use App\Models\items\OrderItem;
use App\Models\order\Order;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

use App\Models\items\CustomEntry;
use App\Models\items\InvoiceItem;
use App\Models\product\ProductVariation;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class OrderRepository.
 */
class OrderRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Order::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        if (request('section') == 'creditnote' AND !access()->allow('creditnote-manage')) exit();
        if (request('section') == 'stockreturn' AND !access()->allow('stockreturn-manage')) exit();

        $q = $this->query();
        $q->when(request('i_rel_type') == 1, function ($q) {

            return $q->where('customer_id', '=', request('i_rel_id', 0));
        });
        $q->when(request('section'), function ($q) {
            if (request('section') == 'creditnote' AND access()->allow('creditnote-manage')) return $q->where('i_class', '=', 2);
            if (request('section') == 'stockreturn' AND access()->allow('stockreturn-manage')) return $q->where('i_class', '=', 3);
        });
               if (request('start_date')) {
            $q->whereBetween('invoicedate', [date_for_database(request('start_date')), date_for_database(request('end_date'))]);
        }

        return
            $q->get(['id','tid','customer_id','invoicedate','invoiceduedate','total','status']);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function create(array $input)
    {

        $extra_discount = numberClean($input['invoice']['after_disc']);
        $input['invoice']['invoicedate'] = date_for_database($input['invoice']['invoicedate']);
        $input['invoice']['invoiceduedate'] = date_for_database($input['invoice']['invoiceduedate']);
        $input['invoice']['subtotal'] = numberClean($input['invoice']['subtotal']);
        $input['invoice']['shipping'] = numberClean($input['invoice']['shipping']);
        $input['invoice']['discount_rate'] = numberClean($input['invoice']['discount_rate']);
        $input['invoice']['after_disc'] = numberClean($input['invoice']['after_disc']);
        $input['invoice']['total'] = numberClean($input['invoice']['total']);
        $input['invoice']['ship_tax_rate'] = numberClean($input['invoice']['ship_rate']);
        $input['invoice']['ship_tax'] = numberClean($input['invoice']['ship_tax']);
        $input['invoice']['extra_discount'] = $extra_discount;
        $input['invoice']['i_class'] = $input['invoice']['type_bill'];
        $total_discount = $extra_discount;
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['type_bill']);
        unset($input['invoice']['ship_rate']);


        DB::beginTransaction();
        $input['invoice'] = array_map( 'strip_tags', $input['invoice']);
        $result = Order::create($input['invoice']);
        if ($result) {
            //      dd($result->id);
            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            $stock_update = array();
            foreach ($input['invoice_items']['product_id'] as $key => $value) {
                $subtotal += numberClean(@$input['invoice_items']['product_price'][$key]) * numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_qty += numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_tax += numberClean(@$input['invoice_items']['total_tax'][$key]);
                $total_discount += numberClean(@$input['invoice_items']['total_discount'][$key]);
                $products[] = array('order_id' => $result->id,
                    'product_id' => $input['invoice_items']['product_id'][$key],
                    'product_name' => strip_tags(@$input['invoice_items']['product_name'][$key]),
                    'code' => @$input['invoice_items']['code'][$key],
                    'product_qty' => numberClean(@$input['invoice_items']['product_qty'][$key]),
                    'product_price' => numberClean(@$input['invoice_items']['product_price'][$key]),
                    'product_tax' => numberClean(@$input['invoice_items']['product_tax'][$key]),
                    'product_discount' => numberClean(@$input['invoice_items']['product_discount'][$key]),
                    'product_subtotal' => numberClean(@$input['invoice_items']['product_subtotal'][$key]),
                    'total_tax' => numberClean(@$input['invoice_items']['total_tax'][$key]),
                    'total_discount' => numberClean(@$input['invoice_items']['total_discount'][$key]),
                    'product_des' => strip_tags(@$input['invoice_items']['product_description'][$key],config('general.allowed')),
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $result->ins);
            }
            $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => numberClean($input['invoice_items']['product_qty'][$key]));
            OrderItem::insert($products);
            $invoice_d = Order::find($result->id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();


            if (@$result->id) {
                $fields = array();
                if (isset($input['data2']['custom_field'])) {
                    foreach ($input['data2']['custom_field'] as $key => $value) {
                        $fields[] = array('custom_field_id' => $key, 'rid' => $result->id, 'module' => 5, 'data' => strip_tags($value), 'ins' => $input['data2']['ins']);
                    }
                    CustomEntry::insert($fields);
                }
            }

            $update_variation = new ProductVariation;
            $index = 'id';
            if ($input['invoice']['i_class'] == 2) Batch::update($update_variation, $stock_update, $index, true, '+');
            if ($input['invoice']['i_class'] == 3) Batch::update($update_variation, $stock_update, $index, true, '-');
            DB::commit();
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.orders.create_error'));


    }

    /**
     * For updating the respective Model in storage
     *
     * @param Order $order
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Order $order, array $input)
    {
        $id = $input['invoice']['id'];
        $extra_discount = numberClean($input['invoice']['after_disc']);
        $input['invoice']['invoicedate'] = date_for_database($input['invoice']['invoicedate']);
        $input['invoice']['invoiceduedate'] = date_for_database($input['invoice']['invoiceduedate']);
        $input['invoice']['subtotal'] = numberClean($input['invoice']['subtotal']);
        $input['invoice']['shipping'] = numberClean($input['invoice']['shipping']);
        $input['invoice']['discount_rate'] = numberClean($input['invoice']['discount_rate']);
        $input['invoice']['after_disc'] = numberClean($input['invoice']['after_disc']);
        $input['invoice']['total'] = numberClean($input['invoice']['total']);
        $input['invoice']['ship_tax_rate'] = numberClean($input['invoice']['ship_rate']);
        $input['invoice']['ship_tax'] = numberClean($input['invoice']['ship_tax']);
        $input['invoice']['extra_discount'] = $extra_discount;
        $total_discount = $extra_discount;
        $re_stock = @$input['invoice']['restock'];
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);
        unset($input['invoice']['id']);
        unset($input['invoice']['restock']);
        $result = Order::find($id);
        if ($result->status == 'canceled') return false;
         $input['invoice'] = array_map( 'strip_tags', $input['invoice']);
        $result->update($input['invoice']);

        if ($result) {
            OrderItem::where('order_id', $id)->delete();
            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            foreach ($input['invoice_items']['product_id'] as $key => $value) {
                $subtotal += numberClean(@$input['invoice_items']['product_price'][$key]) * numberClean(@$input['invoice_items']['product_qty'][$key]);
                $qty = numberClean($input['invoice_items']['product_qty'][$key]);
                $old_qty = numberClean(@$input['invoice_items']['old_product_qty'][$key]);
                $total_qty += $qty;
                $total_tax += numberClean(@$input['invoice_items']['total_tax'][$key]);
                $total_discount += numberClean(@$input['invoice_items']['total_discount'][$key]);
                $products[] = array('order_id' => $id,
                    'product_id' => $input['invoice_items']['product_id'][$key],
                    'product_name' => strip_tags(@$input['invoice_items']['product_name'][$key]),
                    'code' => @$input['invoice_items']['code'][$key],
                    'product_qty' => numberClean(@$input['invoice_items']['product_qty'][$key]),
                    'product_price' => numberClean(@$input['invoice_items']['product_price'][$key]),
                    'product_tax' => numberClean(@$input['invoice_items']['product_tax'][$key]),
                    'product_discount' => numberClean(@$input['invoice_items']['product_discount'][$key]),
                    'product_subtotal' => numberClean(@$input['invoice_items']['product_subtotal'][$key]),
                    'total_tax' => numberClean(@$input['invoice_items']['total_tax'][$key]),
                    'total_discount' => numberClean(@$input['invoice_items']['total_discount'][$key]),
                    'product_des' => strip_tags(@$input['invoice_items']['product_description'][$key],config('general.allowed')),
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $input['invoice']['ins']);

                if ($old_qty > 0) {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty - $old_qty);
                } else {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
                }

            }
            OrderItem::insert($products);
            $invoice_d = Order::find($id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();

            if (isset($input['data2']['custom_field'])) {
                foreach ($input['data2']['custom_field'] as $key => $value) {
                    $fields[] = array('custom_field_id' => $key, 'rid' => $id, 'module' => 5, 'data' => strip_tags($value), 'ins' => $input['invoice']['ins']);
                    CustomEntry::where('custom_field_id', '=', $key)->where('rid', '=', $id)->delete();
                }
                CustomEntry::insert($fields);
            }

            $update_variation = new ProductVariation;
            $index = 'id';
            Batch::update($update_variation, $stock_update, $index, true, '-');


            if (is_array($re_stock)) {
                $stock_update_one = array();
                foreach ($re_stock as $key => $value) {
                    $myArray = explode('-', $value);
                    $s_id = $myArray[0];
                    $s_qty = numberClean($myArray[1]);
                    if ($s_id) $stock_update_one[] = array('id' => $s_id, 'qty' => $s_qty);
                }

                Batch::update($update_variation, $stock_update_one, $index, true, '+');
            }


            DB::commit();


            return $result;
        }


        throw new GeneralException(trans('exceptions.backend.orders.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Order $order
     * @return bool
     * @throws GeneralException
     */
    public function delete(Order $order)
    {
        if ($order->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.orders.delete_error'));
    }
}
