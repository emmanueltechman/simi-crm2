<?php

namespace App\Repositories\Focus\event;

use App\Notifications\Rose;
use DB;
use Carbon\Carbon;
use App\Models\event\Event;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventRepository.
 */
class EventRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Event::class;

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
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        $input = array_map( 'strip_tags', $input);
        $input['start']=date_for_database($input['start']).' '.$input['time_from'];
        $input['end']=date_for_database($input['end']).' '.$input['time_to'];
        unset( $input['time_from']);
        unset( $input['time_to']);
        if (Event::create($input)) {
            $message = array('title' => trans('general.event') . ' - ' . $input['title'], 'icon' => 'fa-calendar', 'background' => 'bg-info', 'data' => \Illuminate\Support\Str::limit($input['description']));
             $notification = new Rose(auth()->user(), $message);
                auth()->user()->notify($notification);
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.events.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Event $event
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Event $event, array $input)
    {
        $input = array_map( 'strip_tags', $input);
    	if ($event->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.events.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Event $event
     * @throws GeneralException
     * @return bool
     */
    public function delete(Event $event)
    {
        if ($event->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.events.delete_error'));
    }
}
