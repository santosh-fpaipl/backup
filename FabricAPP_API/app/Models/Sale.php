<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Fpaipl\Panel\Traits\CascadeSoftDeletes;
use Fpaipl\Panel\Traits\CascadeSoftDeletesRestore;
use Fpaipl\Panel\Traits\ManageModel;
use Fpaipl\Panel\Traits\Authx;
use Fpaipl\Panel\Traits\ManageTag;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\StockTransaction;

class Sale extends Model
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
        'customer_id',
        'invoice_no',
        'invoice_date',
        'total',
        'tax',
        'sub_total',
        'payment_status',
        'delivery_status',
        'description',
        'tags',
        'status',
    ];

    protected $cascadeDeletes = [];

    protected $CascadeSoftDeletesRestore = [];

    protected $dependency = [];

    Const STATUS = [0 =>'Draft', 1 =>  'Live'];

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

    function getCustomerName($key){
        return $this->customer->user->name;
    }

    function getCustomerEmailId($key){
        return $this->customer->user->email;
    }

    function getShippingAddress($key){
        return $this->address->print;
    }

    function getSaleStatus($key){
        return self::STATUS[$this->$key];
    }

    // Relationships
   

    public function customer(){

        return $this->belongsTo(Customer::class);
    }

    public function saleItems(){
        return $this->hasMany(SaleItem::class);
    }

    public function stockTransactions(): MorphMany
    {
        return $this->morphMany(StockTransaction::class, 'transactionable');
    }


    //End of Relationships

    public static function validationRules()
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'], 
            //'address_id' => ['required', 'exists:addresses,id'],
            'invoice_id' => ['required'],
            'payment_status' => ['required', 'boolean'], 
            'delivery_status' => ['required', 'boolean'],
        ];
    }

    public static function importValidationRules()
    {
        return [
            'customer_id' => ['nullable', 'exists:customers,id'], 
            'invoice_id' => ['required'],
            'payment_status' => ['required', 'boolean'], 
            'delivery_status' => ['required', 'boolean'],

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
            'customer_email_id' => 'customer_id',
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
            'customer_id' => self::getCustomerId($row)
        );
    }

    public static function getCustomerId($row)
    {
        if (empty($row['customer_email_id'])) {
            return null;
        } else {
            return Customer::join('users', 'users.id', '=', 'customers.user_id')
            ->where('users.email',$row['customer_email_id'])
            ->select('customers.id')
            ->first()
            ->id;
        }
    }

    public static function sampleModel()
    {
        $model = new self();
        $model->customer_id = 'Customer Email Id';
        $model->invoice_id = 'Invoice Number';
        $model->payment_status = 'Status in boolean(0 or 1)';
        $model->delivery_status = 'Status in boolean(0 or 1)';
        return $model;
    }

    // Logging

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'id', 
                'customer_id',
                'invoice_no',
                'invoice_date',
                'total',
                'tax',
                'sub_total',
                'payment_status',
                'delivery_status',
                'description',
                'tags',
                'status',  
                'created_at', 
                'updated_at', 
                'deleted_at'
            ])
            ->useLogName('model_log');
    }
}
