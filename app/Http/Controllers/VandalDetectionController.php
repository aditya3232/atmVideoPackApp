<?php

namespace App\Http\Controllers;

use App\Models\TbVandalDetection;

use Illuminate\Http\Request;

class VandalDetectionController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_vandal_detection.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_vandal_detection.file_name_capture_vandal_detection',
                            1 =>'tid.tid',
                            2 =>'regional_office.regional_office_name',
                            3 =>'kc_supervisi.kc_supervisi_name',
                            4 =>'branch.branch_name',
                            5 =>'tb_vandal_detection.person',
                            6 =>'tb_vandal_detection.date_time',
                            7 =>'tb_vandal_detection.id', //action

                        );

        $totalData = TbVandalDetection::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbVandalDetections = TbVandalDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_vandal_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_vandal_detection.file_name_capture_vandal_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_vandal_detection.person',
                            'tb_vandal_detection.date_time',
                            'tb_vandal_detection.id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $FormTbVandalDetections = TbVandalDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_vandal_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_vandal_detection.file_name_capture_vandal_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_vandal_detection.person',
                            'tb_vandal_detection.date_time',
                            'tb_vandal_detection.id')
                            ->where('tb_vandal_detection.file_name_capture_vandal_detection','LIKE',"%{$search}%")
                            ->orWhere('tid.tid','LIKE',"%{$search}%")
                            ->orWhere('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_vandal_detection.person','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbVandalDetection::join('tb_tid as tid', 'tid.id', '=', 'tb_vandal_detection.tid_id')
                        ->join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_vandal_detection.file_name_capture_vandal_detection',
                            'tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_vandal_detection.person',
                            'tb_vandal_detection.date_time',
                            'tb_vandal_detection.id')
                            ->where('tb_vandal_detection.file_name_capture_vandal_detection','LIKE',"%{$search}%")
                            ->orWhere('tid.tid','LIKE',"%{$search}%")
                            ->orWhere('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_vandal_detection.person','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbVandalDetections))
        {
            foreach ($FormTbVandalDetections as $FormTbVandalDetection)
            {
                $edit =  route('admin.vandaldetection.edit',$FormTbVandalDetection->id);


                $TbVandalDetectionId = $FormTbVandalDetection->id;
                $Tid = $FormTbVandalDetection->tid;

                // is person
                if ($FormTbVandalDetection->person == 0) {
                    $FormTbVandalDetection->person = "<span class='badge bg-success mb-2' style='border-radius: 15px;'>Person</span>";
                } else {
                    $FormTbVandalDetection->person = "<span class='badge bg-danger mb-2' style='border-radius: 15px;'>Not Person</span>";
                }

                // img
                $fileName = $FormTbVandalDetection->file_name_capture_vandal_detection;
                $imageUrl = "http://127.0.0.1:9000/atmvideopack-app/vandal-detection/{$fileName}";

                $nestedData['id'] = $FormTbVandalDetection->id;
                $nestedData['file_name_capture_vandal_detection'] = "<img src='{$imageUrl}' alt='{$fileName}' width='100' height='100'>";
                $nestedData['tid'] = $FormTbVandalDetection->tid;
                $nestedData['regional_office_name'] = $FormTbVandalDetection->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbVandalDetection->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbVandalDetection->branch_name;
                $nestedData['person'] = $FormTbVandalDetection->person;
                $nestedData['date_time'] = $FormTbVandalDetection->date_time;
                $nestedData['options'] = "
                <a href='{$imageUrl}' title='Download Image' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-download'></i></a>
                <a data-tb-tid-id='$TbVandalDetectionId' data-tid='$Tid' title='Show Detail Image' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalShowDetailImageHumanDetection' style='border-radius:12px; background-color:#56B000; color:white;'><i class='bi bi-eye'></i></a>
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
