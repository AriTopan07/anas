<?php

namespace App\Http\Controllers;

use App\Http\Repository\SellerRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/users');
            return $next($request);
        });
        $this->userRepository = $user;
    }

    public function index(Request $request)
    {
        $menu = 'User';
        $data = $this->userRepository->get_all();
        return view('page.users', compact('data', 'menu'));
    }

    public function show($id)
    {
        $data = $this->userRepository->get_data_by_id($id);
        if (!empty($data)) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->create($request->all());

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Berhasil ditambahkan!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6',
            'status' => 'required|in:active,nonactive'
        ]);

        User::where('id', $id)->update([
            'password' => bcrypt($request->input('password')),
            'status' => $request->input('status')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diubah!'
        ]);
    }
}
