<?php

namespace App\Observers;

use App\Classes\ModelHelper;
use App\Models\OldPerson;

class OldPersonObserver
{
    /**
     * Handle the OldPerson "created" event.
     *
     * @param  \App\Models\OldPerson  $oldPerson
     * @return void
     */
    public function created(OldPerson $oldPerson)
    {
        //
    }

    public function creating(OldPerson $oldPerson)
    {
        $oldPerson->elder_number = ModelHelper::generateOpNumber($oldPerson);
        $oldPerson->created_by = auth()->user()->id;
    }

    public function saving(OldPerson $oldPerson)
    {
        $oldPerson->full_name = strtoupper($oldPerson->full_name);
    }

    /**
     * Handle the OldPerson "updated" event.
     *
     * @param  \App\Models\OldPerson  $oldPerson
     * @return void
     */
    public function updated(OldPerson $oldPerson)
    {
        //
    }

    /**
     * Handle the OldPerson "deleted" event.
     *
     * @param  \App\Models\OldPerson  $oldPerson
     * @return void
     */
    public function deleted(OldPerson $oldPerson)
    {
        //
    }

    /**
     * Handle the OldPerson "restored" event.
     *
     * @param  \App\Models\OldPerson  $oldPerson
     * @return void
     */
    public function restored(OldPerson $oldPerson)
    {
        //
    }

    /**
     * Handle the OldPerson "force deleted" event.
     *
     * @param  \App\Models\OldPerson  $oldPerson
     * @return void
     */
    public function forceDeleted(OldPerson $oldPerson)
    {
        //
    }
}
