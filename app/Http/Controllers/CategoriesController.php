<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    
    public function index()
    {
        try {
            $categories = Category::where("user_id", Auth::user()->id)->get();
            $data = [
                'status' => 'success',
                'categories' => $categories
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {

            $data = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        \Log::info($request->all());
        try {
            $category = new Category();
            $category->name = $request->input('name');
            $category->user_id = Auth::user()->id;
            $category->save();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            $data = [
                'status' => 'error',
                'line' => $e->getLine(),
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

   
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        try{
            $category = Category::find($id);
            $category->name = $request->input('name');
            $category->save();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            $data = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            $data = [
                'status' => 'error',
                'line' => $e->getLine(),
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }
}
