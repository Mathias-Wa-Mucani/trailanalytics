<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcounty extends Model
{
    protected $primaryKey = 'scode';
    protected $table = 'stp_admin_unit_c_subcounty';

    public function parishes()
    {
        return $this->hasMany(Parish::class, 'scode');
    }
}
