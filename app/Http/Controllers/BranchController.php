<?php

namespace App\Http\Controllers;

use App\Models\TbBranch;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_branch.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'branch_name',
                            1 =>'branch_code',
                            2 =>'created_at',
                            3 =>'id', //action
                        );

        $totalData = TbBranch::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbBranchs = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbBranchs = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                            ->where('branch_name','LIKE',"%{$search}%")
                            ->orWhere('branch_code', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                            ->where('branch_name','LIKE',"%{$search}%")
                            ->orWhere('branch_code', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbBranchs))
        {
            foreach ($FormTbBranchs as $FormTbBranch)
            {
                $edit =  route('admin.branch.edit',$FormTbBranch->id);


                $tbBranchId = $FormTbBranch->id;
                $branchName = $FormTbBranch->branch_name;

                $nestedData['id'] = $FormTbBranch->id;
                $nestedData['branch_name'] = $FormTbBranch->branch_name;
                $nestedData['branch_code'] = $FormTbBranch->branch_code;
                $nestedData['created_at'] = $FormTbBranch->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$tbBranchId' data-branch-name='$branchName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteBranch' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
