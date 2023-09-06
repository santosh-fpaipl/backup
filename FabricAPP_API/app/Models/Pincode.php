<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class Pincode extends Model
{
    protected $connection= 'delivery_db';
    use HasFactory;

    protected $fillable = [
        'country_id',
        'state_id',
        'district_id',
        'circle_name',
        'region_name',
        'division_name',
        'office_name',
        'pincode',
        'office_type',
        'delivery'
    ];

    public function getRouteKeyName()
    {
        return 'pincode';
    }

    /**
    * Relationship
    */

    public function district(){
        return $this->belongsTo(District::class);
    }
}
