<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Disponibility;
use Illuminate\Http\Request;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index(Request $request){

        $today = \Carbon\Carbon::now()->toDateString();

        $tomorrow = \Carbon\Carbon::now()->addDays(1)->toDateString();

        $today_schedules = Schedule::whereHas('disponibility', function($query) use($today)
        {
            $query->whereDate('date','=',$today);

        })->get()->count();

        $today_disponibilities = Disponibility::whereDate('date','=',$today)->doesnthave('schedule')->get()->count();


        $tomorrow_schedules = Schedule::whereHas('disponibility', function($query) use($tomorrow)
        {
            $query->whereDate('date','=',$tomorrow);

        })->get()->count();

        $tomorrow_disponibilities = Disponibility::whereDate('date','=',$tomorrow)->doesnthave('schedule')->get()->count();



        return response()->json([

            'today' => [
                'schedules' => $today_schedules,
                'disponibility' => $today_disponibilities
            ],
            'tomorrow' => [
                'schedules' => $tomorrow_schedules,
                'disponibility'=> $tomorrow_disponibilities
            ]

        ],200);
    }
}
