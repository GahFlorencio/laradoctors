<?php

namespace App\Http\Controllers\Disponibility;

use App\Http\Controllers\Controller;
use App\Models\Disponibility;
use App\Models\User;
use Illuminate\Http\Request;

class DisponibilityController extends Controller
{
    public function index(Request $request){

        $query_params = json_decode($request->queryParams,true);

        $users = Disponibility::whereHas('user' , function($query) use($query_params){
            $query->where('name','like',"%{$query_params['global_search']}%");
        })->with(['user','schedule'])->paginate((int) $query_params['per_page'],'*','page',$request->get('page',null));

        return response()->json($users,200);
    }

    public function options(Request $request){

         $dispos = Disponibility::whereDoesntHave('schedule')->select('date as text','id as value')->get();

        return response()->json($dispos,200);
    }

    public function show(Disponibility $disponibility){
        return response()->json($disponibility,200);
    }

    public function store(Request $request,  Disponibility $disponibility){

        $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|integer'
        ]);


        $disponibility = $disponibility->create(
            $request->only('date','user_id')
        );

        return response()->json($disponibility,200);

    }

    public function update(Request $request, Disponibility $disponibility){

        $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|integer'
        ]);

        $disponibility = $disponibility->update(
            $request->only('date','user_id')
        );

        return response()->json($disponibility,200);

    }

    public function delete(Disponibility $disponibility){
        $disponibility->delete();
        return response()->json(null,200);
    }
}
