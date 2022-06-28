<?php

namespace App\Repositories\Focus\template;

use DB;
use Carbon\Carbon;
use App\Models\template\Template;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateRepository.
 */
class TemplateRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Template::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get(['id','title','category','info']);
    }



    /**
     * For updating the respective Model in storage
     *
     * @param Template $template
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Template $template, array $input)
    {
         $input['body'] = clean(html_entity_decode($input['body']),'purifier.settings.custom_definition');
            $input['title'] = strip_tags( $input['title']);
    	if ($template->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.templates.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Template $template
     * @throws GeneralException
     * @return bool
     */
    public function delete(Template $template)
    {
        if ($template->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.templates.delete_error'));
    }
}
