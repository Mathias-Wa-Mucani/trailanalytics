<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class OldPerson extends Model
{
    use SoftDeletes, BelongsToThrough;
    protected $table = 'rec_a_elder';

    public function village()
    {
        return @$this->belongsTo(Village::class, 'vcode', 'vcode');
    }

    public function getContactInfoAttribute()
    {
        return json_decode($this->contact);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable', 'documentable_name', 'documentable_id');
    }
}
