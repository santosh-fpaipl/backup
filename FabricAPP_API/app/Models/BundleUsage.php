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
use App\Models\SaleItem;
use App\Models\Gdn;

class BundleUsage extends Model
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
        'bundle_id',
        'opening',
        'used',
        'closing',
        'sale_item_id',
        'gdn_id'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function bundle(){
        return $this->belongsTo(Bundle::class);
    }

    public function gdn(){
        return $this->belongsTo(Gdn::class);
    }

    public function saleItem(){
        return $this->belongsTo(SaleItem::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'bundle_id',
                'opening',
                'used',
                'closing',
                'sale_item_id',
                'gdn_id',
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}

