<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\Pincode;

class Address extends Model
{
    use
        HasFactory,
        SoftDeletes;

     /*
        Auto Generated Columns:
        id
    */

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'print',
        'gstn',
        'fname',
        'lname',
        'contacts',
        'line1',
        'line2',
        'district',
        'state',
        'country',
        'pincode',
        'district_id',
        'state_id',
        'pincode_id'
    ];
    
    /**
    * Relationship
    */

   /**
     * Get the parent transactionable model (customer or supplier).
    */

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function pincode(){
        return $this->belongsTo(Pincode::class);
    }

   

    
}
