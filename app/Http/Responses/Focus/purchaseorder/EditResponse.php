<?php

namespace App\Http\Responses\Focus\purchaseorder;
use App\Models\customfield\Customfield;
use App\Models\items\CustomEntry;
use App\Models\market\ChannelBill;
use App\Models\market\SalesChannel;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\purchaseorder\Purchaseorder
     */
    protected $purchaseorders;

    /**
     * @param App\Models\purchaseorder\Purchaseorder $purchaseorders
     */
    public function __construct($purchaseorders)
    {
        $this->purchaseorders = $purchaseorders;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {

           $fields = Customfield::where('module_id', 9)->get()->groupBy('field_type');
        $fields_raw = array();

        if (isset($fields['text'])) {
            foreach ($fields['text'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 9)->where('rid', '=', $this->purchaseorders->id)->first();
                $fields_raw['text'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }
        if (isset($fields['number'])) {
            foreach ($fields['number'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 9)->where('rid', '=', $this->purchaseorders->id)->first();
                $fields_raw['number'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }

        $fields_data = custom_fields($fields_raw);
         $salesChannels=SalesChannel::all();
         $current_salesChannel=ChannelBill::where('bill_id','=',$this->purchaseorders->id)->where('ref','=',2)->first();

        return view('focus.purchaseorders.edit')->with([
            'purchaseorders' => $this->purchaseorders])->with(bill_helper(3))->with(['fields_data' => $fields_data,'salesChannels'=>$salesChannels,'current_salesChannel'=>$current_salesChannel]);
    }
}