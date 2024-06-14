<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Repository\PermissionRepository;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsPicking;
use App\Models\GoodsReceive;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GoodsPickController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/goods-picking');
            return $next($request);
        });
    }

    public function index()
    {
        $data['goods'] = Goods::where('verified', '=', 1)->get();
        $data['new'] = DB::table('goods_pickings')
            ->select('goods_pickings.*', 'goods.name AS name', 'users.name as user_name')
            ->join('goods', 'goods_pickings.goods_id', '=', 'goods.id')
            ->join('users', 'goods_pickings.created_by', '=', 'users.id')
            ->where('goods_pickings.verified', '=', 0)
            ->orderBy('goods_pickings.created_at', 'desc')
            ->get();
        $data['verified'] = DB::table('goods_pickings')
            ->select(
                'goods_pickings.*',
                'goods.name AS name',
                'created_by_user.name AS created_by_name',
                'updated_by_user.name AS updated_by_name'
            )
            ->join('goods', 'goods_pickings.goods_id', '=', 'goods.id')
            ->join('users AS created_by_user', 'goods_pickings.created_by', '=', 'created_by_user.id')
            ->leftJoin('users AS updated_by_user', 'goods_pickings.updated_by', '=', 'updated_by_user.id')
            ->orderBy('goods_pickings.created_at', 'desc')
            ->where('goods_pickings.verified', '=', 1)
            ->get();
        $data['count'] = DB::table('goods_pickings')
            ->where('verified', 0)
            ->count();

        return view('data.goods-picking.index', compact('data'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'goods_id' => 'required|exists:goods,id',
                'date' => 'required|date',
                'qty' => 'required',
                'image' => 'required',
                'description' => 'required',
            ]);

            $user = Auth::user();

            $file = null;

            $stockData = Goods::find($request->goods_id);

            $in = $stockData->in->where('verified', 1)->sum('qty');
            $out = $stockData->out->where('verified', 1)->sum('qty');

            $stock = $in - $out;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('files/good_picking', 'public');
                $file = $path;
            }

            if ($stock >= $request->qty) {
                $data = GoodsPicking::create([
                    'goods_id' => $request->goods_id,
                    'date' => $request->date,
                    'description' => $request->description,
                    'qty' => $request->qty,
                    'image' => $file,
                    'created_by' => $user->id,
                ]);

                $this->wa($data);
                $request->session()->flash('success', 'Transaction successfully');
                return response([
                    'status' => true,
                    'message' => 'Transaction successfully'
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Insufficient stock to carry out this transaction, Current stock remaining ' . $stock
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function wa($data)
    {
        $goodsPickings = $data;
        $goods = Goods::find($goodsPickings->goods_id);

        if (!$goods) {
            return;
        }

        $message = "Notifikasi: *Barang Keluar *\nNama Barang: $goods->name\nTanggal: $goodsPickings->date\nDeskripsi: $goodsPickings->description\nJumlah: $goodsPickings->qty\n";

        $body = array(
            "api_key" => "f6a4f54170873b0bd3e0872f410fe740401fff6f",
            "receiver" => "6287889116984",
            "data" => array(
                "message" => $message,

            )
        );

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://wabot.appnis.net:5570/api/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                "Accept: /",
                "Content-Type: application/json",
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function checkStock(Request $request)
    {
        $stockData = Goods::find($request->id);

        if (!$stockData) {
            return response()->json(['exists' => false, 'message' => 'Select goods first']);
        }

        $in = $stockData->in->where('verified', 1)->sum('qty');
        $out = $stockData->out->where('verified', 1)->sum('qty');

        $stock = $in - $out;

        if ($stock >= $request->qty) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false, 'message' => 'Stock is not enough']);
        }
    }

    public function show($id)
    {
        $data = DB::table('goods_pickings')
            ->select('goods_pickings.*', 'goods.name as goods_name')
            ->join('goods', 'goods_pickings.goods_id', '=', 'goods.id')
            ->where('goods_pickings.id', '=', $id)
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
            $data = GoodsPicking::findOrFail($id);
            $user = Auth::user();

            $data->update([
                'goods_id' => $request->edit_goods,
                'date' => $request->edit_date,
                'qty' => $request->edit_qty,
                'description' => $request->edit_description,
                'updated_by' => $user->id,
            ]);

            $request->session()->flash('success', 'Goods picking updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Goods picking updated successfully',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'An error occurred during data validation ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function accept(Request $request, $id)
    {
        try {
            $data = GoodsPicking::findOrFail($id);

            $data->verified = 1;

            $data->save();

            $request->session()->flash('success', 'Accepted successfully');

            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        $data = GoodsPicking::findOrFail($id);
        $data->delete();

        $request->session()->flash('success', 'Goods picking deleted successfully');
        return response()->json([
            'success' => true,
            'message' => 'Goods picking deleted successfully',
        ]);
    }
}
