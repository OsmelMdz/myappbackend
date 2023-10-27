<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function newCategory(Request $req){
        $category = category::create($req->all());
        return response($category, 200);
    }

    public function getCategories(){
        return response()->json(category::all(), 200);
    }

    public function getCategoryById($id){
        $category = category::find($id);
        if(is_null($category)){
            return response()->json(['msn' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }

    public function  deleteCategoryById($id){
        $category = category::find($id);
        if(is_null($category)){
            return response()->json(['msn' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['msn' => 'Categoria Eliminada', 200]);
    }


}
