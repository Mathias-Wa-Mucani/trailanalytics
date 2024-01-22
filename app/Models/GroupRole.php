<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_group_role';
}
