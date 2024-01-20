<?php

namespace App\Traits;

trait WithWhereHas
{
    public function scopeWithWhereHas($query, $relationships, $conditions)
    {
        $query->with($relationships, $conditions)
            ->whereHas($relationships, $conditions);
    }
}
