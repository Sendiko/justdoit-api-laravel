<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $categories = Category::where('user_id', $user_id)->get();

        return response()->json([
            "status" => 200,
            "message"=> "data successfully sent",
            "categories" => $categories 
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        function randomHEx() {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        $validated = $request->validate([
            "category" => "string|required",
            "color" => "string|required",
        ]);

        $category = Category::create($validated);

        return response()->json([
            "status" => 201,
            "message" => "data successfully stored",
            "category" => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "category" => "string",
            "color" => "string",
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return response()->json([
            "status" => 200,
            "message" => "data successfully updated",
            "category" => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->destroy();

        return response()->json([
            "status" => 200,
            "message" => "data successfully deleted",
        ]);
    }
}
