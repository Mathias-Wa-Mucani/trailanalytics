<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OldPersonGroup extends Model
{
    use SoftDeletes;
    protected $table = 'rec_b_group';

    public function district()
    {
        // return $this->belongsTo(District::class, '');
    }

    public function getContactInfoAttribute()
    {
        return json_decode($this->contact);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable', 'documentable_name', 'documentable_id');
    }

    public function village()
    {
        return @$this->belongsTo(Village::class, 'vcode', 'vcode');
    }

    public function members()
    {
        return $this->hasMany(OldPersonGroupMember::class, 'rec_b_group_id')->with(['older_person']);
    }

    public function members_list()
    {
        // return $this->belongsToMany(GroupRole::class, 'pwd_grp_b_member', 'pwd_grp_a_registration_id', 'stp_group_role_id')->withPivot(['stp_group_role_id']);
    }
}
