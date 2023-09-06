<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Fabric;
use App\Models\Transaction;
use App\Models\Stock;

class FabricColor extends Model
{
    use
        HasFactory,
        SoftDeletes;

    // Properties

   //const INDEXABLE = false;

    /*
        Auto Generated Columns:
        id
        slug
    */
    protected $fillable = [
        'fabric_id', 
        'name',
        'slug',
    ];
    
    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];
    
    protected $dependency = [];

    public function hasDependency(){
        return count($this->dependency);
    }

    public function getDependency(){
        return $this->dependency;
    }

        
    // Helper Functions

    // Relationships
    
    /**
     * Get all of the Fabrics of the color.
     */
    public function fabric(): BelongsTo
    {
        return $this->belongsTo(Fabric::class, 'fabric_id');
    }

    public function fabricWithTrashed()
    {
        return $this->fabric()->withTrashed();
    }

    public function transactions(){

        return $this->hasMany(Transaction::class);
    }

    public function transactionsWithTrashed()
    {
        return $this->transactions()->withTrashed();
    }

    public function stock(){
        return $this->hasOne(Stock::class);
    }

    public function stockWithTrashed(){
        return $this->stock()->withTrashed();
    }

    
}
