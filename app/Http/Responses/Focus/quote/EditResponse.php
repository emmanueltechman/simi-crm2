<?php

namespace App\Http\Responses\Focus\quote;
use App\Models\customfield\Customfield;
use App\Models\items\CustomEntry;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\quote\Quote
     */
    protected $quotes;

    /**
     * @param App\Models\quote\Quote $quotes
     */
    public function __construct($quotes)
    {
        $this->quotes = $quotes;
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

           $fields = Customfield::where('module_id','=',4)->get()->groupBy('field_type');
        $fields_raw = array();

        if (isset($fields['text'])) {
            foreach ($fields['text'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 4)->where('rid', '=', $this->quotes->id)->first();
                $fields_raw['text'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }
        if (isset($fields['number'])) {
            foreach ($fields['number'] as $row) {
                $data = CustomEntry::where('custom_field_id', '=', $row['id'])->where('module', '=', 4)->where('rid', '=', $this->quotes->id)->first();
                $fields_raw['number'][] = array('id' => $row['id'], 'name' => $row['name'], 'default_data' => $data['data']);
            }
        }

        $fields_data = custom_fields($fields_raw);

        return view('focus.quotes.edit')->with([
            'quotes' => $this->quotes])->with(bill_helper(2))->with(['fields_data' => $fields_data]);
    }
}