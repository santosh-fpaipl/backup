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


use App\Models\PurchaseItem; 
use App\Models\Grn;
use App\Models\Location;
use App\Models\BundleUsage;
use App\Models\SaleItem;
use App\Models\StockItem;
use App\Models\StockColor;

class Bundle extends Model
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
        'grn_id',
        'purchase_item_id',
        'stock_color_id',
        'stock_item_id',
        'gdn_id',
        'singleuse',
        'original',
        'quantity',
        'available',
        'location_id'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function grn(){
        return $this->belongsTo(Grn::class);
    }

    public function purchaseItem(){
        return $this->belongsTo(PurchaseItem::class);
    }

    public function saleItem(){
        return $this->belongsTo(SaleItem::class);
    }

    public function stockColor(){
        return $this->belongsTo(StockColor::class);
    }

    public function stockItem(){
        return $this->belongsTo(StockItem::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function bundleUsages(){
        return $this->hasMany(BundleUsage::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'grn_id',
                'purchase_item_id',
                'stock_color_id',
                'stock_item_id',
                'gdn_id',
                'singleuse',
                'original',
                'quantity',
                'available',
                'location_id', 
                'created_at', 
                'updated_at', 
            ])
            ->useLogName('model_log');
    }
}
