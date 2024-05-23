<?php

namespace App\Http\Controllers\Admin\Trading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\EnergyProduct;
use App\Models\Trade;
use DB;
use Response;

class SellerTradingHistoryController extends Controller
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
     * Display trading history.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $energy_products = EnergyProduct::where('seller_id', $request->user()->id)->get();
        return view('admin.trading.sellerTradeHistory', ['energy_products' => $energy_products]);
    }

    /**
     * return sell history.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetSellHistory(Request $request)
    {
        $trades = Trade::where('energy_product_id', $request->energy_product_id)->get();
        $returnHTML = view('admin.ajaxViews.sellHistory')->with('trades', $trades)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

}
