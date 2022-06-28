<?php

namespace App\Repositories\Focus\invoice;

use App\Models\account\Account;
use App\Models\Company\ConfigMeta;
use App\Models\invoice\Draft;
use App\Models\items\CustomEntry;
use App\Models\items\DraftItem;
use App\Models\items\InvoiceItem;
use App\Models\invoice\Invoice;
use App\Exceptions\GeneralException;
use App\Models\items\Register;
use App\Models\market\ChannelBill;
use App\Models\market\SalesChannel;
use App\Models\product\ProductMeta;
use App\Models\product\ProductVariation;
use App\Models\project\ProjectRelations;
use App\Models\transaction\Transaction;
use App\Models\transaction\TransactionHistory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mavinoo\Batch\BatchFacade as Batch;

/**
 * Class InvoiceRepository.
 */
class InvoiceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Invoice::class;

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
            return $q->where('customer_id', '=', request('i_rel_id', 0));
        });

        $q->when(request('i_rel_type') == 2, function ($q) {
            return $q->where('user_id', '=', request('i_rel_id', 0));
        });

        if (request('project_id')) {
            $q->whereHas('project', function ($s) {
                return $s->where('project_id', '=', request('project_id', 0));
            });
        }

        if(!request('i_rel_type')) {

            if (request('sub') == 1) {
                $q->where('i_class', '>', 1);
            } elseif (request('sub') == 2) {
                $q->where('i_class', '=', 1);
            } else {
                $q->where('i_class', '<', 1);
            }
        }

        if (request('start_date')) {
            $q->whereBetween('invoicedate', [date_for_database(request('start_date')), date_for_database(request('end_date'))]);
        }


        return
            $q->get(['id', 'tid', 'customer_id', 'invoicedate', 'invoiceduedate', 'total', 'status','order_id']);
    }

    public function getSelfDataTable($self_id = false)
    {
        if ($self_id) {
            $q = $this->query()->withoutGlobalScopes();
            $q->where('customer_id', '=', $self_id);

            return
                $q->get(['id', 'tid', 'customer_id', 'invoicedate', 'invoiceduedate', 'total', 'status','order_id']);
        }
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
        $input['invoice']['subtotal'] = numberClean($input['invoice']['subtotal']);
        $input['invoice']['shipping'] = numberClean($input['invoice']['shipping']);
        $input['invoice']['discount_rate'] = numberClean($input['invoice']['discount_rate']);
        $input['invoice']['after_disc'] = numberClean($input['invoice']['after_disc']);
        $input['invoice']['total'] = numberClean($input['invoice']['total']);
        $input['invoice']['ship_tax_rate'] = numberClean($input['invoice']['ship_rate']);
        $input['invoice']['ship_tax'] = numberClean($input['invoice']['ship_tax']);
        $input['invoice']['extra_discount'] = $extra_discount;

        $total_discount = $extra_discount;
        if ($input['invoice']['sub']) {
            $input['invoice']['i_class'] = 2;
            $input['invoice']['r_time'] = $input['invoice']['recur_after'];
            $input['invoice']['invoiceduedate'] = date("Y-m-d", strtotime($input['invoice']['invoicedate'] . " +" . $input['invoice']['r_time'] . 's'));
            unset($input['invoice']['recur_after']);
        } else {
            $input['invoice']['invoiceduedate'] = date_for_database($input['invoice']['invoiceduedate']);
        }
        $sales_channel = @$input['invoice']['sales_channel'];
        $p = @$input['invoice']['p'];
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);
        unset($input['invoice']['sub']);
        unset($input['invoice']['p']);
        unset($input['invoice']['sales_channel']);

        if (!isset($input['invoice_items']['product_id'])) {
            return false;
        }


        DB::beginTransaction();
        $status=feature(10)['value2'];

        $input['invoice'] = array_map('strip_tags', $input['invoice']);
        if($status)$input['invoice']['status']=$status;
        $existed=Invoice::where('tid',$input['invoice']['tid']);
        if(@$existed->first()->tid) {$input['invoice']['tid']=Invoice::latest()->first()->tid+1;}
        $result = Invoice::create($input['invoice']);
        if ($result) {
            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            $stock_update = array();
            $serial_track = array();
            foreach ($input['invoice_items']['product_id'] as $key => $value) {

                $subtotal += numberClean(@$input['invoice_items']['product_price'][$key]) * numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_qty += numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_tax += numberClean(@$input['invoice_items']['total_tax'][$key]);
                $total_discount += numberClean(@$input['invoice_items']['total_discount'][$key]);
                if ($input['invoice_items']['serial'][$key]) $serial_track[] = array('rel_type' => 2, 'rel_id' => 1, 'ref_id' => $input['invoice_items']['product_id'][$key], 'value' => strip_tags($input['invoice_items']['serial'][$key]), 'value2' => $result->id);
                if ($input['invoice_items']['unit_m'][$key] > 1) {
                    $unit_val = $input['invoice_items']['unit_m'][$key];
                    $qty = $unit_val * numberClean($input['invoice_items']['product_qty'][$key]);
                } else {
                    $unit_val = 1;
                    $qty = numberClean($input['invoice_items']['product_qty'][$key]);
                }
                $products[] = array('invoice_id' => $result->id,
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
                    'unit_value' => $unit_val,
                    'serial' => @$input['invoice_items']['serial'][$key],
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $result->ins);
               if($input['invoice_items']['product_id'][$key]) $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
            }

            InvoiceItem::insert($products);
            $invoice_d = Invoice::find($result->id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();
            if (@$result->id) {
                $fields = array();
                if (isset($input['data2']['custom_field'])) {
                    foreach ($input['data2']['custom_field'] as $key => $value) {
                        $fields[] = array('custom_field_id' => $key, 'rid' => $result->id, 'module' => 2, 'data' => strip_tags($value), 'ins' => $input['data2']['ins']);
                    }
                    CustomEntry::insert($fields);
                }
            }
            $update_variation = new ProductVariation;
            $index = 'id';
            Batch::update($update_variation, $stock_update, $index, true);
            $update_variation = new ProductMeta;
            $index = 'value';
            $index2 = 'ref_id';
            $out_s = $this->update_dual($update_variation, $serial_track, $index, $index2);
            if ($p > 0) {
                ProjectRelations::create(array('project_id' => $p, 'related' => 7, 'rid' => $result->id));
                $result['p'] = $p;
            }

            if($sales_channel){
                ChannelBill::create(array('bill_id'=>$result->id,'c_id'=>$sales_channel,'ref'=>1));
            }



            DB::commit();


            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.invoices.create_error'));
    }

        public function due_payment($invoice)
    {
        DB::beginTransaction();

        $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
        $words['prefix'] = prefix(1);

        $amount=$invoice->total;


        $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first();

        if ($dual_entry['value1']) {
            $account = Account::find($dual_entry['value1']);
            $account->balance = $account->debit + $amount;
            $account->save();
        }


        $transaction = array();
        if ($amount > 0 and $account->id) {

            $transaction['ins'] = auth()->user()->ins;
            $transaction['user_id'] = auth()->user()->id;
            $transaction['credit'] = 0;
            $transaction['debit'] = $amount;
            $transaction['payment_date'] = $invoice->invoicedate;

            $transaction['payer_id'] = $invoice->customer_id;
            $transaction['payer'] = $invoice->customer->name;
            $transaction['trans_category_id'] = $default_category['feature_value'];
            $transaction['method'] = '';
            $transaction['account_id'] = $account->id;
            $transaction['note'] = trans('en.auto_debit_transaction') . ' ' . $words['prefix'] . '#' . $invoice->tid;
            $transaction['bill_id'] = $invoice->id;
            $transaction['relation_id'] = 0;

        }


        try {


             Transaction::create($transaction);
            $note = trans('en.auto_debit_transaction') . ' ' . amountFormat($amount);
            TransactionHistory::create(array('party_id' => $invoice->customer->id, 'user_id' => auth()->user()->id, 'note' => strip_tags($note), 'relation_id' => 11, 'ins' => auth()->user()->ins));

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
            return false;
        }

        if (isset(auth()->valid)) DB::commit(); else  DB::rollBack();

        return true;
    }

    private function update_dual(Model $table, array $values, string $index = null, $index2 = null)
    {
        $final = [];

        if (!count($values)) {
            return false;
        }

        $whr = '';
        foreach ($values as $key => $val) {

            $q = '';
            $i = 0;
            foreach (array_keys($val) as $field) {
                if ($field != $index and $field != $index2) {

                    if ($i < 2) $q .= $field . '=' . $val[$field] . ',';
                    if ($i == 2) $q .= $field . '=' . $val[$field] . ' ';

                    $i++;
                }
            }
            $whr .= "UPDATE `" . $table->getTable() . "` SET $q";
            $whr .= 'WHERE (`' . $index . '` = "' . $val[$index] . '" AND `' . $index2 . '` = "' . $val[$index2] . '"  AND `value2` IS NULL);';
        }

        return DB::statement($whr);

    }


    /**
     * For updating the respective Model in storage
     *
     * @param Invoice $invoice
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Invoice $invoice, array $input)
    {
        $p = @$input['invoice']['p'];

        $id = $input['invoice']['id'];
        $extra_discount = numberClean($input['invoice']['after_disc']);
        $input['invoice']['invoicedate'] = date_for_database($input['invoice']['invoicedate']);
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
         $sales_channel = @$input['invoice']['sales_channel'];
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);
        unset($input['invoice']['id']);
        unset($input['invoice']['restock']);
        unset($input['invoice']['sub']);
        unset($input['invoice']['p']);
        unset($input['invoice']['sales_channel']);

        DB::beginTransaction();
        $result = Invoice::find($id);
        if ($result->status == 'canceled') return false;
        if ($result->i_class > 1) {
            $input['invoice']['r_time'] = $input['invoice']['recur_after'];
            $input['invoice']['invoiceduedate'] = date("Y-m-d", strtotime($input['invoice']['invoicedate'] . " +" . $input['invoice']['r_time'] . 's'));
            unset($input['invoice']['recur_after']);
        } else {
            $input['invoice']['invoiceduedate'] = date_for_database($input['invoice']['invoiceduedate']);
        }
        $input['invoice'] = array_map('strip_tags', $input['invoice']);
        $result->update($input['invoice']);

        if ($result) {
            InvoiceItem::where('invoice_id', $id)->delete();
            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            foreach ($input['invoice_items']['product_id'] as $key => $value) {

                if ($input['invoice_items']['unit_m'][$key] > 1) {
                    $unit_val = $input['invoice_items']['unit_m'][$key];
                    $qty = $unit_val * numberClean($input['invoice_items']['product_qty'][$key]);
                    $old_qty = $unit_val * numberClean(@$input['invoice_items']['old_product_qty'][$key]);
                } else {
                    $unit_val = 1;
                    $qty = numberClean($input['invoice_items']['product_qty'][$key]);
                    $old_qty = numberClean(@$input['invoice_items']['old_product_qty'][$key]);
                }

                $subtotal += numberClean(@$input['invoice_items']['product_price'][$key]) * numberClean(@$input['invoice_items']['product_qty'][$key]);
                //$qty = numberClean($input['invoice_items']['product_qty'][$key]);

                $total_qty += $qty;
                $total_tax += numberClean(@$input['invoice_items']['total_tax'][$key]);
                $total_discount += numberClean(@$input['invoice_items']['total_discount'][$key]);
                $products[] = array('invoice_id' => $id,
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
                    'unit_value' => $unit_val,
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $input['invoice']['ins']);

                if ($old_qty > 0) {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty - $old_qty);
                } else {
                    $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
                }

            }
            InvoiceItem::insert($products);
            $invoice_d = Invoice::find($id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();

            if (isset($input['data2']['custom_field'])) {
                foreach ($input['data2']['custom_field'] as $key => $value) {
                    $fields[] = array('custom_field_id' => $key, 'rid' => $id, 'module' => 2, 'data' => strip_tags($value), 'ins' => $input['invoice']['ins']);
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

             if($sales_channel){
                 ChannelBill::where(array('bill_id'=>$result->id,'ref'=>1))->update(array('c_id'=>$sales_channel));
            }


            DB::commit();


            return $result;
        }


        throw new GeneralException(trans('exceptions.backend.invoices.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Invoice $invoice
     * @return bool
     * @throws GeneralException
     */
    public function delete(Invoice $invoice)
    {
        $transactions = $invoice->transactions;
        if (count($transactions)) {
            foreach ($transactions as $transaction) {
                $account = Account::find($transaction->account_id);
                $account->balance += $transaction->debit;
                $account->balance -= $transaction->credit;
                $account->save();
                $transaction->delete();
            }
        }
        ChannelBill::where('bill_id','=',$invoice->id)->where('ref','=',1)->delete();
        if($invoice->i_class==1) {
            $register = Register::where('user_id', $invoice->user_id)->latest('created_at')->first();
            $new_data = array();
            $register_update = array();
            $register_update[$invoice->pmethod] = $invoice->pamnt;
            $items = json_decode($register->data, true);
            $mdata = json_decode($invoice->mdata, true);

            foreach ($items as $key => $reg) {

                if (isset($register_update[$key])) $new_data[$key] = $reg - $invoice->pamnt; else $new_data[$key] = $reg;

            }
            $new_data['Change']=$new_data['Change']-$mdata['Change'];
            $register->data = json_encode($new_data);
            $register->save();
        }

        foreach ($invoice->products as $product) {
            if($product['product_id']) {
                $item = ProductVariation::find($product['product_id']);
                $item->qty += $product['product_qty'];
                $item->save();
            }
        }


        if ($invoice->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.invoices.delete_error'));
    }

    public function convert(array $input)
    {

        $last_invoice = Invoice::orderBy('id', 'desc')->where('i_class', '=', 0)->first();

        $extra_discount = numberClean($input['invoice']['after_disc']);
        $input['invoice']['tid'] = @$last_invoice->tid + 1;
        $input['invoice']['extra_discount'] = $extra_discount;
        $total_discount = $extra_discount;
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);

        //   DB::beginTransaction();

        $result = Invoice::create($input['invoice']);
        if ($result) {


            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            $stock_update = array();


            foreach ($input['invoice_items'] as $row) {
                $subtotal += (@$row['product_price']) * (@$row['product_qty']);
                $total_qty += (@$row['product_qty']);
                $total_tax += (@$row['total_tax']);
                $total_discount += (@$row['total_discount']);
                $products[] = array('invoice_id' => $result->id,
                    'product_id' => @$row['product_id'],
                    'product_name' => @$row['product_name'],
                    'code' => @$row['code'],
                    'product_qty' => (@$row['product_qty']),
                    'product_price' => (@$row['product_price']),
                    'product_tax' => (@$row['product_tax']),
                    'product_discount' => (@$row['product_discount']),
                    'product_subtotal' => (@$row['product_subtotal']),
                    'total_tax' => (@$row['total_tax']),
                    'total_discount' => (@$row['total_discount']),
                    'product_des' => @$row['product_des'],
                    'i_class' => 0,
                    'unit' => $row['unit'], 'ins' => $result->ins);
            $stock_update[] = array('id' => $row['product_id'], 'qty' => $row['product_qty']);
            }


            InvoiceItem::insert($products);
            $invoice_d = Invoice::find($result->id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();


            if (@$result->id) {
                $fields = array();
                if (isset($input['data2']['custom_field'])) {
                    foreach ($input['data2']['custom_field'] as $key => $value) {
                        $fields[] = array('custom_field_id' => $key, 'rid' => $result->id, 'module' => 2, 'data' => $value, 'ins' => $input['data2']['ins']);
                    }
                    CustomEntry::insert($fields);
                }
            }

            $update_variation = new ProductVariation;
            $index = 'id';
            Batch::update($update_variation, $stock_update, $index, true);


            //     DB::commit();
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.invoices.create_error'));
    }

    public function payment($invoice, $payment)
    {
        DB::beginTransaction();
        $payments = array();
        $default_category = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 8)->first('feature_value');
        $words['prefix'] = prefix(1);
        $total_amount = 0;
        $register_update = array();
        $pay_change = numberClean($payment['b_change']);
        $i=0;

        foreach ($payment['p_amount'] as $key => $amount) {
            $pay_method = $payment['p_method'][$key];
            $amount = numberClean($amount);
            if(!$i) $amount=$amount-$pay_change;


            if (!isset($register_update[$pay_method])) {
                $register_update[$pay_method] = $amount;
            } else {
                $register_update[$pay_method] = $register_update[$pay_method] + $amount;
            }

            if ($pay_method == 'Wallet') {
                $available_balance = $invoice->customer->balance;
                if ($available_balance >= $amount) {
                    $r_wallet = $available_balance - $amount;
                    $invoice->customer->balance = $r_wallet;
                    $invoice->customer->save();
                } else {
                    $amount = 0;
                }
            }
            $transaction = array();
            if ($amount > 0) {

                $transaction['ins'] = auth()->user()->ins;
                $transaction['user_id'] = auth()->user()->id;
                $transaction['credit'] = $amount;
                $transaction['debit'] = 0;
                $transaction['payment_date'] = $invoice->invoicedate;
                $transaction['credit'] = $amount;
                $transaction['payer_id'] = $invoice->customer_id;
                $transaction['payer'] = $invoice->customer->name;
                $transaction['trans_category_id'] = $default_category['feature_value'];
                $transaction['method'] = $pay_method;
                $transaction['account_id'] = $payment['p_account'];
                $transaction['note'] = trans('invoices.payment_for_invoice') . ' ' . $words['prefix'] . '#' . $invoice->tid;
                $transaction['bill_id'] = $invoice->id;
                $transaction['relation_id'] = 0;
                $payments[] = $transaction;
                $total_amount += $amount;
            }

        }



        try {
            if (count($transaction) > 0) {

                $result = Transaction::insert($payments);
                $note = trans('payments.paid_amount') . ' ' . amountFormat($total_amount);
                TransactionHistory::create(array('party_id' => $invoice->customer->id, 'user_id' => auth()->user()->id, 'note' => strip_tags($note), 'relation_id' => 11, 'ins' => auth()->user()->ins));
                $new_data = array();
                $register = Register::orderBy('id', 'desc')->where('user_id', '=', auth()->user()->id)->whereNull('closed_at')->first();
                $items = json_decode($register->data, true);
                $register_update['Change'] = numberClean($payment['b_change']);

                foreach ($items as $key => $reg) {

                    if (isset($register_update[$key])) $new_data[$key] = $register_update[$key] + $reg; else $new_data[$key] = $reg;

                }
                $invoice_meta_update = json_encode(array('Change'=>$register_update['Change']));
                $register->data = json_encode($new_data);
                $register->save();
                $invoice->mdata=$invoice_meta_update;
                $invoice->save();
            }

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            echo json_encode(array('status' => 'Error', 'message' => trans('exceptions.valid_entry_account') . $e->getCode()));
            return false;
        }

        $dual_entry = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 13)->first();
        if ($dual_entry['feature_value']) {
            $payments2 = array();
            foreach ($payments as $payment_row) {
                $payment_row['debit'] = $payment_row['credit'];
                $payment_row['credit'] = 0;
                $payments2[] = $payment_row;
            }
            Transaction::insert($payments2);
        }

        if (isset($result)) {

            $account = Account::find($payment['p_account']);
            $account->balance = $account->balance + $total_amount;
            $account->save();
            if ($dual_entry['feature_value']) {
                $account = Account::find($dual_entry['value1']);
                $account->balance = $account->balance - $total_amount;
                $account->save();
            }
            $due = $invoice->total - ($total_amount + $invoice->pamnt);
            $invoice->pmethod = $transaction['method'];

            if ($due <= 0) {

                $invoice->pamnt = $invoice->total;
                $invoice->status = 'paid';

            } elseif ($total_amount < $invoice->total and $total_amount > 0) {

                $invoice->pamnt = $invoice->pamnt + $total_amount;

                $invoice->status = 'partial';
            }
            $invoice->save();
        } elseif ($invoice->pamnt >= $invoice->total) {
            $invoice->status = 'paid';
            $invoice->pamnt = $invoice->total;

            $invoice->save();
        } elseif ($invoice->pamnt > 0) {
            $invoice->status = 'partial';

            $invoice->save();
        }
        if (isset(auth()->valid)) DB::commit(); else  DB::rollBack();

        return true;
    }

    public function create_draft(array $input)
    {
        $extra_discount = numberClean($input['invoice']['after_disc']);
        $input['invoice']['invoicedate'] = date_for_database($input['invoice']['invoicedate']);
        $input['invoice']['subtotal'] = numberClean($input['invoice']['subtotal']);
        $input['invoice']['shipping'] = numberClean($input['invoice']['shipping']);
        $input['invoice']['discount_rate'] = numberClean($input['invoice']['discount_rate']);
        $input['invoice']['after_disc'] = numberClean($input['invoice']['after_disc']);
        $input['invoice']['total'] = numberClean($input['invoice']['total']);
        $input['invoice']['ship_tax_rate'] = numberClean($input['invoice']['ship_rate']);
        $input['invoice']['ship_tax'] = numberClean($input['invoice']['ship_tax']);
        $input['invoice']['extra_discount'] = $extra_discount;
        $input['invoice']['i_class'] = 1;
        $total_discount = $extra_discount;
        if ($input['invoice']['sub']) {
            $input['invoice']['i_class'] = 2;
            $input['invoice']['r_time'] = $input['invoice']['recur_after'];
            $input['invoice']['invoiceduedate'] = date("Y-m-d", strtotime($input['invoice']['invoicedate'] . " +" . $input['invoice']['r_time'] . 's'));
            unset($input['invoice']['recur_after']);
        } else {
            $input['invoice']['invoiceduedate'] = date_for_database($input['invoice']['invoiceduedate']);
        }
        $p = @$input['invoice']['p'];
        unset($input['invoice']['after_disc']);
        unset($input['invoice']['ship_rate']);
        unset($input['invoice']['sub']);
        unset($input['invoice']['p']);


        DB::beginTransaction();

        $existed=Draft::where('tid',$input['invoice']['tid']);
        if(@$existed->first()->tid) {$input['invoice']['tid']=Draft::latest()->first()->tid+1;}

        $result = Draft::create($input['invoice']);
        if ($result) {
            $products = array();
            $subtotal = 0;
            $total_qty = 0;
            $total_tax = 0;
            $stock_update = array();
            $serial_track = array();
            foreach ($input['invoice_items']['product_id'] as $key => $value) {

                $subtotal += numberClean(@$input['invoice_items']['product_price'][$key]) * numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_qty += numberClean(@$input['invoice_items']['product_qty'][$key]);
                $total_tax += numberClean(@$input['invoice_items']['total_tax'][$key]);
                $total_discount += numberClean(@$input['invoice_items']['total_discount'][$key]);
                if ($input['invoice_items']['serial'][$key]) $serial_track[] = array('rel_type' => 2, 'rel_id' => 1, 'ref_id' => $input['invoice_items']['product_id'][$key], 'value' => $input['invoice_items']['serial'][$key], 'value2' => $result->id);
                if ($input['invoice_items']['unit_m'][$key] > 1) {
                    $unit_val = $input['invoice_items']['unit_m'][$key];
                    $qty = $unit_val * numberClean($input['invoice_items']['product_qty'][$key]);
                } else {
                    $unit_val = 1;
                    $qty = numberClean($input['invoice_items']['product_qty'][$key]);
                }
                $products[] = array('invoice_id' => $result->id,
                    'product_id' => $input['invoice_items']['product_id'][$key],
                    'product_name' => @$input['invoice_items']['product_name'][$key],
                    'code' => @$input['invoice_items']['code'][$key],
                    'product_qty' => numberClean(@$input['invoice_items']['product_qty'][$key]),
                    'product_price' => numberClean(@$input['invoice_items']['product_price'][$key]),
                    'product_tax' => numberClean(@$input['invoice_items']['product_tax'][$key]),
                    'product_discount' => numberClean(@$input['invoice_items']['product_discount'][$key]),
                    'product_subtotal' => numberClean(@$input['invoice_items']['product_subtotal'][$key]),
                    'total_tax' => numberClean(@$input['invoice_items']['total_tax'][$key]),
                    'total_discount' => numberClean(@$input['invoice_items']['total_discount'][$key]),
                    'product_des' => @$input['invoice_items']['product_description'][$key],
                    'unit_value' => $unit_val,
                    'serial' => @$input['invoice_items']['serial'][$key],
                    'i_class' => 0,
                    'unit' => $input['invoice_items']['unit'][$key], 'ins' => $result->ins);
                $stock_update[] = array('id' => $input['invoice_items']['product_id'][$key], 'qty' => $qty);
            }

            DraftItem::insert($products);
            $invoice_d = Draft::find($result->id);
            $invoice_d->subtotal = $subtotal;
            $invoice_d->tax = $total_tax;
            $invoice_d->discount = $total_discount;
            $invoice_d->items = $total_qty;
            $invoice_d->save();


            DB::commit();
            return $result;
        }
        throw new GeneralException(trans('exceptions.backend.invoices.create_error'));
    }
}
