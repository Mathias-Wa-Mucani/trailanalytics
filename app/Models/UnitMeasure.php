<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitMeasure extends Model
{
    use SoftDeletes;

    protected $table = 'stp_dmis_unit_measure';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy((new static)->getTable() . '.name', 'asc');
        });
    }
}
