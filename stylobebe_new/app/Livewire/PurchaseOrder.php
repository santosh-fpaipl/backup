<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\FabricCategory;
use App\Models\Fabric;

class PurchaseOrder extends Component
{
    public $suppliers;
    public $categories;
    public $fabrics;

    public $po_date;
    public $po_number;
    public $supplier;
    public $category=5;
    public $material;

    public function mount(){
        $this->suppliers = Supplier::with('user')->get();
        $this->categories =  FabricCategory::all();
        $this->fabrics =  Fabric::with('colors')->get();
    }

    public function updated($value){
        dd($value);
    }

    public function updating($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property
 
       dd('dsfds');
    }

    public function render()
    {
        return view('livewire.purchase-order');
    }
}
