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

class SellerMarketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Display seller market.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $energy_products = EnergyProduct::where('seller_id', $request->user()->id)->where('remaining_volume', '>', '0')->get();
        return view('admin.trading.sellerMarket', ['energy_products' => $energy_products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $energies = Energy::all();
        return view('admin.trading.sellEnergy', [
            'energies' => $energies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'energy_id' => ['required'],
            'volume' => ['required'],
            'seller_price' => [
                'required',
                'numeric',
                new SellPriceRule($request->energy_id)
            ],
        ],
        [
            'energy_id.required' => 'Please select an Energy',
            'volume.required' => 'required',
        ]);

        EnergyProduct::create([
            'energy_id' => $request->energy_id,
            'seller_id' => $request->user()->id,
            'seller_price' => $request->seller_price,
            'volume' => $request->volume,
            'remaining_volume' => $request->volume,
        ]);

        if($request->user()->trading_position == 3) {
            return redirect()->route('bothMarket')
                ->with('success','Your Energy is successfully listed in the market for sell');
        } else {
            return redirect()->route('sellerMarket')
                ->with('success','Your Energy is successfully listed in the market for sell');
        }
    }

}
