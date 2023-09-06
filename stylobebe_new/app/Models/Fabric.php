<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rules\File;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use App\Models\FabricCategory as ParentModel;
use App\Models\Size;


class Fabric extends Model
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
        'fabric_category_id',
        'name',
        'slug',
        'taxation_id',
        'unit',
        'tags'
    ];

    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];

    protected $dependency = [];

    const UNIT = [
        ['id' => 'mtr', 'name' => 'Mtr'],
        ['id' => 'kg', 'name' => 'Kg'],
        ['id' => 'inch', 'name' => 'Inch'],
        ['id' => 'cm', 'name' => 'Cm'],
    ];

    protected $attributed = [
        'unit' => self::UNIT[0]['id'],
    ];

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

   

    // Relationships

    public function fabricCategory()
    {
        return $this->belongsTo(FabricCategory::class, 'fabric_category_id');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class,'fabric_size','fabric_id', 'size_id');
    }

    public function taxation()
    {
        return $this->belongsTo(Taxation::class, 'taxation_id');
    }

    public function colors(){
        return $this->hasMany(FabricColor::class);
    }

    public function colorsWithTrashed(){
        return $this->hasMany(FabricColor::class)->withTrashed();
    }

    //End of Relationships
  
}
