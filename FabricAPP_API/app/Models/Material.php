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

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use App\Models\Category;
use App\Models\Stock;

class Material extends Model implements HasMedia
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        InteractsWithMedia,
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
        'category_id',
        'name',
        'slug',
        'sid',
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

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    //End of Relationships
   

    // Media

    /**
     * cSize is Conversion Size
     * default is s400
     */
    public function getMediaConversionName($cSize = 's400')
    {
        switch ($cSize) {
            case 's100':
                return 'material-conversion-size-100px';
            default:
                return 'material-conversion-size-400px';
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
                return 'material-secondary-images';
            default:
                return 'material-primary-image';
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
                'category_id',
                'name',
                'slug',
                'sid',
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
