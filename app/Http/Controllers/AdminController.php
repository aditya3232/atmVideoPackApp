<?php

namespace App\Http\Controllers;

use App\Models\TbTid;
use App\Models\TbStatusMc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function index() {
        $client = new Client();
        
        // api elastic
        $response = $client->request('POST', env('API_STATUS_MC_DETECTION_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
                'form_params' => [
                    // 'tid_id' => $id,
                ],
            ]);
            
        $status_mc_detection_elastic_data = json_decode($response->getBody())->data;


        // get all tid_id in elastic and send to human_detection with loop
        $status_mc_detection = [];
        foreach ($status_mc_detection_elastic_data as $status_mc_detection_elastic) {
            $tid_id = $status_mc_detection_elastic->tid_id;
            $tid_data = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                ->select('tb_tid.tid',
                    'regional_office.regional_office_name',
                    'kc_supervisi.kc_supervisi_name',
                    'branch.branch_name')
                ->where('tb_tid.id', '=', $tid_id)
                ->first(); // Use first() to get a single result

            $combined_data = [
                'tid' => $tid_data->tid,
                'tid_id' => $tid_id,
                'regional_office_name' => $tid_data->regional_office_name,
                'kc_supervisi_name' => $tid_data->kc_supervisi_name,
                'branch_name' => $tid_data->branch_name,

                'date_time' => $status_mc_detection_elastic->date_time,
                'status_signal' => $status_mc_detection_elastic->status_signal,
                'status_storage' => $status_mc_detection_elastic->status_storage,
                'status_ram' => $status_mc_detection_elastic->status_ram,
                'status_cpu' => $status_mc_detection_elastic->status_cpu,
            ];

            $status_mc_detection[] = $combined_data;
        }

        // dd($status_mc_detection);

         return view('mazer_template.admin.home.home');

        // return view('mazer_template.admin.home.home', [
        //     'status_mc_detection' => $status_mc_detection,
        // ]);
    }


}