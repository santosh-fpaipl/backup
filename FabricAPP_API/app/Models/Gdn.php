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
use App\Models\SaleOrder;
use App\Models\StockColor;
use App\Models\SoItem;
use App\Models\BundleUsage;
use Mockery\Undefined;

class Gdn extends Model
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
        'gdnid',
        'stock_color_id',
        'so_item_id',
        'width',
        'quantity',
        'draft',
        'status',
        'sale_item_id',
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function bundles(){
        return $this->hasMany(Bundle::class);
    }

    public function qcReport(){
        return $this->hasOne(QcReport::class);
    }

    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class);
    }

    public function stockColor(){
        return $this->belongsTo(stockColor::class);
    }

    public function soItem(){
        return $this->belongsTo(SoItem::class);
    }

    public function bundleUsages(){
        return $this->hasMany(BundleUsage::class);
    }

    public function hasPartiallyUsedBundle()
    {
        return $this->bundleUsages->count();
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'gdnid',
                'stock_color_id',
                'so_item_id',
                'width',
                'quantity',
                'draft',
                'status',
                'sale_item_id', 
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}
