<?php

namespace App\Http\Controllers\Admin\Trading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\SellPriceRule;
use App\Models\EnergyProduct;
use App\Models\Energy;
use DB;
use Response;

class BothMarketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('buyerANDseller');
    }

    /**
     * Display seller market.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $zone_id = $request->user()->zone_id;
        $buy_energy_products = EnergyProduct::whereHas('seller', function ($query) use ($zone_id) {
                $query->where('zone_id', $zone_id);
            })->where('remaining_volume', '>', '0')->get();
        
        $sell_energy_products = EnergyProduct::where('seller_id', $request->user()->id)->where('remaining_volume', '>', '0')->get();
        return view('admin.trading.bothMarket', [
            'buy_energy_products' => $buy_energy_products,
            'sell_energy_products' => $sell_energy_products
        ]);
    }

}
