<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request){
        $query_params = json_decode($request->queryParams,true);

        $schedules = Schedule::whereHas('user' , function($query) use($query_params){
            $query->where('name','like',"%{$query_params['global_search']}%");
        })->with(['user','disponibility'])->paginate((int) $query_params['per_page'],'*','page',$request->get('page',null));

        return response()->json($schedules,200);
    }

    public function show(Schedule $schedule){
        return response()->json($schedule,200);
    }

    public function store(Request $request){

        $request->validate([
            'user_id' => 'required|integer',
            'disponibility_id' => 'required|integer',
            'observation' => 'nullable|string'
        ]);


       $schedule = Schedule::create(
            $request->only(['user_id','disponibility_id','observation'])
        );

        return response()->json($schedule,200);

    }

    public function update(Request $request, Schedule $schedule){

        $request->validate([
            'user_id' => 'required|integer',
            'disponibility_id' => 'required|integer',
            'observation' => 'nullable|string'
        ]);


       $schedule->update(
           $request->only(['user_id','disponibility_id','observation'])
       );

        return response()->json($schedule,200);

    }

    public function delete(Schedule $schedule){
        $schedule->delete();
        return response()->json(null,200);
    }
}
