<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $primaryKey = 'ccode';
    protected $table = 'stp_admin_unit_b_county';

    public function subcounties()
    {
        return $this->hasMany(SubCounty::class, 'ccode');
    }
}
