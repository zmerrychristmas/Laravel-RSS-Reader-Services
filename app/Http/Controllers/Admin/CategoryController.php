<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Category;
use Hash;

class CategoryController extends Controller
{

    public function index()
    {
        $items = Category::where('user_id', '=', auth()->user()->id)->get();
        return view('categories.index', ['items' => $items]);
    }

    public function create(Request $request)
    {
        if (!$request->id) {
            $rules = [
                'name' => 'required|unique:categories'
            ];
            $request->validate($rules);
            // Create Category
            Category::create(['name' => $request->name, 'user_id' => auth()->user()->id]);
            return redirect()->action('Admin\CategoryController@index')->with(['message-success' => 'Add Category Success']);
        } else {
            $rules = [
                'name' => 'required|unique:categories,name,' . $request->id
            ];
            $request->validate($rules);
            // Update Category
            $category = Category::find($request->id);
            if ($category) {
                $category->name = $request->name;
                $category->save();
            } else {
                return redirect()->action('Admin\CategoryController@index')->with(['message-errors' => 'Category not found']);
            }
            return redirect()->action('Admin\CategoryController@index')->with(['message-success' => 'Update Category Success']);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->category_delete;
        $cat = Category::find($id);
        if ($cat) {
            $cat->delete();
        }
        return redirect()->action('Admin\CategoryController@index')->with(['message-success' => 'Delete Category Success']);
    }
}
