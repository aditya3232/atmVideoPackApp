<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\UserMcu;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDOException;
use Throwable;
use Illuminate\Support\Facades\Validator;

class UserMcuController extends Controller
{
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_user_mcu.index');
    }

    public function dataTable(Request $request) {
        $columns = array( 
                            0 =>'tb_user_mcu.username_card',
                            1 =>'tb_user_mcu.nama_lengkap',
                            2 =>'tb_user_mcu.nik',
                            3 =>'tb_user_mcu.jabatan',
                            4 =>'tb_office.office_name',
                            5 => 'tb_user_mcu.created_at',
                            6 => 'tb_user_mcu.id', //action
                        );

        $totalData = UserMcu::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $UserMcus = UserMcu::join('tb_office', 'tb_user_mcu.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_user_mcu.*', 'tb_office.office_name')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $UserMcus = UserMcu::join('tb_office', 'tb_user_mcu.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_user_mcu.*', 'tb_office.office_name')
                            ->where('tb_user_mcu.username_card', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.nama_lengkap', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.nik', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.jabatan', 'LIKE',"%{$search}%")
                            ->orWhere('tb_office.office_name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = UserMcu::join('tb_office', 'tb_user_mcu.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_user_mcu.*', 'tb_office.office_name')
                            ->where('tb_user_mcu.username_card', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.nama_lengkap', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.nik', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.jabatan', 'LIKE',"%{$search}%")
                            ->orWhere('tb_office.office_name', 'LIKE',"%{$search}%")
                            ->orWhere('tb_user_mcu.created_at', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($UserMcus))
        {
            foreach ($UserMcus as $UserMcu)
            {
                $edit =  route('admin.usermcu.edit',$UserMcu->id);

                $tbUserMcuId = $UserMcu->id;
                $UserNameCard = $UserMcu->username_card;

                $nestedData['username_card'] = $UserMcu->username_card;
                $nestedData['nama_lengkap'] = $UserMcu->nama_lengkap;
                $nestedData['nik'] = $UserMcu->nik;
                $nestedData['jabatan'] = $UserMcu->jabatan;
                $nestedData['office_name'] = $UserMcu->office_name;
                $nestedData['created_at'] = $UserMcu->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='EDIT' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-user-mcu-id='$tbUserMcuId' data-username-card='$UserNameCard' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteUserMcu' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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

    public function select2Office(Request $request) {
        $search = $request->search;
        
        if($search) {
            $Offices = Office::select('id', 'office_name')
                                        ->where('office_name', 'LIKE',"%{$search}%")
                                        ->limit(100)
                                        ->get();
        } else {
            $Offices = Office::select('id', 'office_name')
                                        ->limit(100)
                                        ->get();
        }

        $response = array();
            foreach($Offices as $Office){
                $response[] = array(
                    "id"=>$Office->id,
                    "text"=>$Office->office_name
                );
            }

        return response()->json($response);
    }

    public function create() {
        return view('mazer_template.admin.form_user_mcu.create');
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
            'username_card' => 'required',
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'jabatan' => 'required',
            'tb_office_id' => 'required',
        ],$messages);

        if($request->input('username_card') != null) {
            $validator->addRules(['username_card' => 'required|unique:tb_user_mcu,username_card']);
        }
        if($request->input('nik') != null) {
            $validator->addRules(['nik' => 'required|unique:tb_user_mcu,nik']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.usermcu.create')->withErrors($validator->errors())->withInput();
        }

        try {
        UserMcu::insert([
            'username_card' => $request->input('username_card'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nik' => $request->input('nik'),
            'jabatan' => $request->input('jabatan'),
            'tb_office_id' => $request->input('tb_office_id'),
        ]);

    } catch (\Illuminate\Database\QueryException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.usermcu.create');
        
    } catch (ModelNotFoundException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.usermcu.create');

    } catch (\Exception $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.usermcu.create');

    } catch (PDOException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.usermcu.create');

    } catch (Throwable $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.usermcu.create');
        
    }

        Alert::success('Sukses', 'User mcu berhasil ditambahkan.');
        return redirect()->route('admin.usermcu.index');
    }

    public function edit($id) {
        try {
            $data = UserMcu::findOrFail($id);

            // for select2 office name
            $dataOffice = Office::select('id', 'office_name')
                                        ->where('id', $data->tb_office_id)
                                        ->first();
            
            $data->office_name = $dataOffice->office_name;

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        }

        try {
            // for select2 office name
            $dataOffice = Office::select('id', 'office_name')
                                        ->where('id', $data->tb_office_id)
                                        ->first();
            
            $data->office_name = $dataOffice->office_name;

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit User Mcu!');
            return redirect()->route('admin.usermcu.index');
        }

        return view('mazer_template.admin.form_user_mcu.edit', compact('data'));
    }

    public function update(Request $request, $id) {
       try {
            $UserMcu = UserMcu::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (\Exception $e) {
            Alert::error('Gagal update User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (PDOException $e) {
            Alert::error('Gagal update User Mcu!');
            return redirect()->route('admin.usermcu.index');
        } catch (Throwable $e) {
            Alert::error('Gagal update User Mcu!');
            return redirect()->route('admin.usermcu.index');
        }
        
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'username_card' => 'required',
            'nama_lengkap' => 'required',
            'nik' => 'required',
            'jabatan' => 'required',
            'tb_office_id' => 'required',
        ],$messages);

        if($request->input('username_card') != $UserMcu->username_card) {
            $validator->addRules(['username_card' => 'required|unique:tb_user_mcu,username_card']);
        }
        if($request->input('nik') != $UserMcu->nik) {
            $validator->addRules(['nik' => 'required|unique:tb_user_mcu,nik']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.usermcu.edit',$id)->withErrors($validator->errors())->withInput();
        }

        try {
            UserMcu::where('id',$id)
                ->update([
                    'username_card' => $request->input('username_card'),
                    'nama_lengkap' => $request->input('nama_lengkap'),
                    'nik' => $request->input('nik'),
                    'jabatan' => $request->input('jabatan'),
                    'tb_office_id' => $request->input('tb_office_id'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update user mcu!');
            return redirect()->route('admin.usermcu.edit',$id);
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update user mcu!');
            return redirect()->route('admin.usermcu.edit',$id);
        } catch (\Exception $e) {
            Alert::error('Gagal update user mcu!');
            return redirect()->route('admin.usermcu.edit',$id);
        } catch (PDOException $e) {
            Alert::error('Gagal update user mcu!');
            return redirect()->route('admin.usermcu.edit',$id);
        } catch (Throwable $e) {
            Alert::error('Gagal update user mcu!');
            return redirect()->route('admin.usermcu.edit',$id);
        }

        Alert::success('Sukses', 'Update user mcu berhasil');
        return redirect()->route('admin.usermcu.index');

    }

    public function destroy($id) {
        try {
            $userMcu = UserMcu::findOrFail($id);
            $userMcu->delete();
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.usermcu.index');
            
        } catch (ModelNotFoundException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.usermcu.index');

        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.usermcu.index');

        } catch (PDOException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.usermcu.index');

        } catch (Throwable $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.usermcu.index');
            
        }

        Alert::success('Sukses', 'User mcu berhasil dihapus.');
        return redirect()->route('admin.usermcu.index');
    }

}