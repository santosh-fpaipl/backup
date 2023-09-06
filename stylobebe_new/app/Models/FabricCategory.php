<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

class FabricCategory extends Model 
{
    use
        HasFactory,
        SoftDeletes;

    // Properties

    /*
        Auto Generated Columns:
        id
        slug
    */

    protected $fillable = [
        'name',
        'parent_id',
        'tags'
    ];

    public function getFillables() {
        return $this->fillable;
    } 

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

 



    




  

    // Scopes

    public function scopeTopRecords($query, $sortBy = 'name', $order = 'asc')
    {
        return $query->whereParentId(null)->orderby($sortBy, $order);
    }


    // Helper Functions



    public function hasChild()
    {
        return count($this->child);
    }

    public function hasParent()
    {
        return count($this->parent);
    }

    public function parentWithTrashed()
    {
        return $this->parent()->withTrashed();
    }

    public function childWithTrashed()
    {
        return $this->child()->withTrashed();
    }

    // Relationships

    public function parent()
    {
       // return $this->belongsTo(self::class, 'parent_id');

       return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function child()
    {
       // return $this->hasMany(self::class, 'parent_id');
       return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function fabrics(): HasMany
    {
        return $this->hasMany(Fabric::class, 'category_id');
    }

}
