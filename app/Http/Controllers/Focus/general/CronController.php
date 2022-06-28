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
use App\Models\misc\Misc;
use App\Repositories\Focus\general\CompanyRepository;
use Illuminate\Http\Request;
use App\Http\Responses\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Models\Company\Company;
use App\Http\Responses\ViewResponse;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    /**
     * variable to store the repository object
     * @var CompanyRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CompanyRepository $repository ;
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(ManageCompanyRequest $request)
    {
        if (single_ton()) {
            $urls = array();
            $action = true;
            $key = ConfigMeta::where('feature_id', '=', 6)->first();

            $urls[] = array('id' => 1, 'title' => trans('meta.subscription_cron'), 'url' => route('biller.cron.jobs', ['subscription']) . '?token=' . $key->value2, 'btn' => 'purple', 'time' => '24H');
            $urls[] = array('id' => 2, 'title' => trans('meta.due_cron'), 'url' => route('biller.cron.jobs', ['due_email_alert']) . '?token=' . $key->value2, 'btn' => 'info', 'time' => '24H');
            $urls[] = array('id' => 3, 'title' => trans('meta.expired_cron'), 'url' => route('biller.cron.jobs', ['expired_products']) . '?token=' . $key->value2, 'btn' => 'danger', 'time' => '24H');
            $urls[] = array('id' => 4, 'title' => trans('meta.low_stock_cron'), 'url' => route('biller.cron.jobs', ['low_stock_products']) . '?token=' . $key->value2, 'btn' => 'success', 'time' => '24H');
            $urls[] = array('id' => 5, 'title' => trans('currencies.currency_exchange'), 'url' => route('biller.cron.jobs', ['currency_exchange']) . '?token=' . $key->value2, 'btn' => 'purple', 'time' => '24H');
              $urls[] = array('id' => 6, 'title' => trans('en.pending_to_due'), 'url' => route('biller.cron.jobs', ['due_marker']) . '?token=' . $key->value2, 'btn' => 'info', 'time' => '24H');
                 $urls[] = array('id' => 7, 'title' => trans('en.due_to_overdue'), 'url' => route('biller.cron.jobs', ['overdue_marker']) . '?token=' . $key->value2, 'btn' => 'danger', 'time' => '24H');


            if ($request->update) {

                $key->value2 = rand(1000000, 999999999);
                $key->save();
                return new RedirectResponse(route('biller.cron'), ['flash_success' => trans('meta.cron_updated')]);

            }
            if ($request->get('recache')) {
                Artisan::call('route:clear');
                session()->flash( trans('flash_success'),'Routes refreshed!');
            }
            return new ViewResponse('focus.general.cron', compact('urls', 'action', 'key'));
        }
        return new ViewResponse('focus.general.not_applicable');
    }


}
