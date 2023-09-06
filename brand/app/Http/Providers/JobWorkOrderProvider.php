<?php
namespace App\Http\Providers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Providers\Provider;
use App\Models\JobWorkOrder;
use App\Http\Requests\jobWorkOrderRequest;
use App\Http\Requests\jobWorkOrderUpdateRequest;
use App\Http\Resources\JobWorkOrderResource;
use App\Services\ProductRepository;


class JobWorkOrderProvider extends Provider
{
    public $response = '';
    public $message = '';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $JobWorkOrders = JobWorkOrder::get();
        return JobWorkOrderResource::collection($JobWorkOrders);
    }

    /**
     *  Create a resource
     */

    public function store(jobWorkOrderRequest $request){
        
        $quantity = 0;
        $quantities = json_decode($request->quantities, true);

        foreach($quantities as $qty){
            $quantity += array_sum($qty);
        }

        try{
            JobWorkOrder::create([
                'product_id' => $request->product_id,
                'fabricator_id' => $request->fabricator_id,
                'jwoi' => 'JWO-'.time().'-'.$request->product_id,
                'quantity' => $quantity,
                'quantities' => json_encode($quantities),
                'expected_at' => $request->delivery_date,
                'message' => $request->message,
            ]);
            $this->response = true;
        } catch(\Exception $e){
            $this->response = false;
            $this->message = 'Some issue occurred.';
        }
        return json_encode(['success' =>  $this->response,'message' => $this->message,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(jobWorkOrderUpdateRequest $request, JobWorkOrder $jobWorkOrder)
    {
        try{
            if($request->has('status')){
                $jobWorkOrder->update([
                    'status' => $request->status,
                ]);
            }else {
                $quantity = array_sum($request->quantities);
                $jobWorkOrder->update([
                    'quantity' => $quantity,
                    'quantities' => json_encode($request->quantities),
                    'expected_at' => $request->delivery_date,
                ]);
            }

            $this->response = true;

        } catch(\Exception $e){
            $this->response = false;
            $this->message = 'Some issue occurred.';
        }
        return json_encode(['success' =>  $this->response,'message' => $this->message,]);
    }

     /**
     * Display the specified resource.
     */
    public function show(Request $request, JobWorkOrder $jobWorkOrder)
    {
        return new JobWorkOrderResource($jobWorkOrder);
    }
    
    
}