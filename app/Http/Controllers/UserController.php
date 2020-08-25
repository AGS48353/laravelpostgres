<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_infos = User::all();
        return view('userinfos', ['user_infos' => $user_infos]);
        // uhh main pphone
    }
    public function get_data()
    {
        return DataTables::eloquent(User::query())->make(true);
        // json pphone of pgsql
    }
    public function personalinput(Request $request)
    {
        // validate fields
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username'=>['required','string','max:48', 'unique:users'],
            'phone'=>['required','integer','max:9999999999'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        // validation failed
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        // passed creates new User
        $createUser = new User();
        $createUser->name = $request->name;
        $createUser->surname = $request->surname;
        $createUser->username = $request->username;
        $createUser->phone = $request->phone;
        $createUser->email = $request->email;
        $createUser->password = Hash::make($request->password);
        $createUser->save();
        return response()->json($createUser, 200);
    }
    public function edit(Request $request, $link_id)
    {
        // validation fields
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username'=>['required','string','max:48'],
            'phone'=>['required','integer','max:9999999999'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($link_id)],
        ]);
        // failed validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        // locates using pkey and replace info
        $user_infos = User::find($link_id);
        $user_infos->name = $request->name;
        $user_infos->surname = $request->surname;
        $user_infos->username = $request->username;
        $user_infos->phone = $request->phone;
        // $user_infos->email = $request->email;
        $user_infos->save();
        return response()->json($user_infos, 200);
    }
    public function delete($link_id)
    {
        $delUsers = User::destroy($link_id);
        return response()->json($delUsers, 200);
    }
}
