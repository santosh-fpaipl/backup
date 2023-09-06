<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\User;
use App\Models\Address;
use App\Models\PurchaseOrder;
use App\Models\Purchase;

class Supplier extends Model
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
        'user_id',
        'address_id',
        'gst',
        'pan',
        'tags'
    ];

    public function getFillables() {
        return array_merge($this->fillable, [
            'created_at',
            'updated_at'
        ]);
    } 

    public function hasExtraFields() {
        return true;
    }

    public function getExtraFields($data) {
        $user = self::where('id', $data['id'])->first();
        $extra = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        return array_merge($data, $extra);
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
    
    public function getNameAttribute()
    {
        return empty($this->userWithTrashed) ? '' : $this->userWithTrashed->name;
    }

    public function getEmailAttribute()
    {
        return empty($this->userWithTrashed) ? '' : $this->userWithTrashed->email;
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

    function getSupplierName($key){

        return $this->$key;
    }

    // function getName($key){

    //     return empty($this->userWithTrashed) ? '' : $this->userWithTrashed->$key;
    // }

    // function getEmail($key){

    //     return empty($this->userWithTrashed) ? '' : $this->userWithTrashed->$key;
    // }

    // Relationships

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function userWithTrashed(){

        return $this->user()->withTrashed();
    }

    public function addresses(){

        return $this->morphMany(Address::class, 'addressable');

    }

    public function purchaseOrders(){

        return $this->hasMany(PurchaseOrder::class);
    }

    public function purchases(){

        return $this->hasMany(Purchase::class);
    }
   
    //End of Relationships

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'user_id',
                'address_id',
                'gst',
                'pan',
                'tags',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}

