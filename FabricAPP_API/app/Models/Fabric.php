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
use App\Rules\CheckFabricCategoryForProduct;
use App\Models\FabricCategory as ParentModel;
use App\Models\FabricColor;
use App\Models\Stock;

class Fabric extends Model
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
        'fabric_category_id',
        'name',
        'slug',
        'gstrate',
        'hsncode',
        'unit',
        'description',
        'tags'
    ];

    protected $cascadeDeletes = ['colors'];

    protected $CascadeSoftDeletesRestore = ['colorsWithTrashed', 'fabricCategoryWithTrashed'];

    protected $dependency = ['colors'];

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

    public function getTimestamp($value)
    {
        return getTimestamp($this->$value);
    }

    public function getValue($key)
    {

        return $this->$key;
    }

    public function getParentSlug($key)
    {
        $parentSlug = '';
        if (!empty($this->$key) && $this->fabricCategoryWithTrashed) {
            $parentSlug = $this->fabricCategoryWithTrashed->slug;
        }
        return $parentSlug;
    }

    public function getParentName($key)
    {
        $parentName = '';
        if (!empty($this->$key) && $this->fabricCategoryWithTrashed) {
            $parentName = $this->fabricCategoryWithTrashed->slug;
        }
        return $parentName;
    }


    public function fabricCategoryWithTrashed()
    {
        return $this->fabricCategory()->withTrashed();
    }

    // Relationships

    public function fabricCategory()
    {
        return $this->belongsTo(FabricCategory::class, 'fabric_category_id');
    }


    public function colors(){
        return $this->hasMany(FabricColor::class);
    }

    public function colorsWithTrashed(){
        return $this->hasMany(FabricColor::class)->withTrashed();
    }

    //End of Relationships

    public static function validationRules()
    {
        return [
            'fabric_category_id' => ['nullable', 'exists:fabric_categories,id', new CheckFabricCategoryForProduct],
            'unit' => ['required'],
        ];
    }

    public static function importValidationRules()
    {
        return [
            'fabric_category_id' => ['nullable', 'exists:fabric_categories,id', new CheckFabricCategoryForProduct],
            'unit' => ['required'],

        ];
    }

    public static function validationErrosMessages()
    {
        return array(
            'required'    => 'The :attribute is required.',
            'unique'    => 'The :attribute is already exists.',
            'exists' => 'The :attribute is invalid.',
        );
    }

    public static function performColumnNameMapping($importValues): array
    {
        if (count(self::columnNameMapping())) {
            foreach (self::columnNameMapping() as $oldKey => $newKey) {
                $importValues = replaceKeyname($importValues, $oldKey, $newKey);
            }
        }
        return $importValues;
    }

    public static function reComputeColumnValue($importValues, $row): array
    {
        if (count(self::columnValueMapping())) {
            foreach (self::columnValueMapping($row) as $key => $value) {
                $importValues[$key] = $value;
            }
        }
        return $importValues;
    }

    public static function columnNameMapping(): array
    {
        return array(
            'fabric_category_name' => 'fabric_category_id',
        );
    }

    /*
      If we do not provided the parent name of record then it return $parent_id = null
      If we provided the parent name of record and we do not find the parent name in table, it means that we ignore this record.
      If we provided the parent name of record and we find the parent name in table then it returns parent record's id.
    */
    public static function columnValueMapping($row = false): mixed
    {
        return array(
            'fabric_category_id' => self::getFabricCategoryId($row)
        );
    }

    public static function getFabricCategoryId($row) {
        if (empty($row['fabric_category_name'])) {
            return null;
        } else {
            return ParentModel::where('slug', Str::slug($row['fabric_category_name']))->first()->id;
        }
    }

    public static function sampleModel()
    {
        $model = new self();
        $model->fabric_category_id = 'Fabric Category Name';
        $model->name = 'Fabric Name';
        $model->gstrate = 'GST Rate';
        $model->hsncode = 'Hsncode';
        $model->unit = "unit in ['mtr','kg','inch','cm']";
        return $model;
    }

    

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'fabric_category_id',
                'name',
                'slug',
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
