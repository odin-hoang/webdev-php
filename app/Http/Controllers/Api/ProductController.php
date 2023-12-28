<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::all();
        if ($products->count() > 0 ) {
            return response()->json([
                'status' => 200,
                'shoes' => $products
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No record found'
        ], 404);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'image'=>'required|string',
            'name'=>'required|string',
            'description'=>'required',
            'price'=>'required|numeric',
            'color'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'error'=> $validator->messages()
            ], 422);
        }
        $product = Product::create([
            'image'=> $request->image,
            'name'=> $request->name,
            'description' => $request->description,
            'price'=> $request->price,
            'color'=> $request->color
        ]);
        if ($product) {
            return response()->json([
                'status'=> 200,
                'message' => $product
            ], 200);
        }
        return response()->json([
            'status'=> 500,
            'message' => 'Something went wrong'
        ], 500);
    }
    public function destroy($id) {
        $product = Product::find($id);
        if ($product) {
            $product -> delete();
            return response()->json([
                'status' => 200,
                'message' => 'Delete successfully!'
            ], 200);
        } 
        return response()->json([
            'status' => 404,
            'message' => 'No Such Product Found!'
        ], 404);
    }
}
