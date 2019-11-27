<?php

namespace App\Http\Controllers;

use Log;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function create(){
        if ( Auth::user()->isAdmin() ){
            return view('Category.create2');
            return view('Category.create');
        }
        return redirect('/');
    }


    public function store(Request $request){
        if ( Auth::user()->isAdmin() ){
            $validated = request()->validate([
                'name' => 'required | min:3',
            ]);

            Category::create($validated);
        }
        return redirect('/');
    }


    public function show(Category $category){
        return view('Category.list2', ['category' => $category]);
        return view('Product.listcat', ['category' => $category]);
    }

    public function showAll(Category $category){
        if ( Auth::user()->isAdmin() ){
            return view('Category.Admin.listcatNA2', ['category' => $category]);
            return view('Product.Admin.listcatNA', ['category' => $category]);
        }
        return redirect('/');
    }


    public function edit($id){
        if ( Auth::user()->isAdmin() ){
            //dd($category);
            $category = Category::findOrFail($id);
            return view('Category.edit2', ['category' => $category]);
            return view('Category.edit', ['category' => $category]);
        }
        return redirect('/');
    }


    public function update(Request $request, Category $category){
        if ( Auth::user()->isAdmin() ){
            $validated = request()->validate([
                'name' => 'required | min:3',
            ]);
            $category->update($validated);
            return redirect(action('CategoryController@show', $category->id));
        }
        return redirect('/');
    }


}
