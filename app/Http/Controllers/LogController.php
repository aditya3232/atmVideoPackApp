<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function indexAccepted() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_log.index_accepted');
    }

    public function indexRejected() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_log.index_rejected');
    }

    public function dataTableAccepted(Request $request) {
        $columns = array(
                            0 => 'id',
                            1 => 'username_card',
                            2 => 'no_card',
                            3 => 'door_token',
                            4 => 'office_name',
                            5 => 'log_status',
                            6 => 'created_at',
                        );

        $totalData = Log::whereBetween('created_at', [now()->subMonth(2), now()])->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $usernameCard = $request->input('username_card');
        $noCard = $request->input('no_card');
        $doorToken = $request->input('door_token');
        $officeName = $request->input('office_name');
        $logStatus = $request->input('log_status');
        $startDateTime = $request->input('start_date_time');
        $endDateTime = $request->input('end_date_time');

        $Logs = DB::table('tb_log')
                ->leftJoin('tb_user_mcu', 'tb_log.tb_user_mcu_id', '=', 'tb_user_mcu.id')
                ->leftJoin('tb_entry', 'tb_log.tb_entry_id', '=', 'tb_entry.id')
                ->leftJoin('tb_office', 'tb_log.tb_office_id', '=', 'tb_office.id')
                ->leftJoin('tb_mcu', 'tb_log.tb_mcu_id', '=', 'tb_mcu.id')
                ->select('tb_log.id', 'tb_user_mcu.username_card', 'tb_entry.no_card', 'tb_mcu.door_token', 'tb_office.office_name', 'tb_log.log_status', 'tb_log.created_at')
                ->where(function ($query) use ($usernameCard, $noCard, $doorToken, $officeName, $logStatus) {
                    if (!empty($usernameCard)) {
                        $query->where('tb_user_mcu.username_card', '=', $usernameCard);
                    }

                    if (!empty($noCard)) {
                        $query->where('tb_entry.no_card', '=', $noCard);
                    }

                    if (!empty($doorToken)) {
                        $query->where('tb_mcu.door_token', '=', $doorToken);
                    }

                    if (!empty($officeName)) {
                        $query->where('tb_office.office_name', '=', $officeName);
                    }

                    if (!empty($logStatus)) {
                        $query->where('log_status', '=', $logStatus);
                    }
                })
                // if startDateTime and endDateTime is not null then whereBetween
                ->when($startDateTime && $endDateTime, function ($query) use ($startDateTime, $endDateTime) {
                    return $query->whereBetween('tb_log.created_at', [$startDateTime, $endDateTime]);
                })
                // where created_at 2 last month from now
                ->when(!$startDateTime && !$endDateTime, function ($query) {
                    return $query->whereBetween('tb_log.created_at', [now()->subMonth(2), now()]);
                })

                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        $totalFiltered = DB::table('tb_log')
                    ->leftJoin('tb_user_mcu', 'tb_log.tb_user_mcu_id', '=', 'tb_user_mcu.id')
                    ->leftJoin('tb_entry', 'tb_log.tb_entry_id', '=', 'tb_entry.id')
                    ->leftJoin('tb_office', 'tb_log.tb_office_id', '=', 'tb_office.id')
                    ->leftJoin('tb_mcu', 'tb_log.tb_mcu_id', '=', 'tb_mcu.id')
                    ->select('tb_log.id', 'tb_user_mcu.username_card', 'tb_entry.no_card', 'tb_mcu.door_token', 'tb_office.office_name', 'tb_log.log_status', 'tb_log.created_at')
                    ->where(function ($query) use ($usernameCard, $noCard, $doorToken, $officeName, $logStatus) {
                        if (!empty($usernameCard)) {
                            $query->where('tb_user_mcu.username_card', '=', $usernameCard);
                        }

                        if (!empty($noCard)) {
                            $query->where('tb_entry.no_card', '=', $noCard);
                        }

                        if (!empty($doorToken)) {
                            $query->where('tb_mcu.door_token', '=', $doorToken);
                        }

                        if (!empty($officeName)) {
                            $query->where('tb_office.office_name', '=', $officeName);
                        }

                        if (!empty($logStatus)) {
                            $query->where('log_status', '=', $logStatus);
                        }
                    })
                    ->when($startDateTime && $endDateTime, function ($query) use ($startDateTime, $endDateTime) {
                        return $query->whereBetween('tb_log.created_at', [$startDateTime, $endDateTime]);
                    })
                    ->when(!$startDateTime && !$endDateTime, function ($query) {
                        return $query->whereBetween('tb_log.created_at', [now()->subMonth(2), now()]);
                    })
                    ->count();

        $data = array();
        if(!empty($Logs))
        {
            foreach ($Logs as $Log)
            {
                if ($Log->log_status == 0) {
                    $Log->log_status = "<span class='badge bg-success mb-2' style='border-radius: 15px;'>Accepted</span>";
                } else if ($Log->log_status == 1) {
                    $Log->log_status = "<span class='badge bg-danger mb-2' style='border-radius: 15px;'>Rejected</span>";
                } else if ($Log->log_status == 2) {
                    $Log->log_status = "<span class='badge bg-warning mb-2' style='border-radius: 15px;'>New Card</span>";
                }

                $nestedData['username_card'] = $Log->username_card;
                $nestedData['no_card'] = $Log->no_card;
                $nestedData['door_token'] = $Log->door_token;
                $nestedData['office_name'] = $Log->office_name;
                $nestedData['log_status'] = $Log->log_status;
                $nestedData['created_at'] = $Log->created_at;

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

    // select no_card
    public function select2EntryInLogAccepted(Request $request) {
        $search = $request->search;

        if($search) {
            $Cards = DB::table('tb_entry as a')
                        ->select('a.id', 'a.no_card')
                        ->where('a.no_card', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $Cards = DB::table('tb_entry as a')
                        ->select('a.id', 'a.no_card')
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Cards as $Card){
                $response[] = array(
                    "id"=>$Card->id,
                    "text"=>$Card->no_card
                );
            }

        return response()->json($response);
    }

    // select username_card
    public function select2UsernameMcuInLogAccepted(Request $request) {
        $search = $request->search;

        if($search) {
            $UsernameCards = DB::table('tb_user_mcu as a')
                        ->select('a.id', 'a.username_card')
                        ->where('a.username_card', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $UsernameCards = DB::table('tb_user_mcu as a')
                        ->select('a.id', 'a.username_card')
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($UsernameCards as $UsernameCard){
                $response[] = array(
                    "id"=>$UsernameCard->id,
                    "text"=>$UsernameCard->username_card
                );
            }

        return response()->json($response);
    }

    // select office
    public function select2OfficeInLogAccepted(Request $request) {
        $search = $request->search;

        if($search) {
            $Offices = DB::table('tb_office as a')
                        ->select('a.id', 'a.office_name')
                        ->distinct()
                        ->where('a.office_name', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $Offices = DB::table('tb_office as a')
                        ->select('a.id', 'a.office_name')
                        ->distinct()
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Offices as $Office){
                $response[] = array(
                    "id"=>$Office->id,
                    "text"=>$Office->office_name
                );
            }

        return response()->json($response);
    }

    // select door_token
    public function select2DoorTokenInLogAccepted(Request $request) {
        $search = $request->search;

        if($search) {
            $DoorTokens = DB::table('tb_mcu as a')
                        ->select('a.id', 'a.door_token')
                        ->where('a.door_token', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $DoorTokens = DB::table('tb_mcu as a')
                        ->select('a.id', 'a.door_token')
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($DoorTokens as $DoorToken){
                $response[] = array(
                    "id"=>$DoorToken->id,
                    "text"=>$DoorToken->door_token
                );
            }

        return response()->json($response);
    }




}