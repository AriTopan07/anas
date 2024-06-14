<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Goods;
use App\Models\Unit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/units');
            return $next($request);
        });
    }

    public function index()
    {
        $data['units'] = Unit::latest()->get();

        return view('data.units.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'units_name' => 'required'
            ]);

            Unit::create([
                'units_name' => $request->units_name,
            ]);

            $request->session()->flash('success', 'Unit created successfully');

            return redirect()->back()->with(['success', 'Unit created successfully']);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = Unit::where('id', $id)->first();
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

            $data = Unit::findOrFail($id);

            $data->update([
                'units_name' => $request->edit_nama,
            ]);

            $request->session()->flash('success', 'Unit updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Unit updated successfully',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Unit updated failed',
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Unit::findOrFail($id);

            if (Goods::where('units_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Cannot delete units, units was in use');
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete units',
                ]);
            } else {
                $data->delete();

                $request->session()->flash('success', 'Delete units successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Delete units successfully'
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
