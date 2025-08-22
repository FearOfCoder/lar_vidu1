<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index()
{
    $categories = Category::orderByDesc('id')->paginate(10);

    if (auth()->check() && auth()->user()->role === 'admin' && request()->is('admin/*')) {
        return view('admin.categories.index', compact('categories'));
    }

    abort(403); // user không được vào categories public
}


  public function create() { return view('admin.categories.create'); }
   public function store(\Illuminate\Http\Request $request) {
    $data = $request->validate(['name' => ['required','string','max:255']]);
    \App\Models\Category::create($data);
    return redirect()->route('admin.categories.index')->with('success','Tạo danh mục thành công.');
}

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
public function edit(\App\Models\Category $category) {
    return view('admin.categories.edit', compact('category'));
}

    public function update(\Illuminate\Http\Request $request, \App\Models\Category $category) {
    $data = $request->validate(['name' => ['required','string','max:255']]);
    $category->update($data);
    return redirect()->route('admin.categories.index')->with('success','Cập nhật danh mục thành công.');
}

    public function destroy(\App\Models\Category $category) {
    $category->delete();
    return redirect()->route('admin.categories.index')->with('success','Xoá danh mục thành công.');
}
}
