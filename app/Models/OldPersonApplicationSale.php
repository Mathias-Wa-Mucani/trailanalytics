<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldPersonApplicationSale extends Model
{
    protected $table = 'rec_c_application_sales';

    protected $fillable = ['product_name', 'quantity', 'unit_price', 'expected_sales'];

    public function application()
    {
        return $this->belongsTo(OldPersonApplication::class, 'rec_c_application_id');
    }
    public function expectedSale()
    {
        return $this->quantity * $this->unit_price;
    }
}
