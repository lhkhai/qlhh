<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;

class CategoriesController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $categories = categories::paginate($perPage);
        return view('category.categories')->with(['dataview'=>$categories,'perPage'=>$perPage]);
    }
    
    
}
