<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\Address;

class Godown extends Model
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        ManageModel,
        ManageTag;

    // Properties

   //const INDEXABLE = false;

    /*
        Auto Generated Columns:
        id
    */
    protected $fillable = [
        'name',
        'address_id',
        'used',
        'capacity'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function address(){
        return $this->belongsTo(Address::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'name',
                'address_id',
                'used',
                'capacity', 
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}
