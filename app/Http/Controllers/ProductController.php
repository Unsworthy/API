<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {

            $data = Product::all();
            return response([
                "message" => "Product has been founded",
                "data" => $data
            ], 201);
        }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'Price' => 'required|double|min:1',
            'Description' => 'required|Text',
            'qty' => 'required|int|min:1'
            
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'Price'=> $request->Price,
            'Description' => $request->Description,
            'qty' => $request->qty
        ]);

        return response([
            "message" => "Product has been created",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);

    
        return isset($data) ? response([
            "message" => "Product has been founded",
            "data" => $data
        ]) : response([
        "message" => "Page or Data Not Found",
        "data" => $data
    ],404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $data = Product::find($id);

        if(isset($data)){
            $request->validate([
                'product_name' => 'required|string|unique:product,product_name'
            ]);
            $data->product_name = $request->product_name;
            $data->save();
            return response([
                "message" => "Product has been updated",
                "data" => $data
            ]);
        }
        response([
            "message" => "Page or Data Not Found",
            "data" => $data
        ],404);
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);

        if(isset($data)){
            $data->delete();
            return response([
                "message" => "Product has been deleted",
                "data" => $data
            ]);
        }
             response([
            "message" => "Page or Data Not Found",
            "data" => $data
        ],404);
        
    }
}
