<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use ajax;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'info' => $categories
        ]);
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
    public function store(Request $request)
    {
        //return $request;
        // $request->validate([
        //     'categoryTitle' => 'required|string|max:255',
        //     'slug' => 'required|string|max:255|unique:categories',
        //     'description' => 'nullable|string',
        //     'status' => 'required|string',
        //     'parent_category' => 'nullable|integer',
        //     'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf', // adjust types as needed
        // ]);
        $filePath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filePath = $file->store('categories', 'public');
    } else {
        $filePath = "No File Uploaded";
    }
       
    $category = Category::create([
        'title' => $request->categoryTitle,
        'slug' => $request->slug,
        'image' => $filePath,
        'parent_id' => null,
        'description' => $request->description,
        'status' => $request->status,
        'created_at' => now(),
        'updated_at' => null,
    ]);

    return response()->json([
        'success' => true,
        'info' => $category,
        'path' => $filePath,
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
