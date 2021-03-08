<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){

        $query_params = json_decode($request->queryParams,true);

        $users = User::where('id','=',(int)$query_params['global_search'])
                ->orWhere('name','like',"%{$query_params['global_search']}%")
                ->orWhere('email','like',"%{$query_params['global_search']}%")
                ->with('user_type')
                ->paginate((int) $query_params['per_page'],'*','page',$request->get('page',null));

        return response()->json($users,200);
    }

    public function doctors(Request $request){
        $users = User::whereHas('user_type',function($query){
            $query->where('id',2);
        })->select('name as text','id as value')->get();

        return response()->json($users,200);
    }

    public function patients(Request $request){
        $users = User::whereHas('user_type',function($query){
            $query->where('id',1);
        })->select('name as text','id as value')->get();

        return response()->json($users,200);
    }

    public function show(User $user){
        return response()->json($user,200);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|min:3|string',
            'email' => 'required|email',
            "password" => 'required|string',
            'type' => 'nullable|integer'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type_id' => $request->get('type',1)
        ]);

        return response()->json($user,200);
    }

    public function update(Request $request, User $user){

        $request->validate([
            'name' => 'nullable|min:3|string',
            'email' => 'nullable|email',
            "password" => 'nullable|string',
            'type' => 'nullable|integer'
        ]);

        $user->update([
            'name' => $request->get('name',$user->name),
            'email' => $request->get('email',$user->email),
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
            'user_type_id' => $request->get('user_type_id',$user->user_type_id)
        ]);

        return response()->json($user,200);
    }

    public function delete(User $user){
        $user->delete();
        return response()->json(null,200);
    }

}
