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

use App\Models\Customer;
use App\Models\Stock;
use App\Models\SaleOrderHistory;
use App\Models\SoItem;
use App\Models\SaleItem;
use App\Models\Gdn;

class SaleOrder extends Model
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
        'customer_id',
        'stock_id',
        'sale_id',
        'so_id',
        'variation',
        'rate',
        'payment_terms',
        'delivery_terms',
        'quality_terms',
        'general_terms',
        'pre-order',
        'approved',
        'accepter',
        'accepted_at',
        'tags',
        'pending',
    ];
    
    
    // Helper Functions

    public function gdnCreatedAllSoItems(){
        $gdnCreated = true;
        foreach($this->soItems as $soItem){
            if(!$soItem->gdn){
                $gdnCreated = false;
            }
        }
        return $gdnCreated;
    }

    public function scopePreOrder($query)
    {
        return $query->where('pre_order', 1);
    }

    public function scopeNormal($query)
    {
        return $query->where('pre_order', 0);
    }

    public function scopePending($query)
    {
        return $query->where('pending', 1);
    }

    public function scopeCompleted($query)
    {
        return $query->where('pending', 0);
    }
   
    // Relationships

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function saleOrderHistories(){
        return $this->hasMany(SaleOrderHistory::class);
    }

    public function soItems(){
        return $this->hasMany(SoItem::class);
    }

    public function saleItem(){
        return $this->hasOne(SaleItem::class);
    }

    public function gdns(){
        return $this->hasMany(Gdn::class);
    }

    public static function last()
    {
        return self::latest()->first();
    }

    /*
        return something like this
        MC/SO0823/0001
    */
    public static function generateId() {
        $static = 'MC/SO';
        $month = date('m'); // Current month
        $year = date('y'); // Last two digits of the current year
        // Retrieve the last order by ID and get its ID
        $lastOrder = self::orderBy('id', 'desc')->first();
        $serial = $lastOrder ? $lastOrder->id + 1 : 1; // If there's no order, start from 1
        $serial = str_pad($serial, 4, '0', STR_PAD_LEFT); // Pad with zeros to make it at least 4 digits
        return $static . $month . $year . '/' . $serial;
    }    

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'customer_id',
                'stock_id',
                'sale_id',
                'so_id',
                'variation',
                'rate',
                'payment_terms',
                'delivery_terms',
                'quality_terms',
                'general_terms',
                'pre-order',
                'approved',
                'accepter',
                'accepted_at',
                'tags',
                'pending', 
                'created_at', 
                'updated_at',
                'deleted_at' 
            ])
            ->useLogName('model_log');
    }
}
