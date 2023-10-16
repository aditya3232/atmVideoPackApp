<?php

namespace App\Http\Controllers;

use App\Models\TbHumanDetection;

use Illuminate\Http\Request;

class HumanDetectionController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_human_detection.index');
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

        $limit = $request->input('length');
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
}
