<?php

namespace App\Repositories\Focus\purchaseorder;


use App\Models\account\Account;
use App\Models\items\PurchaseItem;
use App\Models\market\ChannelBill;
use App\Models\purchaseorder\Purchaseorder;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

use App\Models\items\CustomEntry;
use App\Models\items\InvoiceItem;
use App\Models\product\ProductVariation;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class PurchaseorderRepository.
 */
class PurchaseorderRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Purchaseorder::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        $q = $this->query();
        $q->when(request('i_rel_type') == 1, function ($q) {

            return $q->where('supplier_id', '=', request('i_rel_id', 0));
        });

        return
            $q->get();
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
        $total_discount = $extra_discount;
        $stock=$input['invoice']['update_stock'];
         $sales_channel = @$input['invoice']['sales_channel'];
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);
        unset($input['invoice']['update_stock']);
         unset($input['invoice']['sales_channel']);

        DB::beginTransaction();
        $input['invoice'] = array_map('strip_tags', $input['invoice']);
        $result = Purchaseorder::create($input['invoice']);
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
                if ($input['invoice_items']['unit_m'][$key] > 1) {
                    $unit_val = $input['invoice_items']['unit_m'][$key];
                    $qty = $unit_val * numberClean($input['invoice_items']['product_qty'][$key]);
                } else {
                    $unit_val = 1;
                    $qty = numberClean($input['invoice_items']['product_qty'][$key]);
                }
                $products[] = array('bill_id' => $result->id,
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
                    'product_des' => strip_tags(@$input['invoice_items']['product_description'][$key], config('general.allowed')),
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $result->ins);
                if($input['invoice_items']['product_id'][$key]) $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
            }

            PurchaseItem::insert($products);
            $invoice_d = Purchaseorder::find($result->id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();


            if (@$result->id) {
                $fields = array();
                if (isset($input['data2']['custom_field'])) {
                    foreach ($input['data2']['custom_field'] as $key => $value) {
                        $fields[] = array('custom_field_id' => $key, 'rid' => $result->id, 'module' => 9, 'data' => strip_tags($value), 'ins' => $input['data2']['ins']);
                    }
                    CustomEntry::insert($fields);
                }
            }

            if ($stock=='yes') {

                $update_variation = new ProductVariation;
                $index = 'id';
                Batch::update($update_variation, $stock_update, $index, true, '+');

            }

            DB::commit();
              if($sales_channel){
                ChannelBill::create(array('bill_id'=>$result->id,'c_id'=>$sales_channel,'ref'=>2));
            }
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.purchaseorders.create_error'));


    }

    /**
     * For updating the respective Model in storage
     *
     * @param Purchaseorder $purchaseorder
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Purchaseorder $purchaseorder, array $input)
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
         $stock=$input['invoice']['update_stock'];
          $sales_channel = @$input['invoice']['sales_channel'];
         unset($input['invoice']['update_stock']);
          unset($input['invoice']['sales_channel']);
        $result = Purchaseorder::find($id);
        if ($result->status == 'canceled') return false;
        $input['invoice'] = array_map('strip_tags', $input['invoice']);
        $result->update($input['invoice']);
        if ($result) {
            PurchaseItem::where('bill_id', $id)->delete();
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
                $products[] = array('bill_id' => $id,
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
                    'product_des' => strip_tags(@$input['invoice_items']['product_description'][$key], config('general.allowed')),
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $input['invoice']['ins']);

                if ($old_qty > 0) {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty - $old_qty);
                } else {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
                }
            }
            PurchaseItem::insert($products);
            $invoice_d = Purchaseorder::find($id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();
            if (isset($input['data2']['custom_field'])) {
                foreach ($input['data2']['custom_field'] as $key => $value) {
                    $fields[] = array('custom_field_id' => $key, 'rid' => $id, 'module' => 9, 'data' => strip_tags($value), 'ins' => $input['invoice']['ins']);
                    CustomEntry::where('custom_field_id', '=', $key)->where('rid', '=', $id)->delete();
                }
                CustomEntry::insert($fields);
            }
               if ($stock=='yes') {
                   $update_variation = new ProductVariation;
                   $index = 'id';
                   Batch::update($update_variation, $stock_update, $index, true);
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
               }
            DB::commit();
               if($sales_channel){
                 ChannelBill::where(array('bill_id'=>$result->id,'ref'=>2))->update(array('c_id'=>$sales_channel));
            }
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.purchaseorders.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Purchaseorder $purchaseorder
     * @return bool
     * @throws GeneralException
     */
    public function delete(Purchaseorder $purchaseorder)
    {
                $transactions = $purchaseorder->transactions;
        if (count($transactions)) {
            foreach ($transactions as $transaction) {
                $account = Account::find($transaction->account_id);
                $account->balance += $transaction->debit;
                $account->balance -= $transaction->credit;
                $account->save();
                $transaction->delete();
            }
        }
          ChannelBill::where('bill_id','=',$purchaseorder->id)->where('ref','=',2)->delete();

        if ($purchaseorder->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.purchaseorders.delete_error'));
    }
}
