<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldPersonGroupMember extends Model
{
    protected $table = 'rec_b_group_member';
    // public $timestamps = false;

    const UPDATED_AT = null;

    public function older_person()
    {
        return $this->belongsTo(OldPerson::class, 'rec_a_elder_id');
    }
}
