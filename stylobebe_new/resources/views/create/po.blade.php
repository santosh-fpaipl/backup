<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
  </script>
  <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
  </script>

    <script>
      $(document).ready(function () {
    
        // Denotes total number of rows
        var rowIdx = 0;

        var addRowLimit = 2;
    
        // jQuery button click event to add a row
        $('#addBtn').on('click', function () {
          
          // Adding a row inside the tbody.
          $('#tbody').append(`<tr id="R${++rowIdx}">
               <td class="row-index text-center">
                <input type="text" class="form-control" id="color${rowIdx}" name="color${rowIdx}" placeholder="Color Name" value="" required>
               </td>
               <td class="row-index text-center">
                <input type="text" class="form-control" id="width${rowIdx}" name="width${rowIdx}" placeholder="Width" value="" required>
               </td>
               <td class="row-index text-center">
                <input type="text" class="form-control" id="length${rowIdx}" name="length${rowIdx}" placeholder="Length" value="" required>
               </td>
               <td class="row-index text-center">
                <input type="text" class="form-control" id="quantity${rowIdx}" name="quantity${rowIdx}" placeholder="Order Quantity" value="" required>
               </td>
               <td class="row-index text-center">
                <input type="text" class="form-control" id="description${rowIdx}" name="description${rowIdx}" placeholder="Description" value="" >
               </td>
               

                <td class="text-center">
                  <button class="btn btn-danger remove"
                    type="button">Remove</button>
                  </td>
                </tr>`);

          $('#total_rows').val(rowIdx);

          if(rowIdx >= addRowLimit){
            $('#addBtn').hide();
          }
          
        });
    
        // jQuery button click event to remove a row.
        $('#tbody').on('click', '.remove', function () {
    
          // Getting all the rows next to the row
          // containing the clicked button
          var child = $(this).closest('tr').nextAll();
    
          // Iterating across all the rows 
          // obtained to change the index
          child.each(function () {
    
            // Getting <tr> id.
            var id = $(this).attr('id');
    
            // Getting the <p> inside the .row-index class.
            var idx = $(this).children('.row-index').children('p');
    
            // Gets the row number from <tr> id.
            var dig = parseInt(id.substring(1));
    
            // Modifying row index.
            idx.html(`Row ${dig - 1}`);
    
            // Modifying row id.
            $(this).attr('id', `R${dig - 1}`);
          });
    
          // Removing the current row.
          $(this).closest('tr').remove();
    
          // Decreasing total number of rows by 1.
          rowIdx--;

          $('#total_rows').val(rowIdx);

          if(rowIdx < addRowLimit){
            $('#addBtn').show();
          }
        });
      });
    </script>
  </head>
  <body>
    <form method="post" action="{{ route('po.create.submit') }}">
    @csrf
      <div style="margin: 0 auto; width:1000px;">

        <div class="mb-3">
            <label for="po_date" class="form-label">PO Date</label>
            <input type="datetime-local" class="form-control" id="po_date" name="po_date" placeholder="PO Date" value="" required>
        </div>

        <div class="mb-3">
          <label for="exp_period" class="form-label">PO Expiry Period</label>
          <input type="number" class="form-control" id="exp_period" name="exp_period" placeholder="PO Expiry Period" value="" required>
        </div>


          <div class="mb-3">
              <label for="po_number" class="form-label">PO Number</label>
              <input type="text" class="form-control" id="po_number" name="po_number" placeholder="PO Number" value="" required>
          </div>
      
          <div class="mb-3">
              <label for="supplier" class="form-label">Supplier</label>
      
              <select name="supplier" id="supplier" class="form-select" aria-label="Default select example" required>
                  <option value="" selected>Select Supplier</option>
                  @foreach($suppliers as $supplier)
                      <option value="{{ $supplier->id }}">{{ $supplier->user->name }}</option>
                  @endforeach
              </select>
      
          </div>
      
          <div class="mb-3">
              <label for="category" class="form-label">Material Catagory</label>
      
              <select name="category" id="category" class="form-select" aria-label="Default select example" required>
                  <option value="" selected>Select Category</option>
                  @foreach($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
              </select>
      
          </div>
      
          <div class="mb-3">
              <label for="material" class="form-label">Material</label>
      
              <select name="material" id="material" class="form-select" aria-label="Default select example" required>
                  <option value="" selected>Select Material</option>
                  @foreach($fabrics as $fabric)
                      <option value="{{ $fabric->id }}">{{ $fabric->name }}</option>
                  @endforeach
              </select>
      
          </div>

          <div class="mb-3">
              <label for="Fabric_rate" class="form-label">Fabric Rate</label>
              <input type="text" class="form-control" id="fabric_rate" name="fabric_rate" placeholder="Fabric Rate" value="" required>
          </div>

          <div class="mb-3">
            <label for="tolerance" class="form-label">Tolerance %:</label>
            <input type="text" class="form-control" id="tolerance" name="tolerance" placeholder="Tolerance" value="" required>
          </div>

          <div class="mb-3">
            <label for="payment_term" class="form-label">Payment Terms</label>
            <input type="text" class="form-control" id="payment_term" name="payment_term" placeholder="Payment Terms" value="" required>
          </div>

          <div class="mb-3">
            <label for="Fabric_rate" class="form-label">Delivery Terms</label>
            <input type="text" class="form-control" id="delivery_term" name="delivery_term" placeholder="Delivery Terms" value="" required>
          </div>

          <div class="container pt-4 mb-3">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">Color Varients</th>
                    <th class="text-center">Width
                      ( inches )</th>
                    <th class="text-center">Length
                      ( cm)</th>
                    <th class="text-center">Order
                      Quantity</th>
                    <th class="text-center">Discription
                      ( For Refrence )</th>
                    <th class="text-center">Remove Row</th>
                  </tr>
                </thead>
                <tbody id="tbody">
          
                </tbody>
              </table>
            </div>

            <button class="btn btn-md btn-primary" 
              id="addBtn" type="button">
                Add new Row
            </button>
          </div>

          <input type="hidden" name="total_rows" id="total_rows" value="" />

          <div class="mb-3">
            <input type="submit" name="submit" value="Print" class="btn btn-primary" />
          </div>
         
         
      </div>
    </form>
  </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    config = {
        minDate: "today",
        enableTime: false,
        dateFormat: 'd-m-Y',
        defaultDate: "today",
    }
    flatpickr("input[type=datetime-local]", config);
</script>