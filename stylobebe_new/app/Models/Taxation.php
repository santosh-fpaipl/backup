<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fabric;

class Taxation extends Model
{
    use HasFactory;

    public $timestamps = false;

    /*
        Auto Generated Columns:
        id
    */
    protected $fillable = [
        'name',
        'hsncode',
        'gstrate',
    ];


    // Relationships

    public function fabrics()
    {
        return $this->hasMany(Fabric::class, 'taxation_id');
    }


   
}
