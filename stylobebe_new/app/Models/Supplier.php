<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Address;

class Supplier extends Model
{
    use
    HasFactory,
    SoftDeletes;

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

    

    // Relationships

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function userWithTrashed(){

        return $this->user()->withTrashed();
    }

    public function purchases(){

        return $this->hasMany(Purchase::class);
    }

    
    public function purchasesWithTrashed(){

        return $this->purchases()->withTrashed();
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    //End of Relationships

     

    
}

