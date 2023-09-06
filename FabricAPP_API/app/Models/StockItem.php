<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Validation\Rules\Exists;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use App\Models\Stock;
use App\Models\Bundle;
use App\Models\StockColor;
use App\Models\StockTransaction;

class StockItem extends Model
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

    /*
        Auto Generated Columns:
        id
    */

    protected $fillable = [
        'stock_color_id',
        'min_rate',
        'max_rate',
        'quantity',
        'width',
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

    public function stock(){

        return $this->belongTo(Stock::class);
    }

    public function bundles() {
        return $this->hasMany(Bundle::class);
    }

    public function stockColor(){
        return $this->belongsTo(StockColor::class);
    }
    
    public function stockTransactions() {
        return $this->hasMany(StockTransaction::class);
    }

    //End of Relationships

    public static function validationRules()
    {
        return [];
    }

    public static function validationErrosMessages()
    {
        return array(
            'required' => 'The :attribute is required.',
            'unique' => 'The :attribute is already exists.',
            'exists' => 'The :attribute is invalid.',
        );
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'stock_color_id',
                'min_rate',
                'max_rate',
                'quantity',
                'width',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
