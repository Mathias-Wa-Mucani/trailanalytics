<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpRegistration extends Model
{
    use SoftDeletes;
    protected $table = 'rec_a_elder';
}
