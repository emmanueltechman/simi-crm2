<?php

namespace App\Repositories\Focus\term;

use DB;
use Carbon\Carbon;
use App\Models\term\Term;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TermRepository.
 */
class TermRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Term::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {

        return $this->query()
            ->get();
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
            $input['terms'] = clean($input['terms']);
        if (Term::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.terms.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Term $term
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Term $term, array $input)
    {
         $input['title'] = strip_tags( $input['title']);
            $input['terms'] = clean($input['terms']);
        if ($term->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.terms.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Term $term
     * @return bool
     * @throws GeneralException
     */
    public function delete(Term $term)
    {
        $flag = true;
        if (!$term->type) {
            $available = Term::whereType(0)->get(['id'])->count('*');
            if ($available < 2) {
                $flag = false;
            }
        }

        if ($flag) {
            if ($term->delete()) {
                return true;
            }
        }
        return false;

    }
}
