<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clocking extends Model
{

    protected $table = 'clocking';

    use HasFactory;
    protected $fillable = [
        'time_in',
        'time_out',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'flag',
        'creator_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function documentable()
    {
        return $this->morphTo();
    }
}
