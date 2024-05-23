<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Energy;
use App\Models\EnergyProduct;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // check if authenticated, then redirect to dashboard
    // protected function authenticated() {
    //     if (Auth::check()) {
    //         return redirect()->route('dashboard');
    //     }
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        $zones = Zone::all();
        $energies = Energy::all();
        return view('home',[
            'zones' => $zones,
            'energies' => $energies
        ]);
    }

    /**
     * Show the trading page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEnergyProducts(Request $request)
    {
        $zone_id = $request->zone_id;
        $energy_id = $request->energy_id;

        if( ($zone_id < 0) || ($energy_id < 0) ) {
            $energy_products = EnergyProduct::all();
            return view('trading', ['energy_products' => $energy_products]);
        } else {
            $energy_products = EnergyProduct::whereHas('seller', function ($query) use ($zone_id) {
                    $query->where('zone_id', $zone_id);
                })->where('energy_id', $energy_id)->get();
                
            return view('trading', ['energy_products' => $energy_products]);
        }
        
    }
}
