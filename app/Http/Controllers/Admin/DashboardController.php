<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnergyProduct;
use App\Models\Energy;
use DB;
use Response;

class DashboardController extends Controller
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
     * Display dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $market_prices = Energy::all();
        $energies = DB::select(DB::raw("SELECT e.type 'Energy', sum(ep.remaining_volume) 'TotalAvailableVolume'
                                        FROM energy_products ep JOIN energies e 
                                        ON ep.energy_id = e.id
                                        GROUP BY ep.energy_id;"));
        
        //** --- trading_chart --- */ 
        $energyIds = DB::table('energies')->pluck('id', 'type')->all();

        // Start building the SQL query dynamically
        $query = "SELECT SUBQ.X AS Date";
        foreach ($energyIds as $id) {
            $type_name = array_search($id, $energyIds);
            $query .= ", max(SUBQ.`$type_name`) AS '$type_name'";
        }
        $query .= " from ( SELECT date(t.created_at) X";

        foreach ($energyIds as $id) {
            $type_name = array_search($id, $energyIds);
            $query .= ", CASE WHEN t.energy_id = $id THEN t.market_price ELSE 0 END AS '$type_name'";
        }
        $query .= " from energy_histories t where created_at = ( select max(t1.created_at) from energy_histories t1 where  date(t1.created_at) = date(t.created_at) and t1.energy_id= t.energy_id group by date(t1.created_at) ) ) SUBQ group by X";

        // Execute the query
        $results = DB::select(DB::raw($query));
        $data = "['Date', ";
        $total = count($energyIds);
        foreach ($energyIds as $id) {
            $type_name = array_search($id, $energyIds);
            if ($total == count($energyIds)) {
                $data .= "'$type_name'";
            } else {
                $data .= ", '$type_name'";
            }
            $total = $total - 1;
        }
        $data .= "],";
        $res_total = count($results);
        $res_count = 0;
        foreach ($results as $val) {
            if ($res_total - $res_count <= 5) {
                $arr = (array)$val;
                $data .= "[";
                $total = count($arr);
                foreach ($arr as $item) {
                    if ($total == count($arr)) {
                        $data .= "'$item'";
                    } else {
                        $data .= ",$item";
                    }
                    $total = $total - 1;
                }
                $data .= "],";
            }
            $res_count++;
        }
        //dd($data);

        //** --- sold_energy_chart --- */ 
        $energyIds = DB::table('trade_histories')
                            ->join('energies', 'trade_histories.energy_id', '=', 'energies.id')
                            ->distinct()->pluck('energy_id', 'type')->all();
        // Start building the SQL query dynamically
        $query = "SELECT date(created_at)";

        foreach ($energyIds as $id) {
            $type_name = array_search($id, $energyIds);
            $query .= ", SUM(CASE WHEN energy_id = $id THEN volume ELSE 0 END) AS '$type_name'";
        }
        $query .= " FROM trade_histories GROUP BY date(created_at) ORDER BY date(created_at);";
        
        // Execute the query
        $results = DB::select(DB::raw($query));
        $sellGraph = "['Date', ";
        $total = count($energyIds);
        $type_names = array();
        foreach ($energyIds as $id) {
            $type_name = array_search($id, $energyIds);
            $type_names[] = $type_name; 
            if ($total == count($energyIds)) {
                $sellGraph .= "'$type_name'";
            } else {
                $sellGraph .= ", '$type_name'";
            }
            $total = $total - 1;
        }
        $sellGraph .= "],";
        $res_total = count($results);
        $res_count = 0;
        $previous_result = $results[0];
        foreach ($results as $val) {
            if ($res_total - $res_count <= 5) {
                $arr = (array)$val;
                $sellGraph .= "[";
                $total = count($arr);
                $arr_count = -1;
                foreach ($arr as $item) {
                    if ($total == count($arr)) {
                        $sellGraph .= "'$item'";
                    } else {
                        if ($item == 0) {
                            $tn = $type_names[$arr_count];
                            $item = $previous_result->$tn;
                        }
                        $sellGraph .= ",$item";
                    }
                    $total = $total - 1;
                    $arr_count++;
                }
                $sellGraph .= "],";
            }
            $res_count++;
            $previous_result = $val;
        }
        //dd($sellGraph);

        //** users_chart */ 
        $zones = DB::table('zones')->pluck('id', 'name')->all();

        // Start building the SQL query dynamically
        $query = "SELECT zones.id, ";

        $query .= "SUM(CASE WHEN trading_position = 1 THEN 1 ELSE 0 END) AS Buyer";
        $query .= ", SUM(CASE WHEN trading_position = 2 THEN 1 ELSE 0 END) AS 'Seller'";
        $query .= ", SUM(CASE WHEN trading_position = 3 THEN 1 ELSE 0 END) AS 'Both'";

        $query .= " FROM users right join zones on users.zone_id = zones.id GROUP BY zones.id ORDER BY zones.id;";
        
        // Execute the query
        $results = DB::select(DB::raw($query));

        $userGraph = "";
        foreach ($results as $val) {
            $arr = (array)$val;
            $userGraph .= "[";
            $total = count($arr);
            foreach ($arr as $item) {
                if ($total == count($arr)) {
                    $zone_name = array_search($item, $zones);
                    $userGraph .= "'$zone_name'";
                } else {
                    $userGraph .= ",$item";
                }
                $total = $total - 1;
            }
            $userGraph .= "],";
        }
        //dd($userGraph);

        // return
        return view('admin.dashboard', [
            'market_prices' => $market_prices,
            'energies' => $energies,
            'trade_graph' => $data,
            'traded_energy' => $sellGraph,
            'userGraph' => $userGraph
        ]);
    }
}
