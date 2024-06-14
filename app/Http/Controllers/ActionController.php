<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Repository\ActionRepository;

class ActionController extends Controller
{
    protected $action;

    public function __construct(ActionRepository $action)
    {

        $this->action = $action;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/action');
            return $next($request);
        });
    }

    public function index()
    {
        $data = $this->action->action();

        return view('page.master.aksi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->action->store($request);

        return response()->json([
            'success' => TRUE,
            'message' => 'Berhasil menambah data!'
        ]);
    }
}
