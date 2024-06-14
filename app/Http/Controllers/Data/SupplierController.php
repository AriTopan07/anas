<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Goods;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/suppliers');
            return $next($request);
        });
    }

    public function index()
    {
        $data = Supplier::latest()->get();

        return view('data.supplier.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'suppliers_name' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);

            Supplier::create([
                'suppliers_name' => $request->suppliers_name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            $request->session()->flash('success', 'Supplier created successfully');

            return redirect()->back()->with(['success', 'Supplier created successfully']);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = Supplier::where('id', $id)->first();
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
                'edit_phone' => 'required|string',
                'edit_address' => 'required|string',
            ]);

            $data = Supplier::findOrFail($id);

            $data->update([
                'suppliers_name' => $request->edit_nama,
                'phone' => $request->edit_phone,
                'address' => $request->edit_address,
            ]);

            $request->session()->flash('success', 'Supplier updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Supplier updated successfully',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Supplier updated failed',
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Supplier::findOrFail($id);

            if (Goods::where('supplier_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Cannot delete supplier, supplier was in use');
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete supplier',
                ]);
            } else {
                $data->delete();

                $request->session()->flash('success', 'Delete supplier successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Delete supplier successfully'
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
