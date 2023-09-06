<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Pincode;

class District extends Model
{
    protected $connection= 'delivery_db';
    
    use HasFactory;

    protected $fillable = [
        'state_id', 
        'name',
    ];

    /**
     * Relationship
    */
    public function state(){
        return $this->belongsTo(State::class);
    }

    public function pincodes(){
        return $this->hasMany(Pincode::class);
    }

   
}
