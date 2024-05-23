<?php

namespace App\Http\Controllers\Admin\Trading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnergyProduct;
use App\Models\FixedCharge;
use App\Models\Trade;
use App\Models\TradeHistory;
use App\Models\User;
use DB;

class BuyerMarketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('buyer');
    }

    /**
     * Display seller market.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $user_zone = $request->user()->zone->name;
        // $energy_products = EnergyProduct::whereHas('seller', function ($query) use ($user_zone) {
        //     $query->whereHas('zone', function ($query) use ($user_zone) {
        //         $query->where('name', $user_zone);
        //     });
        // })->where('remaining_volume', '>', '0')->get();

        $zone_id = $request->user()->zone_id;
        $energy_products = EnergyProduct::whereHas('seller', function ($query) use ($zone_id) {
                $query->where('zone_id', $zone_id);
            })->where('remaining_volume', '>', '0')->get();

        return view('admin.trading.buyerMarket', [
            'energy_products' => $energy_products
        ]);
    }

    /**
     * Show the form for buying specified energy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buyForm(Request $request)
    {
        $energyProduct = EnergyProduct::where('id', $request->energy_product_id)->first();
        return view('admin.trading.buyEnergy', compact('energyProduct'));
    }

    public function ajaxGetPriceDetails(Request $request)
    {
        $avg_price = EnergyProduct::where('energy_id', $request->energy_id)->avg('seller_price');
        $admin_fee = FixedCharge::where('id', 1)->get(['amount'])->toArray()[0]["amount"];
        $tax_rate = FixedCharge::where('id', 2)->get(['amount'])->toArray()[0]["amount"];
        return response()->json(array(
                                'success' => true,
                                'avg_price'=>$avg_price,
                                'admin_fee'=>$admin_fee,
                                'tax_rate'=>$tax_rate
                            ));
    }

    /**
     * Process trade upon user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buyEnergy(Request $request)
    {
        $max = 'max:'.$request->remaining_volume;
        $request->validate([
            'buy_volume' => ['required', 'numeric', 'min:1', $max],
        ],
        [
            'buy_volume.max' => "Buy Volume cannot be greater than the Available Volume.",
            'buy_volume.min' => "Invalid Buy Volume"
        ]);

        if($request->user()->balance < $request->trade_price) {
            return redirect()->route('Market\BuyEnergy', $request->energy_product_id)
                    ->with('error','Your do not have enough balance to buy the enargy.');
        } else {
            DB::beginTransaction(); 

                // Create trade
                Trade::create([
                    'energy_product_id' => $request->energy_product_id,
                    'volume' => $request->buy_volume,
                    'buyer_id' => $request->user()->id,
                    'trade_price' => $request->trade_price,
                    'average_price' => $request->average_price,
                    'admin_fee' => $request->admin_fee,
                    'tax_rate' => $request->tax_rate,
                ]);

                //Reduce buyer balance
                $request->user()->fill([
                    'balance' => ($request->user()->balance - $request->trade_price)
                ])->save();

                //Increase seller balance
                $seller = User::where('id', $request->seller_id)->first();
                $seller->fill([
                    'balance' => ($seller->balance + ($request->trade_price - $request->admin_fee))
                ])->save();

                //Reduce remaining volume
                $energy_product = EnergyProduct::where('id', $request->energy_product_id)->first();
                $energy_product->fill([
                    'remaining_volume' => ($request->remaining_volume - $request->buy_volume)
                ])->save();

                TradeHistory::create([
                    'energy_id' => $request->energy_id,
                    'volume' => $request->buy_volume
                ]);

            DB::commit(); 

            if($request->user()->trading_position == 3) {
                return redirect()->route('bothMarket')
                    ->with('success','Energy purchased successfully.');
            } else {
                return redirect()->route('buyerMarket')
                    ->with('success','Energy purchased successfully.');
            }
        }
    }

}
