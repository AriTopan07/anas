<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceive;
use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/');
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transaksi_hari_ini = GoodsReceive::latest()->get();

        $user = auth()->user();

        $group_id = DB::table('user_groups')
            ->where('user_id', $user->id)
            ->value('group_id');

        return view('home', [
            'user' => $user,
            'group_id' => $group_id,
            'transaksi_hari_ini' => $transaksi_hari_ini
        ]);
    }
}
