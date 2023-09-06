<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <div class="mb-3">
        <label for="po_date" class="form-label">PO Date</label>
        <input type="datetime-local" class="form-control" id="po_date" name="po_date" placeholder="PO Date" value="">
    </div>

    <div class="mb-3">
        <label for="po_number" class="form-label">PO Number</label>
        <input type="text" class="form-control" id="po_number" name="po_number" placeholder="PO-43" value="" required>
    </div>

    <div class="mb-3">
        <label for="supplier" class="form-label">Supplier</label>

        <select name="supplier" id="supplier" class="form-select" aria-label="Default select example">
            <option selected>Select Supplier</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>

    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Material Catagory</label>

        <select name="category" id="category" class="form-select" aria-label="Default select example">
            <option selected>Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

    </div>

    <div class="mb-3">
        <label for="material" class="form-label">Material</label>

        <select name="material" id="material" class="form-select" aria-label="Default select example">
            <option selected>Select Material</option>
            @foreach($fabrics as $fabric)
                <option value="{{ $fabric->id }}">{{ $fabric->name }}</option>
            @endforeach
        </select>

    </div>

   

</div>
