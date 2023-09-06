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

use App\Models\Supplier;
use App\Models\Stock;
use App\Models\PurchaseOrderHistory;
use App\Models\PoItem;
use App\Models\PurchaseItem;


class PurchaseOrder extends Model
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
        'supplier_id',
        'po_id',
        'stock_id',
        'rate',
        'quantity',
        'variation',
        'payment_terms',
        'delivery_terms',
        'quality_terms',
        'general_terms',
        'approved',
        'issuer',
        'approver',
        'approved_at',
        'duedate_at',
        'tags',
        'pending'
    ];
    
    
    // Helper Functions
   
    // Relationships

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function purchaseOrderHistories(){
        return $this->hasMany(PurchaseOrderHistory::class);
    }

    public function poItems(){
        return $this->hasMany(PoItem::class);
    }

    public function purchaseItem(){
        return $this->hasOne(PurchaseItem::class);
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'supplier_id',
                'po_id',
                'stock_id',
                'rate',
                'quantity',
                'variation',
                'payment_terms',
                'delivery_terms',
                'quality_terms',
                'general_terms',
                'approved',
                'issuer',
                'approver',
                'approved_at',
                'duedate_at',
                'tags',
                'pending', 
                'created_at', 
                'updated_at',
                'deleted_at' 
            ])
            ->useLogName('model_log');
    }
}

