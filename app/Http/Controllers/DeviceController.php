<?php

namespace App\Http\Controllers;

use App\Models\TbTid;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_device.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_tid.tid',
                            1 =>'tb_tid.ip_address',
                            2 =>'tb_tid.sn_mini_pc',
                            3 =>'regional_office.regional_office_name',
                            4 =>'kc_supervisi.kc_supervisi_name',
                            5 =>'branch.branch_name',
                            6 =>'tb_tid.created_at',
                            7 =>'tb_tid.id', //action
                        );

        $totalData = TbTid::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
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
                            'tb_tid.ip_address',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
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
                            'tb_tid.ip_address',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.sn_mini_pc','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'tb_tid.ip_address',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.sn_mini_pc','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbTids))
        {
            foreach ($FormTbTids as $FormTbTid)
            {
                $edit =  route('admin.device.edit',$FormTbTid->id);


                $TbTidId = $FormTbTid->id;
                $Tid = $FormTbTid->tid;

                $nestedData['id'] = $FormTbTid->id;
                $nestedData['tid'] = $FormTbTid->tid;
                $nestedData['ip_address'] = $FormTbTid->ip_address;
                $nestedData['sn_mini_pc'] = $FormTbTid->sn_mini_pc;
                $nestedData['regional_office_name'] = $FormTbTid->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbTid->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbTid->branch_name;
                $nestedData['created_at'] = $FormTbTid->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-tid-id='$TbTidId' data-tid='$Tid' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteKcSupervisi' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
