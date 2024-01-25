<?php

namespace App\Models\Dmis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmisFinancialYear extends Model
{
    protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_financial_year';
}
