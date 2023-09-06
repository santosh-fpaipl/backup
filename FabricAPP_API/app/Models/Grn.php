<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\ManageTag;
use Fpaipl\Panel\Traits\Authx;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Models\Bundle;
use App\Models\QcReport;


class Grn extends Model
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
        'grnid',
        'stock_color_id',
        'quantity',
        'draft',
        'status',
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function bundles(){
        return $this->hasMany(Bundle::class);
    }

    public function qcReport(){
        return $this->hasOne(QcReport::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'grnid',
                'stock_color_id',
                'quantity',
                'draft',
                'status', 
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}
