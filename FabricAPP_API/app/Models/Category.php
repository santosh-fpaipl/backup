<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageMedia;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\NamedSlug;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Category extends Model implements HasMedia
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        InteractsWithMedia,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        NamedSlug,
        ManageMedia,
        ManageModel,
        ManageTag;

    // Properties

    /*
        Auto Generated Columns:
        id
        slug
    */

    protected $fillable = [
        'parent_id',
        'type',
        'name',
        'slug',
        'sid',
        'description',
        'tags'
    ];

    public function getFillables() {
        return $this->fillable;
    } 

    protected $cascadeDeletes = ['childWithTrashed'];

    protected $CascadeSoftDeletesRestore = ['parentWithTrashed'];

    protected $dependency = ['child', ];

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

    public static function validationRules()
    {
        return [
            'parent_id' => ['nullable', 'exists:fabric_categories,id'],
            'images.*' => ['nullable', File::types(['jpg', 'webp'])->min(100)->max(2000)],
        ];
    }

    public static function importValidationRules()
    {
        return [
            'name' => ['required', 'unique:fabric_categories'],
            'parent_name' => ['nullable', 'exists:fabric_categories,name'],

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
            'parent_name' => 'parent_id',
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
            'parent_id' => self::getParentId($row)
        );
    }

    public static function getParentId($row)
    {
        if (empty($row['parent_name'])) {
            return null;
        } else {
            return self::where('slug', Str::slug($row['parent_name']))->first()->id;
        }
    }

    public static function sampleModel()
    {
        $model = new self();
        $model->parent_id = 'Parent Category Name';
        $model->name = 'Category Name';
        return $model;
    }

    // Scopes

    public function scopeTopRecords($query, $sortBy = 'name', $order = 'asc')
    {
        return $query->whereParentId(null)->orderby($sortBy, $order);
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
        if (!empty($this->$key) && $this->parentWithTrashed) {
            $parentSlug = $this->parentWithTrashed->slug;
        }
        return $parentSlug;
    }

    public function getParentName($key)
    {
        $parentName = '';
        if (!empty($this->$key) && $this->parentWithTrashed) {
            $parentName = $this->parentWithTrashed->name;
        }
        return $parentName;
    }


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
       return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function child()
    {
       return $this->hasMany(self::class, 'parent_id', 'id');
    }
   

    // Media

    /**
     * cSize is Conversion Size
     * default is s400
     */
    public function getMediaConversionName($cSize = 's400')
    {
        switch ($cSize) {
            case 's100':
                return 'category-conversion-size-100px';
            default:
                return 'category-conversion-size-400px';
        }
    }

    /**
     * cName is Collection Name
     * default is primary
     */
    public function getMediaCollectionName($cName = 'primary')
    {
        switch ($cName) {
            case 'secondary':
                return 'category-secondary-images';
            default:
                return 'category-primary-image';
        }
    }

    /**
     * 
     */
    public function getImage($cSize = '', $cName = 'primary', $withId = false)
    {
        $collection = collect();
        $allMedia = $this->getMedia($this->getMediaCollectionName($cName));
        foreach ($allMedia as $media) {
            $value = $media->getUrl(empty($cSize) ? '' : $this->getMediaConversionName($cSize));
            if ($withId) {
                $collection->put($media->id, $value);
            } else {
                $collection->push($value);
            }
        }
        // Pending optimization
        if ($cName == 'primary') {
            return $collection->first();
        } else {
            return $collection;
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection($this->getMediaCollectionName('secondary'))
            ->useFallbackUrl(config('app.url') . '/storage/assets/images/placeholder.jpg')
            ->useFallbackPath(public_path('storage/assets/images/placeholder.jpg'));

        $this
            ->addMediaCollection($this->getMediaCollectionName('primary'))
            ->useFallbackUrl(config('app.url') . '/storage/assets/images/placeholder.jpg')
            ->useFallbackPath(public_path('storage/assets/images/placeholder.jpg'))
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion($this->getMediaConversionName('s100'))
            ->format(Manipulations::FORMAT_WEBP)
            ->width(100)
            ->height(100)
            ->sharpen(10)
            ->queued();

        $this->addMediaConversion($this->getMediaConversionName('s400'))
            ->format(Manipulations::FORMAT_WEBP)
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->queued();
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'parent_id',
                'type',
                'name',
                'slug',
                'sid',
                'description',
                'tags',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
