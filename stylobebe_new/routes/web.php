<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('po/create', function() {
    $suppliers = App\Models\Supplier::with('user')->get();
    $categories =  App\Models\FabricCategory::all();
    $fabrics =  App\Models\Fabric::with('colors')->get();

    return view('create.po')->with([
         'suppliers' => $suppliers,
         'categories' => $categories,
         'fabrics' => $fabrics,
    ]);
})->name('po.create');

Route::post('po/create/submit', function(Request $request) {
    $supplier = App\Models\Supplier::with('user')->with('addresses')->findOrFail($request->supplier);
    $category = App\Models\FabricCategory::findOrFail($request->category);
    $material = App\Models\Fabric::with('colors')->with('taxation')->findOrFail($request->material);
    //dd($material);
    return view('create.po-submit')->with([
        'request' => $request,
        'supplier' => $supplier,
        'category' => $category,
        'material' => $material,
    ]);
})->name('po.create.submit');

Route::get('so/create', function() {
    $customers = App\Models\Customer::with('user')->get();
    $categories =  App\Models\FabricCategory::all();
    $fabrics =  App\Models\Fabric::with('colors')->get();
    return view('create.so')->with([
        'customers' => $customers,
        'categories' => $categories,
        'fabrics' => $fabrics,
    ]);
})->name('so.create');

 Route::post('so/create/submit', function(Request $request) {
  
    $customer = App\Models\Customer::with('user')->with('addresses')->findOrFail($request->customer);
    $category = App\Models\FabricCategory::findOrFail($request->category);
    $material = App\Models\Fabric::with('colors')->with('taxation')->findOrFail($request->material);
    //dd($material);
    return view('create.so-submit')->with([
        'request' => $request,
        'customer' => $customer,
        'category' => $category,
        'material' => $material,
    ]);
 })->name('so.create.submit');
