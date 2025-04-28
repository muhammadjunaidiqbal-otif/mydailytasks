<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $products = Product::where('status', 'Publish')->with('category')->get();
        return response()->json([
            'info' => $products
        ]);
    }
    public function test(){
        return "HI";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $categories = Category::all();
        return view('Products-view.products-addproducts',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:Scheduled,Publish,Inactive',
            'base_price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0|max:99999999.99|lte:base_price',
            'charge_tax' => 'required|boolean',
            'in_stock' => 'required|boolean',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        $filePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('products', 'public');
        } else {
            $filePath = "No File Uploaded";
        }

        $product = Product::create([
            'name'=>$request->name,
            'sku'=>$request->sku,
            'barcode'=>$request->barcode,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'status'=>$request->status,
            'base_price'=>$request->base_price,
            'discounted_price'=>$request->discounted_price,
            'charge_tax'=>$request->charge_tax,
            'in_stock'=>$request->in_stock,
            'image'=>$filePath,
            'created_at'=>now(),
            'updated_at'=>null

        ]);
        if(!$product){
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the product.',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Product Created Successfully',
            'product' => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $products = Product::with('category')->find($id);
        $categories = Category::all();
        return view('Products-view.products-addproducts',[
            'categories'=>$categories,
            'products'=>$products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id){
        $request->validate([
            'name'              => 'required|string|max:255',
            'sku'               => 'required|string|max:255',
            'barcode'           => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'category_id'       => 'required|exists:categories,id',
            'status'            => 'required|in:Scheduled,Publish,Inactive',
            'base_price'        => 'required|numeric|min:0',
            'discounted_price'  => 'nullable|numeric|min:0|max:99999999.99|lte:base_price',
            'charge_tax'        => 'required|boolean',
            'in_stock'          => 'required|boolean',
            'image'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('products', 'public');
        } else {
            $filePath = "No File Uploaded";
        }
    
        // Retrieve the product by its id
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product not found.'
            ], 404);
        }
    
        try {
            // Update the product instance
            $product->update([
                'name'              => $request->name,
                'sku'               => $request->sku,
                'barcode'           => $request->barcode,
                'description'       => $request->description,
                'category_id'       => $request->category_id,
                'status'            => $request->status,
                'base_price'        => $request->base_price,
                'discounted_price'  => $request->discounted_price,
                'charge_tax'        => $request->charge_tax,
                'in_stock'          => $request->in_stock,
                'image'             => $filePath,
                'updated_at'        => now()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while updating the product.',
                'error'   => $e->getMessage()
            ], 500);
        }
    
        return response()->json([
            'status'  => 'success',
            'message' => 'Product Updated Successfully',
            'product' => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $product = Product::find($id); 
        if (!$product) {
            return response()->json(['error' => 'Product not found!'], 404);
        }
    
        $product->delete();
    
        return response()->json(['success' => 'Product deleted successfully!']); 
    }
    public function deleteSelectedRows(Request $request){
        $ids = $request->ids; 
        if (!empty($ids)) {
            Product::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Records deleted successfully!']);
        }
        return response()->json(['error'=> 'No records selected.'], 400);
    }
    public function loadProducts(){
        $products = Product::where('top_item', 1)->latest()->take(10)->get();
        $products->transform(function ($product) {
            $product->image_url = !empty($product->image) && $product->image !== 'No File Uploaded'
                ? asset('storage/' . $product->image)
                : asset('user-assets/images/products/product-4.jpg');
            return $product;
        });
        //Log::info(["products"=>$products]);
        return response()->json($products);
    }
    public function updateSaleEnd(Request $request){
        $request->validate([
            'sale_end' => 'date|nullable',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->sale_end = $request->sale_end;
        $product->save();
        
        return response()->json(['success' => 'Sale end updated']);
    }

}
