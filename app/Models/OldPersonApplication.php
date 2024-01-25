<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OldPersonApplication extends Model
{
    use SoftDeletes;
    protected $table = 'rec_c_application';

    public function group()
    {
        return $this->belongsTo(OldPersonGroup::class, 'rec_b_group_id');
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class, 'dmis_bank_id');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function budget_items()
    {
        // return $this->morphMany(BudgetItem::class, 'budgetable');
        return $this->hasMany(BudgetItem::class, 'rec_c_application_id');
    }

    public function budgetTotal()
    {
        return $this->budget_items()->select(DB::raw('sum(quantity * unit_price) as total'))->first()->total;
    }

    public function sales_projections()
    {
        return $this->hasMany(OldPersonApplicationSale::class, 'rec_c_application_id');
    }

    public function salesProjectionsTotal()
    {
        return $this->sales_projections()->select(DB::raw('sum(quantity * unit_price) as total'))->first()->total;
    }

    public function grossProfit()
    {
        return $this->salesProjectionsTotal() - $this->budgetTotal();
    }
}
