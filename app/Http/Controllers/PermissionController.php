<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;

class PermissionController extends Controller
{
    public function index() {
        $title = 'Hapus Permission!';
        $text = "Apakah anda yakin hapus permission?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.permissions.index');
    }

    public function dataTable(Request $request) {
        $columns = array( 
                            0 =>'name',
                            1 => 'id', //action
                        );

        $totalData = Permission::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $Permissions = Permission::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $Permissions =  Permission::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Permission::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($Permissions))
        {
            foreach ($Permissions as $Permission)
            {
                $edit =  route('admin.permissions.edit',$Permission->id);

                $permissionId = $Permission->id;
                $permissionName = $Permission->name;

                $nestedData['id'] = $Permission->id;
                $nestedData['name'] = $Permission->name;
                $nestedData['options'] = "
                <a href='{$edit}' title='EDIT' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <button type='button' class='btn btn-sm mt-2' id='delete-permission-data' style='border-radius:12px; background-color:#FF0000; color:white;' data-permission-name='{$permissionName}' data-tb-permission-id='{$permissionId}'><i class='bi bi-trash'></i></button>
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
        return view('mazer_template.admin.permissions.create');
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
            'name' => 'required|unique:permissions,name',
        ],$messages);

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.permissions.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }


        Permission::insert([
            'name' => $request->input('name'),
        ]);

        // Alert::success('Sukses', 'Tambah permission berhasil');
        // return redirect()->route('admin.permissions.index');

        return response()->json(['message' => 'Permission berhasil ditambahkan']);
    }

    public function edit($id) {
        $permission = Permission::findOrFail($id);

        return view('mazer_template.admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id) {
        $Permission = Permission::findOrFail($id);

        $messages = [
        'required' => ':attribute wajib diisi.',
        'min' => ':attribute harus diisi minimal :min karakter.',
        'max' => ':attribute harus diisi maksimal :max karakter.',
        'size' => ':attribute harus diisi tepat :size karakter.',
        'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ],$messages);

        // Check if the 'name' values have changed
        if ($request->input('name') !== $Permission->name) {
            $validator->addRules(['name' => 'required|unique:permissions,name']);
        }

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.permissions.edit',$id)->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $upadted_at= date("Y-m-d H:i:s");
        Permission::where('id',$id)
            ->update([
                'name'=>$request->input('name'),
                'updated_at'=>$upadted_at,
            ]);

        // Alert::success('Sukses', 'Update permission berhasil');
        // return redirect()->route('admin.permissions.index');

        return response()->json(['message' => 'Permission berhasil diupdate']);
    }

    public function destroy($id) {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        // Alert::success('Sukses', 'Permission berhasil dihapus');
        // return redirect()->route('admin.permissions.index');

        return response()->json(['message' => 'Permission berhasil dihapus']);
    }


}