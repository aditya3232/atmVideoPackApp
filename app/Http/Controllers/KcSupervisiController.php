<?php

namespace App\Http\Controllers;


use App\Models\TbKcSupervisi;

use Illuminate\Http\Request;

class KcSupervisiController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_kc_supervisi.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'kc_supervisi_name',
                            1 =>'created_at',
                            2 =>'id', //action
                        );

        $totalData = TbKcSupervisi::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbKcSupervisis = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbKcSupervisis = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                            ->where('kc_supervisi_name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                            ->where('kc_supervisi_name','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbKcSupervisis))
        {
            foreach ($FormTbKcSupervisis as $FormTbKcSupervisi)
            {
                $edit =  route('admin.branch.edit',$FormTbKcSupervisi->id);


                $TbKcSupervisiId = $FormTbKcSupervisi->id;
                $kcSupervisiName = $FormTbKcSupervisi->kc_supervisi_name;

                $nestedData['id'] = $FormTbKcSupervisi->id;
                $nestedData['kc_supervisi_name'] = $FormTbKcSupervisi->kc_supervisi_name;
                $nestedData['created_at'] = $FormTbKcSupervisi->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$TbKcSupervisiId' data-branch-name='$kcSupervisiName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteKcSupervisi' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
