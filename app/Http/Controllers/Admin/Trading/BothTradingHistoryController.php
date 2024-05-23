<?php

namespace App\Http\Controllers\Admin\Trading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnergyProduct;
use App\Models\Trade;
use DB;

class BothTradingHistoryController extends Controller
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
     * Display profile update form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trades = Trade::where('buyer_id', $request->user()->id)->get();
        $energy_products = EnergyProduct::where('seller_id', $request->user()->id)->get();

        return view('admin.trading.bothTradeHistory', [
            'trades' => $trades,
            'energy_products' => $energy_products
        ]);
    }

}
