<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    // protected $connection = env('DMIS_DB_CONNECTION');
    protected $connection = DMIS_CONNECTION;
    protected $table = 'stp_financial_year';
}
