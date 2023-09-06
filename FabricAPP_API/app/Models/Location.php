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

use App\Models\Bundle;
use App\Models\Godown;
use App\Models\Rack;
use App\Models\Level;

class Location extends Model
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
        'godown_id',
        'rack_id',
        'level_id'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function bundles(){

        return $this->hasMany(Bundle::class);
    }

    public function godown(){
        return $this->belongsTo(Godown::class);
    }

    public function rack(){
        return $this->belongsTo(Rack::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'name',
                'godown_id',
                'rack_id',
                'level_id', 
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}
