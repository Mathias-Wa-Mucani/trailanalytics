<?php

namespace App\Models\Dmis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmisProjectIndustry extends Model
{
    protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_project_industry';
}
