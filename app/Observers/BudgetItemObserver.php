<?php

namespace App\Observers;

use App\Models\BudgetItem;

class BudgetItemObserver
{
    /**
     * Handle the BudgetItem "created" event.
     *
     * @param  \App\Models\BudgetItem  $budgetItem
     * @return void
     */
    public function created(BudgetItem $budgetItem)
    {
        //
    }

    /**
     * Handle the BudgetItem "updated" event.
     *
     * @param  \App\Models\BudgetItem  $budgetItem
     * @return void
     */
    public function updated(BudgetItem $budgetItem)
    {
        //
    }

    public function saving(BudgetItem $budgetItem)
    {
        $budgetItem->total = $budgetItem->quantity * $budgetItem->unit_price;
        $budgetItem->comments = $budgetItem->comments  ?? ' ';
    }


    /**
     * Handle the BudgetItem "deleted" event.
     *
     * @param  \App\Models\BudgetItem  $budgetItem
     * @return void
     */
    public function deleted(BudgetItem $budgetItem)
    {
        //
    }

    /**
     * Handle the BudgetItem "restored" event.
     *
     * @param  \App\Models\BudgetItem  $budgetItem
     * @return void
     */
    public function restored(BudgetItem $budgetItem)
    {
        //
    }

    /**
     * Handle the BudgetItem "force deleted" event.
     *
     * @param  \App\Models\BudgetItem  $budgetItem
     * @return void
     */
    public function forceDeleted(BudgetItem $budgetItem)
    {
        //
    }
}
