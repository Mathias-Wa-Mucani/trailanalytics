<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

class Village extends Model
{
    use BelongsToThrough;
    protected $primaryKey = 'vcode';
    protected $table = 'stp_admin_unit_e_village';

    public function record_district()
    {
        return $this->belongsToThrough(District::class, [County::class, Subcounty::class, Parish::class, Village::class], null, '', [District::class => 'dcode', County::class => 'ccode', Subcounty::class => 'scode', Parish::class => 'pcode', Village::class => 'vcode']);
    }

    public function record_county()
    {
        return $this->belongsToThrough(County::class, [Subcounty::class, Parish::class, Village::class], null, '', [County::class => 'ccode', Subcounty::class => 'scode', Parish::class => 'pcode', Village::class => 'vcode']);
    }

    public function record_subcounty()
    {
        return $this->belongsToThrough(Subcounty::class, [Parish::class, Village::class], null, '', [Subcounty::class => 'scode', Parish::class => 'pcode', Village::class => 'vcode']);
    }

    public function record_parish()
    {
        return $this->belongsToThrough(Parish::class, Village::class, null, '', [Parish::class => 'pcode', Village::class => 'vcode']);

        // return $this->belongsToThrough(
        //     Parish::class,
        //     [Parish::class => 'pcode', Village::class => 'vcode'],
        //     foreignKeyLookup: [Parish::class => 'custom_user_id']
        // );

        // return $this->belongsToThrough(
        //     Parish::class,
        //     Village::class,
        //     // [Parish::class => 'pcode', Village::class => 'vcode'],
        //     foreignKeyLookup: [Parish::class => 'pcod', Village::class => 'pcode'],
        //     // localKeyLookup: [Parish::class => 'address_id'],
        // );

        // return $this->belongsToThrough(
        //     Parish::class,
        //     Village::class,
        //     [Parish::class => 'pcode', Village::class => 'vcode']
        // );

        // return $this->belongsToThrough(Parish::class, Village::class, null, '', [Parish::class => 'pcode', Village::class => 'vcode']);

    }
}
