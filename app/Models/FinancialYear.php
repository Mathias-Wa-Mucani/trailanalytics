<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    // protected $connection = env('DMIS_DB_CONNECTION');
    protected $table = 'stp_dmis_financial_year';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy((new static)->getTable() . '.name', 'asc');
        });
    }
}
