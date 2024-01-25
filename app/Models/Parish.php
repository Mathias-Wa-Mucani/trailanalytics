<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    protected $primaryKey = 'pcode';
    protected $table = 'stp_admin_unit_d_parish';

    public function villages()
    {
        return $this->hasMany(Village::class, 'pcode');
    }
}
