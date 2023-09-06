<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="Width=device-Width, initial-scale=1.0">
<title>Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            /* padding: 2cm;
                margin: 1cm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px; */
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
@php
    // Use Carbon to add days to the initial date
    $newDate = \Carbon\Carbon::parse($request->po_date)->addDays($request->exp_period);

    $arr = explode('--', $material->name);
    $material_id = $arr[0];
    $new_arr = explode('-', $arr[1]);
    $material_id_arr = explode("-", $material_id);
    $material_name = $material_id_arr[0].'-'.$new_arr[0];
    $material_style = $material_id_arr[1].'-'.$new_arr[1];

    $cat_arr = explode("--", $category->name);
    $material_id = $cat_arr[0]."-".$material_id;


@endphp    
<div class="page position-relative">
<div class="d-flex flex-column h-100">
<div class="d-flex justify-content-between mb-3">
<div class="px-2">
<h1 class="fw-bold">Monaal Creation</h1>
<p class="mb-0">B-74, Okhla Phase II, Soutd East Delhi - 110020</p>
<p class="mb-0"> GSTIN : 07GRGPS5476F1Z8, MOBILE : +91 9999 437 620 </p>
</div>
<div class>
<p class="fs-1 mb-2 fw-light" style="font-weight: 100;">Purchase Order (PO)</p>
<div class="d-flex justify-content-between">
<div class>
<p class="mb-0">PO Date:</p>
</div>
<div class>
<p class="mb-0">{{ $request->po_date }}</p>
</div>
</div>
</div>
</div>
<table class="table table-sm table-bordered" style="font-size: 0.9rem;">
<tbody>
<tr>
<td class="table-secondary ps-2">PO Number:</td>
<td class="fw-bold ps-2">{{ $request->po_number }}</td>
<td class="table-secondary ps-2">Material ID:</td>
<td class="fw-bold ps-2">{{ $material_id }}</td>
</tr>
<tr>
<td class="table-secondary ps-2">Suplier Name:</td>
<td class="fw-bold ps-2">{{ $supplier->user->name }}</td>
<td class="table-secondary ps-2"> PO Expiry Date:</td>
<td class="fw-bold ps-2"> 
    {{ $newDate->format('D, F m, Y') }}
</td>
</tr>
<tr>
<td class="table-secondary ps-2">Supplier ID:</td>
<td class="fw-bold ps-2">{{ $supplier->id }}</td>
<td class="table-secondary ps-2">PO Expiry Days:</td>
<td class="fw-bold ps-2">
<div class="d-flex">
<span style="width: 50px;">{{ $request->exp_period }}</span>
<span>Days of PO Creation</span>
</div>
</td>
</tr>
<tr>
<td class="table-secondary ps-2">Supplier Location:</td>
<td class="fw-bold ps-2">

    @if(count($supplier->addresses))
        {{ $supplier->addresses->first()->pincode.", ".$supplier->addresses->first()->district.", ".$supplier->addresses->first()->state }}
    @endif

</td>
<td class="table-secondary ps-2">Tolerance %:</td>
<td class="fw-bold ps-2">
<div class="d-flex">
<span style="width: 50px;">{{ $request->tolerance }}%</span>
<span>Variation ( Order Quantity)</span>
</div>
</td>
</tr>
<tr>
<td class="table-secondary ps-2">Supplier GST:</td>
<td class="fw-bold ps-2">{{ $supplier->gst }}</td>
<td class="table-secondary ps-2">Payment Terms:</td>
<td class="fw-bold ps-2">
<div class="d-flex">
<span style="width: 50px;">{{  $request->payment_term  }}</span>
<span>Days Payment Cycle</span>
</div>
</td>
</tr>
<tr>
<td class="table-secondary ps-2">Fabric Unit:</td>
<td class="fw-bold ps-2">{{ $material->unit }}</td>
<td class="table-secondary ps-2">Delivery Terms:</td>
<td class="fw-bold ps-2">{{  $request->delivery_term  }}</td>
</tr>
<tr>
<td class="table-secondary ps-2">Fabric Rate:</td>
<td class="fw-bold ps-2">₹ {{ $request->fabric_rate }} / {{ $material->unit }}</td>
<td class="table-secondary ps-2">Catagory:</td>
<td class="fw-bold ps-2">{{ str_replace("--","-",$category->name) }}</td>
</tr>

<tr>
<td class="table-secondary ps-2">HSN / SCN Code:</td>
<td class="fw-bold ps-2">{{ $material->taxation->hsncode }}</td>
<td class="table-secondary ps-2"> Material Name:</td>
<td class="fw-bold ps-2">{{ $material_name }}</td>
</tr>
<tr>
<td class="table-secondary ps-2">GST Rate:</td>
<td class="fw-bold ps-2">{{ $material->taxation->gstrate }}%</td>
<td class="table-secondary ps-2"> Material Style:</td>
<td class="fw-bold ps-2">{{ $material_style }}</td>
</tr>
</tbody>
</table>


<table class="flex-fill table table-sm table-bordered" style="font-size: 0.9rem;">
<thead class="table-secondary">
<tr>
<td class="text-center" style="width: 140px;">Color Names<br>(Fabric color name)</td>
<td class="text-center" style="width: 50px;">Width(Panna)<br>(In Inches)</td>
<td class="text-center" style="width: 120px;">Length (Farma)<br>(In cm)</td>
<td class="text-center" style="width: 120px;">Order Quantity<br>(Total Length)</td>
<td class="text-center">Description<br>(For Refrence Only)</td>
</tr>
</thead>
<tbody id="colorList">
    @for($i=1; $i <=$request->total_rows; $i++ )
        @php
            $color = 'color'.$i
        @endphp
        <tr>
            <td class="fw-bold text-center">{{ $request->{'color'.$i} }}</td>
            <td class="fw-bold text-center">{{ $request->{'width'.$i} }}</td>
            <td class="fw-bold text-center">{{ $request->{'length'.$i} }}</td>
            <td class="fw-bold text-center">{{ $request->{'quantity'.$i} }} {{ $material->unit }}</td>
            <td class="fw-bold text-center">{{ $request->{'description'.$i} }}</td>
        </tr>
    @endfor
</tbody>
</table>
<div class="position-absolute start-0 end-0" style="bottom: 20px">
<div class="d-flex justify-content-around">
<p class="mb-0 fw-bold fs-5 text-center">Kedar Sen<br><small>(Prepared By)</small></p>
<p class="mb-0 fw-bold fs-5 text-center">Subhash Kumar<br><small>(Approved By)</small></p>
</div>
</div>
</div>
</div>
</body>

</html>