<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\Pincode;
use App\Models\Godown;

class Address extends Model
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        LogsActivity,
        ManageModel;

     /*
        Auto Generated Columns:
        id
    */

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'print',
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

    public function godown(){
        return $this->hasOne(Godown::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'addressable_type',
                'addressable_id',
                'print',
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
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
