<?php

namespace App\Repositories\Focus\note;

use DB;
use Carbon\Carbon;
use App\Models\note\Note;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NoteRepository.
 */
class NoteRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Note::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        $q = $this->query();
        if (request('p')) {
            $q->whereHas('project', function ($s) {
                return $s->where('project_id', '=', request('p', 0));
            });
        } else {
            $q->where('section', '=',0);
        }
        return $q->get(['id','title','created_at']);
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

         $input['title'] = strip_tags( $input['title']);
         $input['content'] = clean(html_entity_decode($input['content']),'purifier.settings.custom_definition');
        if (Note::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.notes.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Note $note
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Note $note, array $input)
    {
          $input['title'] = strip_tags( $input['title']);
           $input['content'] = clean(html_entity_decode($input['content']),'purifier.settings.custom_definition');
        if ($note->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.notes.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Note $note
     * @return bool
     * @throws GeneralException
     */
    public function delete(Note $note)
    {
        $note->project()->delete();
        if ($note->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.notes.delete_error'));
    }
}
