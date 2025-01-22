<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'product_name' => 'required|unique:products,product_name|string|max:255',
            'product_image' => 'required|image:jpg,jpeg,png',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'required|string'
            
        ]);

        $image_name = time() . "." . $request->product_image->extension();
        $request->product_image->move(public_path("upload/product"), $image_name);

        Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_image' => url("upload/product") . "/" . $image_name,
            'product_image_name' => $image_name,
            'price'=> $request->price,
            'stock' => $request->stock,
            'description' => $request->description
        ]);

        return response([
            "message" => "Product has been created",
        ], 201);
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
    public function update(Request $request,  $product)
    {

       
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'product_name' => 'required|unique:products,product_name|string|max:255',
                'price' => 'required|integer',
                'stock' => 'required|integer',
                'description' => 'required|string'
            ]);
            
            $data = Product::find($product);
            
            if(!isset($data)){
                return response([
                    "message" => "Product not found",
                ], 404);
            }
            if (isset($request->product_image)){
                $request->validate([  
                    'product_image' => 'required|image:jpg,jpeg,png'

            ]);
            $request->product_image->move(public_path("upload/product"), $data->product_image_name);
            }
            
            $data->category_id = $request->category_id;
            $data->product_name = $request->product_name;
            $data->price = $request->price;
            $data->stock = $request->stock;
            $data->description = $request->description;
            $data->save();

            return response([
                "message" => "product has been update!",
    
            ], 200);

        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        $data = Product::find($product);

        if(!isset($data)){
            return response([
                "message" => "Product or Data not found",
            ], 404);
        }
        
        File::delete(public_path("upload/product") . "/" . $data->product_image_name);

        $data->delete();

            return response([
            "message" => "product has been deleted!",

        ],200);
        
    }
}
