<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageMedia;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\WorkedOrder;
use App\Models\FabricProcItem;

class FabricProc extends Model implements HasMedia
{
    use
        Authx,
        HasFactory,
        SoftDeletes,
        InteractsWithMedia,
        CascadeSoftDeletes,
        CascadeSoftDeletesRestore,
        LogsActivity,
        ManageMedia,
        ManageModel,
        ManageTag;

    /*
        Auto Generated Columns:
        id
    */

    protected $fillable = [
        'worked_order_id',
    ];

    public function getFillables() {
        return $this->fillable;
    } 

    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];

    protected $dependency = [];

    //public static function INDEXABLE(){
    //     return false;
    //}

    public function hasDependency()
    {
        return count($this->dependency);
    }

    public function getDependency()
    {
        return $this->dependency;
    }

    /**
    * Relationship 
    */

        public function workedOrder(){

            return $this->belongsTo(WorkedOrder::class);
            
        }

        public function fabricProcItems(){
            return $this->hasMany(FabricProcItem::class);
        }

    /**
    * End of Relationship
    */

    // Media

    /**
     * cSize is Conversion Size
     * default is s400
     */
    public function getMediaConversionName($cSize = 's400')
    {
        switch ($cSize) {
            case 's100':
                return 'fabric-procurement-conversion-size-100px';
            default:
                return 'fabric-procurement-conversion-size-400px';
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
                return 'fabric-procurement-secondary-images';
            default:
                return 'fabric-procurement-primary-image';
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
                'worked_order_id',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}