<?php

namespace App\Repositories\Focus\tag;

use DB;
use Carbon\Carbon;
use App\Models\tag\Tag;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TagRepository.
 */
class TagRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Tag::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        $q = $this->query();
        if (request('module') == 'task') {
            $q->where('section', '=', 2);
        } else {
            $q->where('section', '=', 1);
        }
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
        $input = array_map( 'strip_tags', $input);
        if (Tag::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.tags.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Tag $tag
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Tag $tag, array $input)
    {
        $input = array_map( 'strip_tags', $input);
        if ($tag->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.tags.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Tag $tag
     * @return bool
     * @throws GeneralException
     */
    public function delete(Tag $tag)
    {
        if ($tag->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.tags.delete_error'));
    }
}
