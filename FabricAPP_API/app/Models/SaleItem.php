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

use App\Models\SaleOrder;
use App\Models\Sale;
use App\Models\StockColor;

class SaleItem extends Model
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
        'sale_id',
        'quantity',
        'rate',
        'total',
        'tax',
        'amount'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function saleOrder(){
        return $this->belongsTo(SaleOrder::class);
    }

    public function sale(){
        return $this->belongsTo(Sale::class);
    }

    public function stockColor(){
        return $this->belongsTo(StockColor::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'sale_id',
                'quantity',
                'rate',
                'total',
                'tax',
                'amount', 
                'created_at', 
                'updated_at',
                'deleted_at' 
            ])
            ->useLogName('model_log');
    }
}
