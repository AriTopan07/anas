<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/categories');
            return $next($request);
        });
    }

    public function index()
    {
        $data = Category::latest()->get();

        return view('data.category.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'categories_name' => 'required'
            ]);

            Category::create([
                'categories_name' => $request->categories_name,
            ]);

            $request->session()->flash('success', 'Category created successfully');

            return redirect()->back()->with(['success', 'Category created successfully']);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = Category::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'edit_nama' => 'required|string',
            ]);

            $data = Category::findOrFail($id);

            $data->update([
                'categories_name' => $request->edit_nama,
            ]);

            $request->session()->flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Category updated failed',
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Category::findOrFail($id);

            if (Goods::where('category_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Cannot delete category, category was in use');
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete category',
                ]);
            } else {
                $data->delete();

                $request->session()->flash('success', 'Delete category successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Delete category successfully'
                ]);
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Delete failed',
            ]);
        }
    }
}
