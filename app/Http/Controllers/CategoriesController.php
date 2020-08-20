<?php


namespace App\Http\Controllers;


use App\Categories;
use App\CRUD;
use App\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('categories.list', compact('categories'));
    }

    public function getCategories()
    {
        $categories = Categories::all();
        return response()->json($categories)->header('Content-Type', 'application/json');
    }

    public function deleteCategory (Request $request) {
        $result = CRUD::deleteCategory($request->input());
        return response()->json($result)->header('Content-Type', 'application/json');
    }


    public function update(Request $request){
        $result = CRUD::updateCategory($request->input());
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    public function store(Request $request)
    {
        $result = CRUD::createCategory($request->input());
        return response()->json($result)->header('Content-Type', 'application/json');
    }

    public function create()
    {
        return view('categories.create');
    }
}
