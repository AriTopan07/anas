<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Category;
use App\Models\Goods;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/goods');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Goods", "view") !== true) {
            return view('error.403');
        }

        $data['units'] = Unit::get();
        $data['category'] = Category::get();
        $data['supplier'] = Supplier::get();
        $data['count'] = DB::table('goods')
            ->where('verified', 0)
            ->count();
        $data['new'] = DB::table('goods')
            ->select('goods.*', 'categories.categories_name', 'suppliers.suppliers_name', 'units.units_name', 'users.name as user_name')
            ->join('units', 'goods.units_id', '=', 'units.id')
            ->join('categories', 'goods.category_id', '=', 'categories.id')
            ->join('suppliers', 'goods.supplier_id', '=', 'suppliers.id')
            ->join('users', 'goods.created_by', '=', 'users.id')
            ->where('goods.verified', '=', 0)
            ->orderBy('goods.created_at', 'desc')
            ->get();

        if (request()->category_id) {
            $category_id = $request->input('category_id');

            $data['verified'] = Goods::with('in', 'out')
                ->select(
                    'goods.*',
                    'categories.categories_name',
                    'suppliers.suppliers_name',
                    'units.units_name',
                    'created_by_user.name as created_by_name',
                    'updated_by_user.name as updated_by_name'
                )
                ->join('units', 'goods.units_id', '=', 'units.id')
                ->join('categories', 'goods.category_id', '=', 'categories.id')
                ->join('suppliers', 'goods.supplier_id', '=', 'suppliers.id')
                ->join('users as created_by_user', 'goods.created_by', '=', 'created_by_user.id')
                ->leftJoin('users as updated_by_user', 'goods.updated_by', '=', 'updated_by_user.id')
                ->where('goods.verified', '=', 1)
                ->where('goods.category_id', '=', $category_id)
                ->orderBy('goods.created_at', 'desc')
                ->get();

            foreach ($data['verified'] as $value) {
                $in = $value->in->where('verified', 1)->sum('qty');
                $out = $value->out->where('verified', 1)->sum('qty');

                $stock = $in - $out;

                $value->stock = $stock;
            }
        } else {
            $data['verified'] = Goods::with('in', 'out')
                ->select(
                    'goods.*',
                    'categories.categories_name',
                    'suppliers.suppliers_name',
                    'units.units_name',
                    'created_by_user.name as created_by_name',
                    'updated_by_user.name as updated_by_name'
                )
                ->join('units', 'goods.units_id', '=', 'units.id')
                ->join('categories', 'goods.category_id', '=', 'categories.id')
                ->join('suppliers', 'goods.supplier_id', '=', 'suppliers.id')
                ->join('users as created_by_user', 'goods.created_by', '=', 'created_by_user.id')
                ->leftJoin('users as updated_by_user', 'goods.updated_by', '=', 'updated_by_user.id')
                ->where('goods.verified', '=', 1)
                ->orderBy('goods.created_at', 'desc')
                ->get();

            foreach ($data['verified'] as $value) {
                $in = $value->in->where('verified', 1)->sum('qty');
                $out = $value->out->where('verified', 1)->sum('qty');

                $stock = $in - $out;

                $value->stock = $stock;
            }
        }


        return view('data.goods.index', compact('data'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'units_id' => 'required|exists:units,id',
                'supplier_id' => 'required|exists:suppliers,id',
                'name' => 'required',
                'brand' => 'required',
                'description' => 'required',
            ]);

            $user = Auth::user();

            Goods::create([
                'category_id' => $request->category_id,
                'units_id' => $request->units_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'brand' => $request->brand,
                'description' => $request->description,
                'status' => 1,
                'verified' => 0,
                'created_by' => $user->id,
            ]);

            $request->session()->flash('success', 'goods created successfully');

            return redirect()->back()->with(['success', 'Goods created successfully']);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = DB::table('goods')
            ->select('goods.*', 'categories.categories_name', 'suppliers.suppliers_name', 'units.units_name', 'users.name as user_name')
            ->join('units', 'goods.units_id', '=', 'units.id')
            ->join('categories', 'goods.category_id', '=', 'categories.id')
            ->join('suppliers', 'goods.supplier_id', '=', 'suppliers.id')
            ->join('users', 'goods.created_by', '=', 'users.id')
            ->where('goods.verified', '=', 1)
            ->where('goods.id', '=', $id)
            ->orderBy('goods.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Goods::findOrFail($id);
            $user = Auth::user();

            $data->update([
                'category_id' => $request->edit_category,
                'units_id' => $request->edit_units,
                'supplier_id' => $request->edit_suppliers,
                'name' => $request->edit_name,
                'brand' => $request->edit_brand,
                'description' => $request->edit_description,
                'updated_by' => $user->id,
            ]);

            $request->session()->flash('success', 'Goods updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'goods updated successfully',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function terima(Request $request, $id)
    {
        try {
            $barang = Goods::findOrFail($id);

            $barang->verified = 1;

            $barang->save();

            $request->session()->flash('success', 'Accepted successfully');

            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $data = Goods::findOrFail($id);
        $data->delete();

        $request->session()->flash('success', 'Goods deleted successfully');
        return response()->json([
            'success' => true,
            'message' => 'Goods deleted successfully',
        ]);
    }
}
