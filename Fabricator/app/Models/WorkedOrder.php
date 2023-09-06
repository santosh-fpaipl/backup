<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageMedia;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\FabricProc;

class WorkedOrder extends Model 
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        ManageMedia,
        ManageModel,
        ManageTag;

    /*
        Auto Generated Columns:
        id
    */

    protected $fillable = [
        'productId',
        'name',
        'thumb',
        'images',
        'code',
        'quantity',
        'stage',
        'status',
        'locked',
        'fcpu',
        'sizes',
        'colors',
        'quantities',
        'final',
    ];

    public function getFillables() {
        return $this->fillable;
    } 

    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];

    protected $dependency = [];

    //public static function INDEXABLE(){
    //     return false;
    //}

    public function hasDependency()
    {
        return count($this->dependency);
    }

    public function getDependency()
    {
        return $this->dependency;
    }

    /**
    * Relationship 
    */

    public function fabricProcurement(){

        return $this->hasOne(FabricProc::class);

    }

    /**
    * End of Relationship
    */

    

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'productId',
                'name',
                'thumb',
                'images',
                'code',
                'quantity',
                'stage',
                'status',
                'locked',
                'fcpu',
                'sizes',
                'colors',
                'quantities',
                'final',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
