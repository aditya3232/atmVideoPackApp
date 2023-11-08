<?php

namespace App\Http\Controllers;

use App\Models\TbHumanDetection;
use App\Models\TbTid;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class HumanDetectionController extends Controller
{
    //index
    public function index(Request $request)
    {
        $client = new Client();

        // format $request->start_date_time from this '2023-10-23T21:34' to this '2023-10-23 21:34:00'
        $start_date_time = $request->start_date_time;
        $end_date_time = $request->end_date_time;

        if ($start_date_time !== null) {
            $formattedStartDateTime = SupportCarbon::createFromFormat('Y-m-d\TH:i', $start_date_time)->format('Y-m-d H:i:s');
        } else {
            $formattedStartDateTime = null;
        }

        if ($end_date_time !== null) {
            $formattedEndDateTime = SupportCarbon::createFromFormat('Y-m-d\TH:i', $end_date_time)->format('Y-m-d H:i:s');
        } else {
            $formattedEndDateTime = null;
        }

        try {
            
            // api elastic
            $response = $client->request('POST', env('API_HUMAN_DETECTION_URL'), [
                    'headers' => [
                    'x-api-key' => 'YAHYAAJA',
                    ],
                    'form_params' => [
                        'id' => $request->id,
                        'tid' => $request->tid,
                        'date_time' => $request->date_time,
                        'start_date' => $formattedStartDateTime,
                        'end_date' => $formattedEndDateTime,
                        'person' => $request->person,
                        'file_name_capture_human_detection' => $request->file_name_capture_human_detection,
                    ],
                ]);
                
            $human_detection_elastic_data = json_decode($response->getBody())->data;

            // get total data in elastic for loop, count total data in $human_detection_elastic_data
            $total_data = count($human_detection_elastic_data);
            
            // get all tid_id in elastic and send to human_detection with loop
            $human_detection = [];
            foreach ($human_detection_elastic_data as $human_detection_elastic) {
                $tid = $human_detection_elastic->tid;
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
                    'date_time' => $human_detection_elastic->date_time,
                    'person' => $human_detection_elastic->person,
                    'file_name_capture_human_detection' => $human_detection_elastic->file_name_capture_human_detection,
                    'img_url' =>  env('MINIO_HUMAN_DETECTION_URL') . $human_detection_elastic->file_name_capture_human_detection

                ];

                $human_detection[] = $combined_data;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            Alert::error('QueryException !');
            return redirect()->route('admin.index');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Modul Not Found Exception !');
            return redirect()->route('admin.index');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            Alert::error('Data not found !');
            return redirect()->route('admin.index');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            Alert::error('PDO Exception !');
            return redirect()->route('admin.index');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            Alert::error('Throwable !');
            return redirect()->route('admin.index');
            
        }

        // get request
        $tid = null; // Inisialisasi variabel $tid dengan nilai default null
        if ($request->has('tid')) {
            $tid = $request->tid;
        }

        $person = null;
        if ($request->has('person')) {
            if ($request->person == 0) {
                $person = "Person";
            } else {
                $person = "Not Person";
            }
        }

        return view('mazer_template.admin.form_human_detection.index', [
            'human_detection' => $human_detection,
            'tid' => $tid,
            'start_date_time' => $formattedStartDateTime,
            'end_date_time' => $formattedEndDateTime,
            'person' => $person,
        ]);
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_human_detection.file_name_capture_human_detection',
                            1 =>'tid.tid',
                            2 =>'regional_office.regional_office_name',
                            3 =>'kc_supervisi.kc_supervisi_name',
                            4 =>'branch.branch_name',
                            5 =>'tb_human_detection.person',
                            6 =>'tb_human_detection.date_time',
                            7 =>'tb_human_detection.id', //action

                        );

        $totalData = TbHumanDetection::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
                        
            $FormTbHumanDetections = TbHumanDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_human_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_human_detection.file_name_capture_human_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_human_detection.person',
                            'tb_human_detection.date_time',
                            'tb_human_detection.id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $FormTbHumanDetections = TbHumanDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_human_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_human_detection.file_name_capture_human_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_human_detection.person',
                            'tb_human_detection.date_time',
                            'tb_human_detection.id')
                            ->where('tb_human_detection.file_name_capture_human_detection','LIKE',"%{$search}%")
                            ->orWhere('tid.tid','LIKE',"%{$search}%")
                            ->orWhere('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_human_detection.person','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbHumanDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_human_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_human_detection.file_name_capture_human_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_human_detection.person',
                            'tb_human_detection.date_time',
                            'tb_human_detection.id')
                            ->where('tb_human_detection.file_name_capture_human_detection','LIKE',"%{$search}%")
                            ->orWhere('tid.tid','LIKE',"%{$search}%")
                            ->orWhere('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_human_detection.person','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbHumanDetections))
        {
            foreach ($FormTbHumanDetections as $FormTbHumanDetection)
            {
                $edit =  route('admin.humandetection.edit',$FormTbHumanDetection->id);


                $TbHumanDetectionId = $FormTbHumanDetection->id;
                $Tid = $FormTbHumanDetection->tid;

                // is person
                if ($FormTbHumanDetection->person == 0) {
                    $FormTbHumanDetection->person = "<span class='badge bg-success mb-2' style='border-radius: 15px;'>Person</span>";
                } else {
                    $FormTbHumanDetection->person = "<span class='badge bg-danger mb-2' style='border-radius: 15px;'>Not Person</span>";
                }

                // img
                $fileName = $FormTbHumanDetection->file_name_capture_human_detection;
                $imageUrl = "http://127.0.0.1:9000/atmvideopack-app/human-detection/{$fileName}";

                $nestedData['id'] = $FormTbHumanDetection->id;
                $nestedData['file_name_capture_human_detection'] = "<img src='{$imageUrl}' alt='{$fileName}' width='100' height='100'>";
                $nestedData['tid'] = $FormTbHumanDetection->tid;
                $nestedData['regional_office_name'] = $FormTbHumanDetection->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbHumanDetection->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbHumanDetection->branch_name;
                $nestedData['person'] = $FormTbHumanDetection->person;
                $nestedData['date_time'] = $FormTbHumanDetection->date_time;
                $nestedData['options'] = "
                <a href='{$imageUrl}' title='Download Image' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-download'></i></a>
                <a data-tb-tid-id='$TbHumanDetectionId' data-tid='$Tid' title='Show Detail Image' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalShowDetailImageHumanDetection' style='border-radius:12px; background-color:#56B000; color:white;'><i class='bi bi-eye'></i></a>
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

    public function select2Tid(Request $request) {
        $search = $request->search;

        if($search) {
            $tids = TbTid::select('id', 'tid')
                            ->where('tid', 'LIKE', "%{$search}%")
                            ->limit(100)
                            ->get();
        } else {
            $tids = TbTid::select('id', 'tid')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($tids as $tid){
                $response[] = array(
                    "id"=> $tid->tid, // pake tid untuk search datanya
                    "text"=> $tid->tid
                );
            }

        return response()->json($response);
    }

}