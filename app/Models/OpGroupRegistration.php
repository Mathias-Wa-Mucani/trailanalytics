<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpGroupRegistration extends Model
{
    use SoftDeletes;
    protected $table = 'rec_b_group';

    public function district()
    {
        // return $this->belongsTo(District::class, '');
    }
}
