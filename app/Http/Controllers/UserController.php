<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function changeStatus(Request $request, $id)
    {
        $user = User::find($id);
        $user->is_blocked = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }
}
