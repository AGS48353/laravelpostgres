<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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
    }
    public function get_power()
    {
        return Auth::user()->power;
    }
    public function get_cuser()
    {
        return Auth::user();
    }
    public function get_data()
    {
        return DataTables::eloquent(User::query())->make(true);
    }
    public function personalinput(Request $request)
    {
        //just incase they actually send a request directly thru handler like in "delete"
        if(!Auth::check()){return response()->json(['errors' => [0 =>'Authentication Error']], 401);}
        if(Auth::user()->power<=$request->power)
        {
            return response()->json(['errors' => [0 =>'Not Enough Power']], 400);
        }
        // validate fields
        if($request->password != $request->passwordConfirm)
        {
            return response()->json(['errors' => [0 =>'Password does not match']], 400);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:48', 'unique:users'],
            'phone' => ['required', 'integer', 'max:9999999999'],
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
        $createUser->power = 0;
        $createUser->save();
        return response()->json($createUser, 201);
    }
    public function edit(Request $request, $link_id)
    {
        if(!Auth::check()){return response()->json(['errors' => [0 =>'Authentication Error']], 401);}
        if(Auth::user()->power<=$request->power)
        {
            return response()->json(['errors' => [0 =>'Not Enough Power']], 400);
        }
        // validation fields
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:48'],
            'phone' => ['required', 'integer', 'max:9999999999'],
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
        $user_infos->email = $request->email;
        $user_infos->save();
        $user_infos->currentuser = Auth::user()->power;
        return response()->json($user_infos, 202);
    }
    public function delete($link_id)
    {
        if(!Auth::check()){return response()->json(['errors' => [0 =>'Authentication Error']], 401);}
        $user_infos = User::find($link_id);
        if(Auth::user()->power<=$user_infos->power)
        {
            return response()->json(['errors' => [0 =>'Not Enough Power']], 400);
        }
        $delUsers = User::destroy($link_id);
        return response()->json($link_id, 204);
    }
}
