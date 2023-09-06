<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rules\File;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\NamedSlug;
use Fpaipl\Panel\Traits\ManageTag;
use Fpaipl\Panel\Traits\Authx;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\Material;
use App\Models\Style;
use App\Models\PurchaseOrder;
use App\Models\SaleOrder;
use App\Models\stockColors;

class Stock extends Model
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        NamedSlug,
        ManageModel,
        ManageTag;

    // Properties

    /*
        Auto Generated Columns:
        id
        slug
    */

    protected $fillable = [
        'quantity',
        'style_id',
        'material_id',
        'sid',
        'name',
        'slug',
        'sale_price',
        'gstrate',
        'hsncode',
        'unit',
        'description',
        'tags'
    ];

    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];

    protected $dependency = [];

    // public static function INDEXABLE(){
    //     return false;
    // }

    public function hasDependency()
    {
        return count($this->dependency);
    }

    public function getDependency()
    {
        return $this->dependency;
    }

    
    // Helper Functions

    public function getTimestamp($value)
    {
        return getTimestamp($this->$value);
    }

    public function getValue($key)
    {

        return $this->$key;
    }

    // Relationships

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function stockColors(){
        return $this->hasMany(StockColor::class);
    }

    public function purchaseOrders(){
        return $this->hasMany(PurchaseOrder::class);
    }

    public function saleOrders(){
        return $this->hasMany(SaleOrder::class);
    }

    //End of Relationships
   

    

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'quantity',
                'style_id',
                'material_id',
                'sid',
                'name',
                'slug',
                'sale_price',
                'gstrate',
                'hsncode',
                'unit',
                'description',
                'tags',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
