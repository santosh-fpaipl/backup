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

use App\Models\SaleOrder;
use App\Models\StockColor;
use App\Models\Gdn;


class SoItem extends Model
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
        'sale_order_id',
        'stock_color_id',
        'sale_item_id',
        'quantity',
        'note',
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class);
    }

    public function stockColor(){
        return $this->belongsTo(StockColor::class);
    }

    public function gdn(){
        return $this->hasOne(Gdn::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'sale_order_id',
                'stock_color_id',
                'sale_item_id',
                'quantity',
                'note',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
