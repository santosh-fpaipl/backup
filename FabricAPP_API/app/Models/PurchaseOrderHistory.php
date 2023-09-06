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

use App\Models\User;
use App\Models\PurchaseOrder;

class PurchaseOrderHistory extends Model
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
        'purchase_order_id',
        'rate',
        'quantity',
        'variation',
        'payment_terms',
        'delivery_terms',
        'quality_terms',
        'general_terms',
        'changer'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function changer(){
        return $this->belongsTo(User::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'purchase_order_id',
                'rate',
                'quantity',
                'variation',
                'payment_terms',
                'delivery_terms',
                'quality_terms',
                'general_terms',
                'changer',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}

