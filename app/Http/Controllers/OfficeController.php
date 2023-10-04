<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Mcu;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDOException;
use Throwable;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_office.index');
    }

    public function dataTable(Request $request) {
        $columns = array( 
                            0 =>'office_name',
                            1 =>'address_office',
                            2 =>'kode_pos',
                            3 => 'created_at',
                            4 => 'id', //action
                        );

        $totalData = Office::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $Offices = Office::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $Offices = Office::where('office_name', 'LIKE',"%{$search}%")
                            ->orWhere('address_office', 'LIKE',"%{$search}%")
                            ->orWhere('kode_pos', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Office::where('office_name', 'LIKE',"%{$search}%")
                            ->orWhere('address_office', 'LIKE',"%{$search}%")
                            ->orWhere('kode_pos', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($Offices))
        {
            foreach ($Offices as $Office)
            {

                $edit =  route('admin.office.edit',$Office->id);

                $tbOfficeId = $Office->id;
                $officeName = $Office->office_name;

                $nestedData['id'] = $Office->id;
                $nestedData['office_name'] = $Office->office_name;
                $nestedData['address_office'] = $Office->address_office;
                $nestedData['kode_pos'] = $Office->kode_pos;
                $nestedData['created_at'] = $Office->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='EDIT' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-office-id='$tbOfficeId' data-office-name='$officeName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteOffice' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
        return view('mazer_template.admin.form_office.create');
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
            'office_name' => 'required',
            'address_office' => 'required',
            'kode_pos' => 'required',
        ],$messages);

        if($request->input('office_name') != null) {
            $validator->addRules(['office_name' => 'required|unique:tb_office,office_name']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.office.create')->withErrors($validator->errors())->withInput();
        }

        try {
        Office::insert([
            'office_name' => $request->input('office_name'),
            'address_office' => $request->input('address_office'),
            'kode_pos' => $request->input('kode_pos'),
        ]);

    } catch (\Illuminate\Database\QueryException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.office.create');
        
    } catch (ModelNotFoundException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.office.create');

    } catch (\Exception $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.office.create');

    } catch (PDOException $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.office.create');

    } catch (Throwable $e) {
        Alert::error($e->getMessage());
        return redirect()->route('admin.office.create');
        
    }

        Alert::success('Sukses', 'Office berhasil ditambahkan.');
        return redirect()->route('admin.office.index');
    }

    public function edit($id) {
        try {
            $data = Office::findOrFail($id);

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit Office!');
            return redirect()->route('admin.office.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit Office!');
            return redirect()->route('admin.office.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit Office!');
            return redirect()->route('admin.office.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit Office!');
            return redirect()->route('admin.office.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit Office!');
            return redirect()->route('admin.office.index');
        }

        return view('mazer_template.admin.form_office.edit', compact('data'));
    }

    public function update(Request $request, $id) {
       try {
            $Office = Office::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update Office!');
            return redirect()->route('admin.office.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update Office!');
            return redirect()->route('admin.office.index');
        } catch (\Exception $e) {
            Alert::error('Gagal update Office!');
            return redirect()->route('admin.office.index');
        } catch (PDOException $e) {
            Alert::error('Gagal update Office!');
            return redirect()->route('admin.office.index');
        } catch (Throwable $e) {
            Alert::error('Gagal update Office!');
            return redirect()->route('admin.office.index');
        }
        
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'office_name' => 'required',
            'address_office' => 'required',
            'kode_pos' => 'required',
        ],$messages);

        if ($request->input('office_name') !== $Office->office_name) {
            $validator->addRules(['office_name' => 'required|unique:tb_office,office_name']);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.office.edit',$id)->withErrors($validator->errors())->withInput();
        }

        try {
            Office::where('id',$id)
                ->update([
                    'office_name' => $request->input('office_name'),
                    'address_office' => $request->input('address_office'),
                    'kode_pos' => $request->input('kode_pos'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update office!');
            return redirect()->route('admin.office.edit',$id);
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update office!');
            return redirect()->route('admin.office.edit',$id);
        } catch (\Exception $e) {
            Alert::error('Gagal update office!');
            return redirect()->route('admin.office.edit',$id);
        } catch (PDOException $e) {
            Alert::error('Gagal update office!');
            return redirect()->route('admin.office.edit',$id);
        } catch (Throwable $e) {
            Alert::error('Gagal update office!');
            return redirect()->route('admin.office.edit',$id);
        }

        Alert::success('Sukses', 'Update office berhasil');
        return redirect()->route('admin.office.index');

    }

    public function destroy($id) {
        try {
            $office = Office::findOrFail($id);
            $office->delete();
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.office.index');
            
        } catch (ModelNotFoundException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.office.index');

        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.office.index');

        } catch (PDOException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.office.index');

        } catch (Throwable $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.office.index');
            
        }

        Alert::success('Sukses', 'Office berhasil dihapus.');
        return redirect()->route('admin.office.index');
    }

    

    

}