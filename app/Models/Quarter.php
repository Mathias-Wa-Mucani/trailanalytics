<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_quarter';
}
