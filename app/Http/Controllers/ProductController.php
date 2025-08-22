<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
 public function index()
{
    $products = Product::with('category')->orderByDesc('id')->paginate(10);

    if (auth()->check() && auth()->user()->role === 'admin' && request()->is('admin/*')) {
        return view('admin.products.index', compact('products'));
    }

    return view('products.index', compact('products')); // view public
}

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'price'       => ['required','numeric','min:0'],
            'quantity'    => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'description' => ['nullable','string'],
            'features'    => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,gif','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products','public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success','Thêm sản phẩm thành công.');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'price'       => ['required','numeric','min:0'],
            'quantity'    => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'description' => ['nullable','string'],
            'features'    => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,gif','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products','public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success','Sửa sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success','Xoá sản phẩm thành công.');
    }
}
