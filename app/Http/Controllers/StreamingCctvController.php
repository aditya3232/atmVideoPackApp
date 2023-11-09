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

class StreamingCctvController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_streaming_cctv.index');
    }

    public function streamingCctv($tid) {
        $client = new Client();

        try {
            
            // api elastic
            $response = $client->request('POST', env('API_STATUS_MC_DETECTION_URL'), [
                    'headers' => [
                    'x-api-key' => 'YAHYAAJA',
                    ],
                    'form_params' => [
                        'tid' => $tid,
                    ],
                ]);
                
            $status_mc_detection_elastic_data = json_decode($response->getBody())->data;

            // get all tid_id in elastic and send to human_detection with loop
            $status_mc_detection = [];
            foreach ($status_mc_detection_elastic_data as $status_mc_detection_elastic) {
                $tid = $status_mc_detection_elastic->tid;
                $tid_data = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                    ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                    ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                    ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                    ->select('tb_tid.tid',
                        'regional_office.regional_office_name',
                        'kc_supervisi.kc_supervisi_name',
                        'branch.branch_name')
                    ->where('tb_tid.tid', '=', $tid)
                    ->first(); // Use first() to get a single result

                $combined_data = [
                    'tid' => $tid_data->tid,
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

            // streaming cctv with client guzzle from here  http://127.0.0.1:3636/api/atmvideopack/v1/stream/cctv/160001
            $url = env('STREAMING_CCTV_URL') . $tid;

            return view('mazer_template.admin.form_streaming_cctv.streaming', [
                'status_mc_detection' => $status_mc_detection,
                'streaming_cctv_data' => $url,
            ]);
            

        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            Alert::error('QueryException !');
            return redirect()->route('admin.streamingcctv.index');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Modul Not Found Exception !');
            return redirect()->route('admin.streamingcctv.index');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            Alert::error('Data not found !');
            return redirect()->route('admin.streamingcctv.index');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            Alert::error('PDO Exception !');
            return redirect()->route('admin.streamingcctv.index');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            Alert::error('Throwable !');
            return redirect()->route('admin.streamingcctv.index');
        }

    }



    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_tid.tid',
                            1 =>'regional_office.regional_office_name',
                            2 =>'kc_supervisi.kc_supervisi_name',
                            3 =>'branch.branch_name',
                            4 =>'tb_tid.tid', //action
                        );

        $totalData = TbTid::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbTids = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $FormTbTids = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbTids))
        {
            foreach ($FormTbTids as $FormTbTid)
            {
                $edit =  route('admin.streamingcctv.streaming',$FormTbTid->tid);


                $Tid = $FormTbTid->tid;

                $nestedData['tid'] = $FormTbTid->tid;
                $nestedData['regional_office_name'] = $FormTbTid->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbTid->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbTid->branch_name;
                $nestedData['options'] = "
                <a href='{$edit}'  target='_blank' title='Streaming' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-pip-fill'></i></a>
                ";
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