<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Log;
use App\Models\Mcu;
use App\Models\Office;
use App\Models\TotalCardMcu;
use App\Models\UserMcu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $count_office = Office::count();
        $count_card = Entry::count();
        $count_mcu = Mcu::count();
        $count_user_active = UserMcu::where('status_user', '0')->count();
        $count_user_no_active = UserMcu::where('status_user', '1')->count();
        $count_log_accept = Log::where('log_status', '0')->count();
        $count_log_reject = Log::where('log_status', '1')->count();

        return view('mazer_template.admin.home.home', compact('count_office', 'count_card', 'count_mcu', 'count_user_active', 'count_user_no_active', 'count_log_accept', 'count_log_reject'));
    }

    public function dataTableTotalCardMcu(Request $request) {
        $columns = array( 
                            0 =>'office_id',
                            1 =>'office_name',
                            2 =>'total_card',
                            3 =>'total_mcu',
                        );

        $totalData = TotalCardMcu::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $TotalCardMcus = TotalCardMcu::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

        $data = array();
        if(!empty($TotalCardMcus))
        {
            foreach ($TotalCardMcus as $TotalCardMcu)
            {
                if ($TotalCardMcu->total_card == 0) {
                    $TotalCardMcu->total_card = "<span class='badge bg-secondary mb-2' style='border-radius: 12px;'>$TotalCardMcu->total_card</span>";
                } else if ($TotalCardMcu->total_card > 0) {
                    $TotalCardMcu->total_card = "<span class='badge mb-2' style='border-radius: 12px; background-color: #5733FF; color: white;'>$TotalCardMcu->total_card</span>";
                }

                if ($TotalCardMcu->total_mcu == 0) {
                    $TotalCardMcu->total_mcu = "<span class='badge bg-secondary mb-2' style='border-radius: 12px;'>$TotalCardMcu->total_mcu</span>";
                } else if ($TotalCardMcu->total_mcu > 0) {
                    $TotalCardMcu->total_mcu = "<span class='badge mb-2' style='border-radius: 12px; background-color: #5733FF; color: white;'>$TotalCardMcu->total_mcu</span>";
                }

                $nestedData['office_name'] = $TotalCardMcu->office_name;
                $nestedData['total_card'] = $TotalCardMcu->total_card;
                $nestedData['total_mcu'] = $TotalCardMcu->total_mcu;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return response()->json($json_data);
    }

}