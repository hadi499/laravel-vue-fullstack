<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Create');
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'slug' => 'required'
        ]);


        $validatedData['slug'] = Str::slug($request->name);
        Category::create($validatedData);
    }

    public function update(Request $request, Category $category)
    {

        $rules = [
            'name' => 'required|max:255|unique:categories,name',
            'slug' => 'required'
        ];


        $validatedData = $request->validate($rules);
        $validatedData['slug'] = Str::slug($request->name);

        $category->update($validatedData);
    }

    public function destroy(Category $category)
    {

        Category::destroy($category->id);
    }

    public function test()
    {
        return Inertia::render('Dashboard/Test');
    }

    public function storeTest()
    {
        return redirect('dashboard')->with('message', 'test is success!');
    }
}
