<?php

namespace App\Http\Controllers\Api;

//import model Order
use App\Models\Order;

use App\Http\Controllers\Controller;

//import resource OrderResource
use App\Http\Resources\OrderResource;

//import Http request
use Illuminate\Http\Request;

//import facade validator
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all orders
        $order = Order::latest()->paginate(5);

        //return collection of orders as a resource
        return new OrderResource(true, 'List Data Orders', $order);
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'type'          => 'required',
            'description'   => 'required',
            'email'         => 'required',
            'phone_number'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create order
        $order = Order::create([
            'name'          => $request->name,
            'type'          => $request->type,
            'description'   => $request->description,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
        ]);

        //return response
        return new OrderResource(true, 'Data Order Berhasil Ditambahkan!', $order);
    }
}
