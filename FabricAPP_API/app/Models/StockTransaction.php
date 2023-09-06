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
use App\Models\StockItem;

class StockTransaction extends Model
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
    */

    protected $fillable = [
        'transactionable_type',
        'transactionable_id',
        'stock_item_id',
        'opening',
        'quantity',
        'closing',
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

    public function stockItem(){
        return $this->belongsTo(StockItem::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    //End of Relationships

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'transactionable_type',
                'transactionable_id',
                'stock_item_id',
                'opening',
                'quantity',
                'closing',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}