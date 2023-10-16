<?php

namespace App\Http\Controllers;

use App\Models\TbRegionalOffice;

use Illuminate\Http\Request;

class RegionalOfficeController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_regional_office.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'regional_office_name',
                            1 =>'created_at',
                            2 =>'id', //action
                        );

        $totalData = TbRegionalOffice::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbRegionalOffices = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbRegionalOffices = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                            ->where('regional_office_name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                            ->where('regional_office_name','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbRegionalOffices))
        {
            foreach ($FormTbRegionalOffices as $FormTbRegionalOffice)
            {
                $edit =  route('admin.branch.edit',$FormTbRegionalOffice->id);


                $TbRegionalOfficeId = $FormTbRegionalOffice->id;
                $regionalOfficeName = $FormTbRegionalOffice->regional_office_name;

                $nestedData['id'] = $FormTbRegionalOffice->id;
                $nestedData['regional_office_name'] = $FormTbRegionalOffice->regional_office_name;
                $nestedData['created_at'] = $FormTbRegionalOffice->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$TbRegionalOfficeId' data-branch-name='$regionalOfficeName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteRegionalOffice' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
