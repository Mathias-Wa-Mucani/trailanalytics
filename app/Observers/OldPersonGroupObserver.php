<?php

namespace App\Observers;

use App\Classes\ModelHelper;
use App\Models\OldPersonGroup;

class OldPersonGroupObserver
{
    /**
     * Handle the OldPersonGroup "created" event.
     *
     * @param  \App\Models\OldPersonGroup  $oldPersonGroup
     * @return void
     */
    public function created(OldPersonGroup $oldPersonGroup)
    {
        //
    }

    public function creating(OldPersonGroup $oldPersonGroup)
    {
        $oldPersonGroup->group_number = ModelHelper::generateGroupNumber($oldPersonGroup);
        $oldPersonGroup->created_by = auth()->user()->id;
    }

    /**
     * Handle the OldPersonGroup "updated" event.
     *
     * @param  \App\Models\OldPersonGroup  $oldPersonGroup
     * @return void
     */
    public function updated(OldPersonGroup $oldPersonGroup)
    {
        //
    }

    /**
     * Handle the OldPersonGroup "deleted" event.
     *
     * @param  \App\Models\OldPersonGroup  $oldPersonGroup
     * @return void
     */
    public function deleted(OldPersonGroup $oldPersonGroup)
    {
        //
    }

    /**
     * Handle the OldPersonGroup "restored" event.
     *
     * @param  \App\Models\OldPersonGroup  $oldPersonGroup
     * @return void
     */
    public function restored(OldPersonGroup $oldPersonGroup)
    {
        //
    }

    /**
     * Handle the OldPersonGroup "force deleted" event.
     *
     * @param  \App\Models\OldPersonGroup  $oldPersonGroup
     * @return void
     */
    public function forceDeleted(OldPersonGroup $oldPersonGroup)
    {
        //
    }
}
