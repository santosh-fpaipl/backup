<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\Country;

class State extends Model
{
    protected $connection= 'delivery_db';
    
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
    ];
   
    /**
     * Relationship
    */

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function districts(){
        return $this->hasMany(District::class);
    }
}
