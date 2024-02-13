<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $table = 'rec_c_application_budget';

    public function total()
    {
        return $this->quantity * $this->unit_price;
    }

    public function unit_measure()
    {
        return $this->belongsTo(UnitMeasure::class, 'stp_unit_measure_id');
    }
}
