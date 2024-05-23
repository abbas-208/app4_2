<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Energy;
use App\Models\EnergyHistory;
use App\Models\FixedCharge;
use App\Models\ChargeHistory;
use App\Models\Trade;
use DB;
use Response;

class MasterTradingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('manager')->except('ajaxGetEnergies');
    }

    /**
     * Display page details.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trades = Trade::all();
        return view('admin.masterTrading', ['trades' => $trades]);
    }

    /**
     * return energy list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetEnergies(Request $request)
    {
        $energies = Energy::all();
        if ($request->action_buttons == 'true') {
            $returnHTML = view('admin.ajaxViews.energyTable')->with('energies', $energies)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        } else {
            $returnHTML = view('admin.ajaxViews.latestMarketPriceTable')->with('energies', $energies)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    /**
     * Store a newly created Energy in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreateEnergy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'unique:energies'],
            'marketPrice' => ['required', 'max:2000'],
        ]);

        if ($validator->passes()) {

            DB::beginTransaction();

                $all_energies = Energy::all();
                foreach ($all_energies as $e) {
                    $detail = DB::select(DB::raw("SELECT energy_id, market_price FROM energy_histories WHERE energy_id = $e->id ORDER BY Date(created_at) DESC LIMIT 1;"))[0];
                    
                    EnergyHistory::create([
                        'energy_id' => $detail->energy_id,
                        'market_price' => $detail->market_price,
                    ]);
                }

                $energyID = Energy::create([
                    'type' => $request->type,
                    'market_price' => $request->marketPrice,
                ])->id;

                EnergyHistory::create([
                    'energy_id' => $energyID,
                    'market_price' => $request->marketPrice,
                ]);

            DB::commit(); 

            return response()->json(['success'=>'New Energy Created successfully.']);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Update Energy in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxUpdateEnergy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'typeUp' => ['required', 'unique:energies,type,'.$request->energy_id],
            'marketPriceUp' => ['required'],
        ],
        [
            'typeUp.required' => 'This field is required.',
            'typeUp.unique' => 'Energy Type already exists',
            'marketPriceUp.required' => 'This field is required.'
        ]);

        if ($validator->passes()) {

            DB::beginTransaction(); 

                Energy::where('id', $request->energy_id)
                        ->update([
                            'type' => $request->typeUp,
                            'market_price' => $request->marketPriceUp,
                        ]);

                $all_energies = Energy::all();
                foreach ($all_energies as $e) {
                    $detail = DB::select(DB::raw("SELECT energy_id, market_price FROM energy_histories WHERE energy_id = $e->id ORDER BY Date(created_at) DESC LIMIT 1;"))[0];
                    if ($detail->energy_id != $request->energy_id) {
                        EnergyHistory::create([
                            'energy_id' => $detail->energy_id,
                            'market_price' => $detail->market_price,
                        ]);
                    }
                }

                EnergyHistory::create([
                    'energy_id' => $request->energy_id,
                    'market_price' => $request->marketPriceUp,
                ]);

            DB::commit(); 

            return response()->json(['success'=>'Energy updated successfully.']);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Delete Item in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxDeleteItem(Request $request)
    {
        Energy::where('id', $request->item_id)->delete();

        return response()->json(['success'=>'Energy deleted successfully.']);
    }

    
    /**
     * return energy history list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetEnergyHistory(Request $request)
    {
        $energyHistory = EnergyHistory::where('energy_id', $request->energy_id)->orderBy('created_at', 'DESC')->get(['market_price','created_at']);
        //$query = "SELECT * FROM (SELECT date(created_at) created_at, market_price FROM energy_histories where energy_id = ";
        //$query .= "$request->energy_id";
        //$query .= " ORDER BY date(created_at) desc ) as whatever GROUP BY created_at ORDER BY created_at desc;";
        //dd($query);
        //$energyHistory = DB::select(DB::raw($query));
        $returnHTML = view('admin.ajaxViews.energyHistoryTable')->with('energyHistory', $energyHistory)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    /**
     * return fees list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetFees(Request $request)
    {
        $fees = FixedCharge::all();
        $returnHTML = view('admin.ajaxViews.feesTable')->with('fees', $fees)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    /**
     * Update Fee in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxUpdateFee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feeAmount' => ['required'],
        ],
        [
            'feeAmount.required' => 'This field is required.'
        ]);

        if ($validator->passes()) {

            FixedCharge::where('id', $request->fee_id)
                    ->update([
                        'amount' => $request->feeAmount,
                    ]);

            ChargeHistory::create([
                'charge_id' => $request->fee_id,
                'amount' => $request->feeAmount,
            ]);

            return response()->json(['success'=>'Fee updated successfully.']);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * return fee history list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetFeesHistory(Request $request)
    {
        $feeHistory = ChargeHistory::where('charge_id', $request->fee_id)->orderBy('created_at', 'DESC')->get(['amount','created_at']);
        $returnHTML = view('admin.ajaxViews.feeHistoryTable')->with('feeHistory', $feeHistory)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

}