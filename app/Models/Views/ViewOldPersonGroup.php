<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViewOldPersonGroup extends Model
{
    use SoftDeletes;
    protected $table = 'view_rec_b_group';

    public function getContactInfoAttribute()
    {
        return json_decode($this->contact);
    }
}
