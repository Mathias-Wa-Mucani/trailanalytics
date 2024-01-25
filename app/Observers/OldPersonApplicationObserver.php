<?php

namespace App\Observers;

use App\Models\OldPersonApplication;

class OldPersonApplicationObserver
{
    /**
     * Handle the OldPersonApplication "created" event.
     *
     * @param  \App\Models\OldPersonApplication  $oldPersonApplication
     * @return void
     */
    public function created(OldPersonApplication $oldPersonApplication)
    {
        //
    }

    public function saving(OldPersonApplication $oldPersonApplication)
    {
        if (!$oldPersonApplication->total_budget) {
            $oldPersonApplication->total_budget = 0;
        }
    }

    /**
     * Handle the OldPersonApplication "updated" event.
     *
     * @param  \App\Models\OldPersonApplication  $oldPersonApplication
     * @return void
     */
    public function updated(OldPersonApplication $oldPersonApplication)
    {
        //
    }

    /**
     * Handle the OldPersonApplication "deleted" event.
     *
     * @param  \App\Models\OldPersonApplication  $oldPersonApplication
     * @return void
     */
    public function deleted(OldPersonApplication $oldPersonApplication)
    {
        //
    }

    /**
     * Handle the OldPersonApplication "restored" event.
     *
     * @param  \App\Models\OldPersonApplication  $oldPersonApplication
     * @return void
     */
    public function restored(OldPersonApplication $oldPersonApplication)
    {
        //
    }

    /**
     * Handle the OldPersonApplication "force deleted" event.
     *
     * @param  \App\Models\OldPersonApplication  $oldPersonApplication
     * @return void
     */
    public function forceDeleted(OldPersonApplication $oldPersonApplication)
    {
        //
    }
}
