<?php

namespace App\Observers;

use App\Classes\ModelHelper;
use App\Models\OpGroupRegistration;

class OpGroupRegistrationObserver
{
    /**
     * Handle the OpGroupRegistration "created" event.
     *
     * @param  \App\Models\OpGroupRegistration  $opGroupRegistration
     * @return void
     */
    public function created(OpGroupRegistration $opGroupRegistration)
    {
        //
    }

    public function creating(OpGroupRegistration $opGroupRegistration)
    {
        $opGroupRegistration->group_number = ModelHelper::generateGroupNumber($opGroupRegistration);
        $opGroupRegistration->created_by = auth()->user()->id;
    }

    /**
     * Handle the OpGroupRegistration "updated" event.
     *
     * @param  \App\Models\OpGroupRegistration  $opGroupRegistration
     * @return void
     */
    public function updated(OpGroupRegistration $opGroupRegistration)
    {
        //
    }

    /**
     * Handle the OpGroupRegistration "deleted" event.
     *
     * @param  \App\Models\OpGroupRegistration  $opGroupRegistration
     * @return void
     */
    public function deleted(OpGroupRegistration $opGroupRegistration)
    {
        //
    }

    /**
     * Handle the OpGroupRegistration "restored" event.
     *
     * @param  \App\Models\OpGroupRegistration  $opGroupRegistration
     * @return void
     */
    public function restored(OpGroupRegistration $opGroupRegistration)
    {
        //
    }

    /**
     * Handle the OpGroupRegistration "force deleted" event.
     *
     * @param  \App\Models\OpGroupRegistration  $opGroupRegistration
     * @return void
     */
    public function forceDeleted(OpGroupRegistration $opGroupRegistration)
    {
        //
    }
}
