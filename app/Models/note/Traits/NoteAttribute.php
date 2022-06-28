<?php

namespace App\Models\note\Traits;

/**
 * Class NoteAttribute.
 */
trait NoteAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/5.4/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '
         '.$this->getViewButtonAttribute("note-manage", "biller.notes.show").'
                '.$this->getEditButtonAttribute("note-data", "biller.notes.edit").'
                '.$this->getDeleteButtonAttribute("note-data", "biller.notes.destroy",'table').'
                ';
    }
}
