<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;

class RoleController extends Controller
{
    public function index() {
        $title = 'Hapus Role!';
        $text = "Apakah anda yakin hapus role?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.roles.index');
    }

    public function dataTable(Request $request) {
        $columns = array( 
                            0 =>'name',
                            1 => 'id', //action
                        );
        if (Auth::user()->id == 1) {
            $totalData = Role::whereNotIn('name', ['admin'])->count();
        } else {
            $totalData = Role::whereNotIn('name', ['admin','Fresh','admin gatewatch apps'])->count();
        }

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {   
            if (Auth::user()->id == 1) {
                $Roles = Role::whereNotIn('name', ['admin'])
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();
                
            } else {
                $Roles = Role::whereNotIn('name', ['admin','Fresh','admin gatewatch apps'])
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();
            }    
        }
        else {
            $search = $request->input('search.value'); 

            if (Auth::user()->id == 1) {
                $Roles =  Role::where('id','LIKE',"%{$search}%")
                                ->orWhere('name', 'LIKE',"%{$search}%")
                                ->whereNotIn('name', ['admin'])
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

            } else {
                $Roles =  Role::where('id','LIKE',"%{$search}%")
                                ->orWhere('name', 'LIKE',"%{$search}%")
                                ->whereNotIn('name', ['admin','Fresh','admin gatewatch apps'])
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
            }

            if (Auth::user()->id == 1) {
                $totalFiltered = Role::where('id','LIKE',"%{$search}%")
                                 ->orWhere('name', 'LIKE',"%{$search}%")
                                 ->whereNotIn('name', ['admin'])
                                 ->count();
            } else {
                $totalFiltered = Role::where('id','LIKE',"%{$search}%")
                                 ->orWhere('name', 'LIKE',"%{$search}%")
                                 ->whereNotIn('name', ['admin','Fresh','admin gatewatch apps'])
                                 ->count();
            }
        }

        $data = array();
        if(!empty($Roles))
        {
            foreach ($Roles as $Role)
            {
                $edit =  route('admin.roles.edit',$Role->id);

                $rolesId = $Role->id;
                $roleName = $Role->name;

                $nestedData['id'] = $Role->id;
                $nestedData['name'] = $Role->name;
                $nestedData['options'] = "
                <a href='{$edit}' title='ADD PERMISSIONS' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <button type='button' class='btn btn-sm mt-2' id='delete-role' style='border-radius:12px; background-color:#FF0000; color:white;' data-rolename='{$roleName}' data-tb-role-id='{$rolesId}'><i class='bi bi-trash'></i></button>
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
        return view('mazer_template.admin.roles.create');
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
            'name' => 'required|unique:roles,name',
        ],$messages);

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.roles.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Role::insert([
            'name' => $request->input('name'),
        ]);

        // Alert::success('Sukses', 'Tambah role berhasil');
        // return redirect()->route('admin.roles.index');

        return response()->json(['message' => 'Role berhasil ditambahkan']);
    }

    public function select2Permissions(Request $request, $id) {
        $search = $request->search;
        
        if($search) {
            // biar yang udah dipilih tidak ditampilkan lagi di select2
            // SELECT 
            //     p.id,
            //     p.name
            // from permissions p 
            // where p.id not in (select p.id from permissions p
            //                 join permission_role pr on pr.permission_id = p.id
            //                 where pr.role_id = 7)

            if (Auth::user()->id == 1) {
                $Permissions = Permission::select('permissions.id', 'permissions.name')
                                            ->whereNotIn('permissions.id', function ($query) use ($id) {
                                                $query->select('p.id')
                                                    ->from('permissions as p')
                                                    ->join('permission_role as pr', 'pr.permission_id', '=', 'p.id')
                                                    ->where('pr.role_id', $id);
                                            })
                                            ->where('permissions.name', 'LIKE',"%{$search}%")
                                            ->limit(100)
                                            ->get();
            } else {
                $Permissions = Permission::select('permissions.id', 'permissions.name')
                                            ->whereNotIn('permissions.id', function ($query) use ($id) {
                                                $query->select('p.id')
                                                    ->from('permissions as p')
                                                    ->join('permission_role as pr', 'pr.permission_id', '=', 'p.id')
                                                    ->where('pr.role_id', $id);
                                            })
                                            ->whereNotIn('name', ['sidebar permissions'])
                                            ->where('permissions.name', 'LIKE',"%{$search}%")
                                            ->limit(100)
                                            ->get();
            }
        } else {

            if (Auth::user()->id == 1) {
                $Permissions = Permission::select('permissions.id', 'permissions.name')
                                            ->whereNotIn('permissions.id', function ($query) use ($id) {
                                                $query->select('p.id')
                                                    ->from('permissions as p')
                                                    ->join('permission_role as pr', 'pr.permission_id', '=', 'p.id')
                                                    ->where('pr.role_id', $id);
                                            })
                                            ->limit(100)
                                            ->get();
            } else {
                $Permissions = Permission::select('permissions.id', 'permissions.name')
                                            ->whereNotIn('permissions.id', function ($query) use ($id) {
                                                $query->select('p.id')
                                                    ->from('permissions as p')
                                                    ->join('permission_role as pr', 'pr.permission_id', '=', 'p.id')
                                                    ->where('pr.role_id', $id);
                                            })
                                            ->whereNotIn('name', ['sidebar permissions'])
                                            ->limit(100)
                                            ->get();
            }
        }

        $response = array();
            foreach($Permissions as $Permission){
                $response[] = array(
                    "id"=>$Permission->id,
                    "text"=>$Permission->name
                );
            }

        return response()->json($response);
    }

    public function edit($id) {
        $role = Role::findOrFail($id);

        return view('mazer_template.admin.roles.edit', compact('role'));
    }

    public function assignPermissions(Request $request, $id) {
        $role = Role::findOrFail($id);
        // $role->permissions()->sync($request->permissions);

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            PermissionRole::insert([
                'role_id' => $id,
                'permission_id' => $permission,
            ]);
        }
        
        Alert::success('Sukses', 'Permission telah ditambahkan');
        return back();
    }

    public function deletePermissions($role_id, $permission_id) {
         PermissionRole::where('role_id', $role_id)
                  ->where('permission_id', $permission_id)
                  ->delete();

        Alert::success('Sukses', 'Permission telah dihapus');
        return back();
    }

    public function update(Request $request, $id) {
        $Role = Role::findOrFail($id);

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
        if($request->input('name') != $Role->name) {
            // Check if the 'name' values is unique
            $validator = Validator::make($request->all(),[
                'name' => 'unique:roles,name',
            ],$messages);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.roles.edit',$id)->withErrors($validator->errors())->withInput();
        }

        $upadted_at= date("Y-m-d H:i:s");
        Role::where('id',$id)
            ->update([
                'name'=>$request->input('name'),
                'updated_at'=>$upadted_at,
            ]);

        Alert::success('Sukses', 'Update role berhasil');
        return redirect()->route('admin.roles.index');
    }

    public function destroy($id) {
        $ids = $id;
        $role = Role::findOrFail($id);

        $role->delete();

        Alert::success('Sukses', 'Role berhasil dihapus');
        return redirect()->route('admin.roles.index');
    }
    
    
}