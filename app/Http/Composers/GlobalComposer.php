<?php

namespace App\Http\Composers;



use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', access()->user());
        $view->with('active_path',Request::segment(1));
    }
}
