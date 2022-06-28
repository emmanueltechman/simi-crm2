<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\general;

use App\Models\Company\ConfigMeta;
use App\Models\items\MetaEntry;
use App\Models\project\ProjectLog;
use App\Models\project\ProjectMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     *customer_picture_path .
     *
     * @var string
     */
    protected $file_item_path;


    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->file_item_path = 'files' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }


    public function bill_attachment(Request $request)
    {
        $action = $request->only('op', 'id');
        if (@$action['op'] == 'delete') {
            $file_value = MetaEntry::find($action['id']);

            if (delete_file($this->file_item_path . $file_value['value'])) $file_value->delete();

            return response()->json(['success' => 'Deleted']);
        } else {
            $upload_setting = ConfigMeta::where('feature_id', '=', 9)->where('ins', '=', auth()->user()->ins)->first(array('feature_value', 'value1'));
            if ($upload_setting['feature_value']) {
                $itemName = $request->only('files');
                $item_rel = $request->only('id', 'bill');
                $request->validate([
                    'files' => 'required|mimes:' . $upload_setting['value1'],
                ]);
                $path = $this->file_item_path;

                $up = array();
                foreach ($itemName as $item) {
                    $name = $item->getClientOriginalName();
                    $file_name = strlen($name) > 20 ? substr($name, 0, 20) . '.' . $item->getClientOriginalExtension() : $name;
                    $file_name = time() . $file_name;
                    $this->storage->put($path . $file_name, file_get_contents($item->getRealPath()));
                    $bill_type = array('rel_type' => $item_rel['bill'], 'rel_id' => $item_rel['id'], 'value' => $file_name, 'ins' => auth()->user()->ins);
                    $upload = MetaEntry::create($bill_type);
                    $up[] = array('id' => $upload->id, 'name' => $file_name);
                }
                return response()->json($up);
            }
        }
    }

    public function project_attachment(Request $request)
    {
        $action = $request->only('op', 'id');
        if (project_access($action['id'])) {
            if (@$action['op'] == 'delete') {
                $file_value = ProjectMeta::find($action['id']);
                if (delete_file($this->file_item_path . $file_value['value'])) $file_value->delete();
                return response()->json(['success' => 'Deleted']);
            } else {
                $item_rel = $request->only('id', 'bill');
                $upload_setting = ConfigMeta::where('feature_id', '=', 9)->where('ins', '=', auth()->user()->ins)->first(array('feature_value', 'value1'));
                if ($upload_setting['feature_value']) {
                    $itemName = $request->only('files');
                    $request->validate([
                        'files' => 'required|mimes:' . $upload_setting['value1'],
                    ]);
                    $path = $this->file_item_path;
                    $bill_type = array();
                    $up = array();
                    foreach ($itemName as $item) {
                        $name = $item->getClientOriginalName();
                        $file_name = strlen($name) > 20 ? substr($name, 0, 20) . '.' . $item->getClientOriginalExtension() : $name;
                        $file_name = time() . $file_name;
                        $this->storage->put($path . $file_name, file_get_contents($item->getRealPath()));
                        $bill_type = array('project_id' => $item_rel['id'], 'meta_key' => 1, 'value' => $file_name);
                        $upload = ProjectMeta::create($bill_type);
                        $up[] = array('id' => $upload->id, 'name' => $file_name);
                    }
                    ProjectLog::create(array('project_id' => $upload->project_id, 'value' => '[' . trans('general.files') . '] ' . $upload->value));
                    return response()->json($up);
                }
            }
        }
    }

}
