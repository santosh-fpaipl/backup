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

use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\StockColor;
use App\Models\Bundle;

class PurchaseItem extends Model
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
        'purchase_id',
        'purchase_order_id',
        'stock_color_id',
        'width',
        'bundles_length',
        'rate',
        'total',
        'amount',
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function stockColor(){
        return $this->belongsTo(StockColor::class);
    }

    public function bundles(){
        return $this->hasMany(Bundle::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'purchase_id',
                'purchase_order_id',
                'stock_color_id',
                'width',
                'bundles_length',
                'rate',
                'total',
                'amount',
                'created_at', 
                'updated_at',
                'deleted_at' 
            ])
            ->useLogName('model_log');
    }
}

