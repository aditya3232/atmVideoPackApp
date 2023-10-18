<?php

namespace App\Http\Controllers;

use App\Models\TbRegionalOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

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

    public function create() {
        return view('mazer_template.admin.form_regional_office.create');
    }

    public function store(Request $request) {
        $messages = [
        'required' => ':attribute wajib diisi.',
        'min' => ':attribute harus diisi minimal :min karakter.',
        'max' => ':attribute harus diisi maksimal :max karakter.',
        'size' => ':attribute harus diisi tepat :size karakter.',
        'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'regional_office_name' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('regional_office_name') != null) {
            $validator = Validator::make($request->all(),[
                'regional_office_name' => 'required|unique:tb_regional_office,regional_office_name',
            ],$messages);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.regionaloffice.create')->withErrors($validator->errors())->withInput();
        }

        try {
        DB::beginTransaction();

        DB::table('tb_regional_office')->insert([
            'regional_office_name' => $request->input('regional_office_name'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');
        
    }

        Alert::success('Sukses', 'Regional office berhasil ditambahkan.');
        return redirect()->route('admin.regionaloffice.index');
    }
}
