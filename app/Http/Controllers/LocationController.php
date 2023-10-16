<?php

namespace App\Http\Controllers;

use App\Models\TbLocation;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_location.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'regional_office.regional_office_name',
                            1 =>'kc_supervisi.kc_supervisi_name',
                            2 =>'branch.branch_name',
                            3 =>'tb_location.address',
                            4 =>'tb_location.postal_code',
                            5 =>'tb_location.created_at',
                            6 =>'tb_location.id', //action
                        );

        $totalData = TbLocation::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbLocations = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'tb_location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'tb_location.branch_id')
                        ->select('regional_office.regional_office_name',
                                                 'kc_supervisi.kc_supervisi_name',
                                                 'branch.branch_name',
                                                 'tb_location.address',
                                                 'tb_location.postal_code',
                                                 'tb_location.created_at',
                                                 'tb_location.id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbLocations = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
                            ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'tb_location.kc_supervisi_id')
                            ->join('tb_branch as branch', 'branch.id', '=', 'tb_location.branch_id')
                            ->select('regional_office.regional_office_name',
                                                 'kc_supervisi.kc_supervisi_name',
                                                 'branch.branch_name',
                                                 'tb_location.address',
                                                 'tb_location.postal_code',
                                                 'tb_location.created_at',
                                                 'tb_location.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_location.address','LIKE',"%{$search}%")
                            ->orWhere('tb_location.postal_code','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
                            ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'tb_location.kc_supervisi_id')
                            ->join('tb_branch as branch', 'branch.id', '=', 'tb_location.branch_id')
                            ->select('regional_office.regional_office_name',
                                                 'kc_supervisi.kc_supervisi_name',
                                                 'branch.branch_name',
                                                 'tb_location.address',
                                                 'tb_location.postal_code',
                                                 'tb_location.created_at',
                                                 'tb_location.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_location.address','LIKE',"%{$search}%")
                            ->orWhere('tb_location.postal_code','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbLocations))
        {
            foreach ($FormTbLocations as $FormTbLocation)
            {
                $edit =  route('admin.branch.edit',$FormTbLocation->id);


                $TbLocationId = $FormTbLocation->id;
                $BranchName = $FormTbLocation->branch_name;

                $nestedData['id'] = $FormTbLocation->id;
                $nestedData['regional_office_name'] = $FormTbLocation->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbLocation->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbLocation->branch_name;
                $nestedData['address'] = $FormTbLocation->address;
                $nestedData['postal_code'] = $FormTbLocation->postal_code;
                $nestedData['created_at'] = $FormTbLocation->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$TbLocationId' data-branch-name='$BranchName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteKcSupervisi' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
