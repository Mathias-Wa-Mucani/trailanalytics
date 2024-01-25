<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $primaryKey = 'dcode';
    // protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_admin_unit_a_district';

    public function counties()
    {
        return $this->hasMany(County::class, 'dcode');
    }
}
