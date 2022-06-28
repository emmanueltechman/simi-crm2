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
namespace App\Http\Controllers\Focus\template;

use App\Http\Requests\Focus\general\ManageCompanyRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Focus\template\TemplateRepository;
use App\Http\Requests\Focus\template\ManageTemplateRequest;

/**
 * Class TemplatesTableController.
 */
class TemplatesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TemplateRepository
     */
    protected $template;

    /**
     * contructor to initialize repository object
     * @param TemplateRepository $template ;
     */
    public function __construct(TemplateRepository $template)
    {
        $this->template = $template;
    }

    /**
     * This method return the data of the model
     * @param ManageTemplateRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageCompanyRequest $request)
    {
        //
        $core = $this->template->getForDataTable();
        return Datatables::of($core)
            ->escapeColumns(['id'])
            ->addIndexColumn()
            ->addColumn('info', function ($template) {

                return trans('templates.' . $template->info);
            })
            ->addColumn('category', function ($template) {
                if ($template->category == 1) return 'Email';
                return 'SMS';
            })
            ->addColumn('created_at', function ($template) {
                return dateFormat($template->created_at);
            })
            ->addColumn('actions', function ($template) {
                return $template->action_buttons;
            })
            ->make(true);
    }
}
