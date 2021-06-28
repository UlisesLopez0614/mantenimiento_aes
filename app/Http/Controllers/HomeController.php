<?php

namespace App\Http\Controllers;

use App\Empresas;
use App\Principal;
use App\Taller;
use App\Tipomanto;
use App\User;
use App\Vehiculo;
use Illuminate\Http\Request;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function home_data(){
        $Emp= Empresas::all()->pluck('name');
        $Usuarios  = User::all();
        $Mttos = Principal::where('quedan','<','480')->get();
        $Vehiculos = Vehiculo::select('Name','Fleet')->get();
        return response()->json([
            'taller_count' => Taller::all()->count(),
            'vehicles_count' => Vehiculo::all()->count(),
            'UT' => $Usuarios->where('Taller_id','<>',null)->count(),
            'UA' => $Usuarios->where('Taller_id','=',null)->count(),
            'Empresas'=> $Emp->toArray(),
            'E_Count'=> $Emp->count(),
            'T_Mtto' => Tipomanto::all()->pluck('nombre')->toArray(),
            'Vehicles_count' => $Vehiculos->count(),
            'Vehicles_Fleets'=>$Vehiculos->groupBy('Fleet'),
            'MV'    =>  $Mttos->where('quedan','<','0')->count(),
            'MP'    =>  $Mttos->where('quedan','>','0')->count(),
            'Fleet_Count' => $Vehiculos->groupBy('Fleet')->count()
        ]);
    }
}
