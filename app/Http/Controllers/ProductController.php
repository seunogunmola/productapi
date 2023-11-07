<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Exception;
use Throwable;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $products = Product::all();

            return response()->json([
                'status'=>'true',
                'message'=>'Products Found',
                'data' => ProductResource::collection($products)
            ]);
        }
        catch(\Exception $e){
            return response()->json(['error'=>'An Error Occured, Please try again']);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'status'=>true,
            'message'=>'Product Created Successfully',
            'data'=>ProductResource::make($product)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try{
            return response()->json(
                [
                    'status'=>true,
                    'message'=>'Product Found',
                    'data'=>ProductResource::make($product)
                ]
            );
        }
        catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>"Product not Found"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json([
            'status'=>true,
            'message'=>'Product Updated Successfully',
            'data'=>ProductResource::make($product)
        ],200);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return response()->json([
                'status'=>'true',
                'message'=>'Product Deleted Succesfully'
            ]);
        }
        catch(\Exception $e){
            // Log the exception for debugging and monitoring
            Log::error('Exception caught: ' . $e->getMessage());

            // Return an error response to the client
            return response()->json(['error' => 'An error occurred.'], 500);            
        }
    }
}
