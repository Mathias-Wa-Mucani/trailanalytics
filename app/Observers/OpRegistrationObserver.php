<?php

namespace App\Observers;

use App\Classes\ModelHelper;
use App\Models\OpRegistration;

class OpRegistrationObserver
{
    /**
     * Handle the OpRegistration "created" event.
     *
     * @param  \App\Models\OpRegistration  $opRegistration
     * @return void
     */
    public function created(OpRegistration $opRegistration)
    {
        //
    }

    public function creating(OpRegistration $opRegistration)
    {
        $opRegistration->elder_number = ModelHelper::generateOpNumber($opRegistration);
        $opRegistration->created_by = auth()->user()->id;
    }

    public function saving(OpRegistration $opRegistration)
    {
        $opRegistration->dmis_educ_level_id = $opRegistration->stp_educ_level_id;
    }

    /**
     * Handle the OpRegistration "updated" event.
     *
     * @param  \App\Models\OpRegistration  $opRegistration
     * @return void
     */
    public function updated(OpRegistration $opRegistration)
    {
        //
    }

    /**
     * Handle the OpRegistration "deleted" event.
     *
     * @param  \App\Models\OpRegistration  $opRegistration
     * @return void
     */
    public function deleted(OpRegistration $opRegistration)
    {
        //
    }

    /**
     * Handle the OpRegistration "restored" event.
     *
     * @param  \App\Models\OpRegistration  $opRegistration
     * @return void
     */
    public function restored(OpRegistration $opRegistration)
    {
        //
    }

    /**
     * Handle the OpRegistration "force deleted" event.
     *
     * @param  \App\Models\OpRegistration  $opRegistration
     * @return void
     */
    public function forceDeleted(OpRegistration $opRegistration)
    {
        //
    }
}
