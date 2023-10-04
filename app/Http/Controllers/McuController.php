<?php

namespace App\Http\Controllers;

use App\Models\Mcu;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;

class McuController extends Controller
{
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_mcu.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_mcu.door_token',
                            1 =>'tb_mcu.door_name_mcu',
                            2 =>'tb_mcu.type_mcu',
                            3 =>'tb_mcu.keypad_password',
                            4 =>'tb_mcu.delay',
                            5 =>'tb_office.office_name',
                            6 =>'tb_mcu.created_at',
                            7 => 'tb_mcu.id', //action
                        );

        $totalData = Mcu::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormMcus = Mcu::join('tb_office', 'tb_mcu.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_mcu.*', 'tb_office.office_name')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormMcus = Mcu::join('tb_office', 'tb_mcu.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_mcu.*', 'tb_office.office_name')
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('door_token', 'LIKE',"%{$search}%")
                            ->orWhere('door_name_mcu', 'LIKE',"%{$search}%")
                            ->orWhere('type_mcu', 'LIKE',"%{$search}%")
                            ->orWhere('keypad_password', 'LIKE',"%{$search}%")
                            ->orWhere('delay', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Mcu::join('tb_office', 'tb_mcu.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_mcu.*', 'tb_office.office_name')
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('door_token', 'LIKE',"%{$search}%")
                            ->orWhere('door_name_mcu', 'LIKE',"%{$search}%")
                            ->orWhere('type_mcu', 'LIKE',"%{$search}%")
                            ->orWhere('keypad_password', 'LIKE',"%{$search}%")
                            ->orWhere('delay', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormMcus))
        {
            foreach ($FormMcus as $FormMcu)
            {
                $edit =  route('admin.mcu.edit',$FormMcu->id);

                $tbMcuId = $FormMcu->id;
                $doorToken = $FormMcu->door_token;
                $doorName = $FormMcu->door_name_mcu;

                $nestedData['id'] = $FormMcu->id;
                $nestedData['door_token'] = $FormMcu->door_token;
                $nestedData['door_name_mcu'] = $FormMcu->door_name_mcu;
                $nestedData['type_mcu'] = $FormMcu->type_mcu;
                $nestedData['keypad_password'] = $FormMcu->keypad_password;
                $nestedData['delay'] = $FormMcu->delay;
                $nestedData['office_name'] = $FormMcu->office_name;
                $nestedData['created_at'] = $FormMcu->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='EDIT' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-mcu-id='$tbMcuId' data-door-token='$doorToken' data-door-name='$doorName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteMcu' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
        return view('mazer_template.admin.form_mcu.create');
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
            'door_token' => 'required',
            'door_name_mcu' => 'required',
            'type_mcu' => 'required',
            'keypad_password' => 'required',
            'delay' => 'required',
            'tb_office_id' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('door_token') != null) {
            $validator->addRules(['door_token' => 'required|unique:tb_mcu,door_token']);
        }

        if($request->input('door_name_mcu') != null) {
            $validator->addRules(['door_name_mcu' => 'required|unique:tb_mcu,door_name_mcu']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.mcu.create')->withErrors($validator->errors())->withInput();
        }

        try {
        Mcu::insert([
            'door_token' => $request->input('door_token'),
            'door_name_mcu' => $request->input('door_name_mcu'),
            'type_mcu' => $request->input('type_mcu'),
            'keypad_password' => $request->input('keypad_password'),
            'delay' => $request->input('delay'),
            'tb_office_id' => $request->input('tb_office_id'),
        ]);

    } catch (\Illuminate\Database\QueryException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.mcu.create');
        
    } catch (ModelNotFoundException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.mcu.create');

    } catch (\Exception $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.mcu.create');

    } catch (PDOException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.mcu.create');

    } catch (Throwable $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.mcu.create');
        
    }

        Alert::success('Sukses', 'Mcu berhasil ditambahkan.');
        return redirect()->route('admin.mcu.index');
    }

    public function edit($id) {
        try {
            $data = Mcu::findOrFail($id);

            // for select2 office name
            $dataOffice = Office::select('id', 'office_name')
                                        ->where('id', $data->tb_office_id)
                                        ->first();
            
            $data->office_name = $dataOffice->office_name;

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit Controller!');
            return redirect()->route('admin.mcu.index');
        }

        return view('mazer_template.admin.form_mcu.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        try {
            $Mcu = Mcu::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (\Exception $e) {
            Alert::error('Gagal update Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (PDOException $e) {
            Alert::error('Gagal update Controller!');
            return redirect()->route('admin.mcu.index');
        } catch (Throwable $e) {
            Alert::error('Gagal update Controller!');
            return redirect()->route('admin.mcu.index');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'door_token' => 'required',
            'door_name_mcu' => 'required',
            'type_mcu' => 'required',
            'keypad_password' => 'required',
            'delay' => 'required',
            'tb_office_id' => 'required',
        ],$messages);

        // Check if the 'nik' values have changed
        if ($request->input('door_token') !== $Mcu->door_token) {
            $validator->addRules(['door_token' => 'required|unique:tb_mcu,door_token']);
        }
        if ($request->input('door_name_mcu') !== $Mcu->door_name_mcu) {
            $validator->addRules(['door_name_mcu' => 'required|unique:tb_mcu,door_name_mcu']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.mcu.edit',$id)->withErrors($validator->errors())->withInput();
        }

        try {
            mcu::where('id',$id)
                ->update([
                    'door_token' => $request->input('door_token'),
                    'door_name_mcu' => $request->input('door_name_mcu'),
                    'type_mcu' => $request->input('type_mcu'),
                    'keypad_password' => $request->input('keypad_password'),
                    'delay' => $request->input('delay'),
                    'tb_office_id' => $request->input('tb_office_id'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update controller!');
            return redirect()->route('admin.mcu.edit',$id);
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update controller!');
            return redirect()->route('admin.mcu.edit',$id);
        } catch (\Exception $e) {
            Alert::error('Gagal update controller!');
            return redirect()->route('admin.mcu.edit',$id);
        } catch (PDOException $e) {
            Alert::error('Gagal update controller!');
            return redirect()->route('admin.mcu.edit',$id);
        } catch (Throwable $e) {
            Alert::error('Gagal update controller!');
            return redirect()->route('admin.mcu.edit',$id);
        }

        Alert::success('Sukses', 'Update controller berhasil');
        return redirect()->route('admin.mcu.index');
    }

    public function destroy($id) {
        try {
            $mcu = Mcu::findOrFail($id);
            $mcu->delete();
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.mcu.index');
            
        } catch (ModelNotFoundException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.mcu.index');

        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.mcu.index');

        } catch (PDOException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.mcu.index');

        } catch (Throwable $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.mcu.index');
            
        }

        Alert::success('Sukses', 'Mcu berhasil dihapus.');
        return redirect()->route('admin.mcu.index');
    }


}