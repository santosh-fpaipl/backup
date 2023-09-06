<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageMedia;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\ManageTag;
use Fpaipl\Panel\Traits\Authx;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class JobWorkOrder extends Model 
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

    // Properties

   //const INDEXABLE = false;

    /*
        Auto Generated Columns:
        id
        slug
    */
    protected $fillable = [
        'product_id', 
        'fabricator_id',
        'jwoi',
        'quantity',
        'quantities',
        'message',
        'expected_at',
        'status',
    ];
    
    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];
    
    protected $dependency = [];


    public function hasDependency(){
        return count($this->dependency);
    }

    public function getDependency(){
        return $this->dependency;
    }

   
    // Helper Functions
   

    // Relationships
    
    

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                    'id', 
                    'product_id', 
                    'fabricator_id',
                    'jwoi',
                    'quantity',
                    'quantities',
                    'message',
                    'expected_at',
                    'status',
                    'created_at', 
                    'updated_at', 
                    'deleted_at'
            ])->useLogName('model_log');
    }
}
