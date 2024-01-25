<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ViewOldPersonApplication extends Model
{
    use SoftDeletes;
    protected $table = 'view_rec_c_application';
}
