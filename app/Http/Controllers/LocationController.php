<?php

namespace App\Http\Controllers;

use App\Models\TbLocation;
use App\Models\TbRegionalOffice;
use App\Models\TbKcSupervisi;
use App\Models\TbBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

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

        // $limit = $request->input('length');
        $limit = 100;
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
                $edit =  route('admin.location.edit',$FormTbLocation->id);


                $TbLocationId = $FormTbLocation->id;
                $Location = $FormTbLocation->regional_office_name . ' - ' . $FormTbLocation->kc_supervisi_name . ' - '  . $FormTbLocation->branch_name;

                $nestedData['id'] = $FormTbLocation->id;
                $nestedData['regional_office_name'] = $FormTbLocation->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbLocation->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbLocation->branch_name;
                $nestedData['address'] = $FormTbLocation->address;
                $nestedData['postal_code'] = $FormTbLocation->postal_code;
                $nestedData['created_at'] = $FormTbLocation->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <button type='button' class='btn btn-sm mt-2' id='delete-location' style='border-radius:12px; background-color:#FF0000; color:white;' data-location='{$Location}' data-tb-location-id='{$TbLocationId}'><i class='bi bi-trash'></i></button>
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
        return view('mazer_template.admin.form_location.create');
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
            'regional_office_id' => 'required',
            'kc_supervisi_id' => 'required',
            'branch_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('address') != null) {
            $validator = Validator::make($request->all(),[
                'address' => 'required|unique:tb_location,address',
            ],$messages);
        }

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.location.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
        DB::beginTransaction();

        TbLocation::insert([
            'regional_office_id' => $request->input('regional_office_id'),
            'kc_supervisi_id' => $request->input('kc_supervisi_id'),
            'branch_id' => $request->input('branch_id'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.location.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.location.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.location.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.location.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.location.create');
        
    }

        // Alert::success('Sukses', 'Location berhasil ditambahkan.');
        // return redirect()->route('admin.location.index');

        return response()->json(['message' => 'Location berhasil ditambahkan']);
    }

    public function select2RegionalOffice(Request $request) {
        $search = $request->search;

        if($search) {
            $regionalOffices = TbRegionalOffice::select('id', 'regional_office_name')
                            ->where('regional_office_name', 'LIKE', "%{$search}%")
                            ->limit(100)
                            ->get();
        } else {
            $regionalOffices = TbRegionalOffice::select('id', 'regional_office_name')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($regionalOffices as $regionalOffice){
                $response[] = array(
                    "id"=> $regionalOffice->id,
                    "text"=> $regionalOffice->regional_office_name
                );
            }

        return response()->json($response);
    }

    public function select2KCSupervisi(Request $request) {
        $search = $request->search;

        if($search) {
            $kcSupervisis = TbKcSupervisi::select('id', 'kc_supervisi_name')
                            ->where('kc_supervisi_name', 'LIKE', "%{$search}%")
                            ->limit(100)
                            ->get();
        } else {
            $kcSupervisis = TbKcSupervisi::select('id', 'kc_supervisi_name')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($kcSupervisis as $kcSupervisi){
                $response[] = array(
                    "id"=> $kcSupervisi->id,
                    "text"=> $kcSupervisi->kc_supervisi_name
                );
            }

        return response()->json($response);
    }

    public function select2Branch(Request $request) {
        $search = $request->search;

        if($search) {
            $branchs = TbBranch::select('id', 'branch_name')
                            ->where('branch_name', 'LIKE', "%{$search}%")
                            ->limit(100)
                            ->get();
        } else {
            $branchs = TbBranch::select('id', 'branch_name')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($branchs as $branch){
                $response[] = array(
                    "id"=> $branch->id,
                    "text"=> $branch->branch_name
                );
            }

        return response()->json($response);
    }

    public function edit($id) {
        try {
            $data = TbLocation::findOrFail($id);

            $regionalOfficeName = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
                            ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'tb_location.kc_supervisi_id')
                            ->join('tb_branch as branch', 'branch.id', '=', 'tb_location.branch_id')
                            ->select('regional_office.regional_office_name',
                                                 'kc_supervisi.kc_supervisi_name',
                                                 'branch.branch_name',
                                                 'tb_location.address',
                                                 'tb_location.postal_code',
                                                 'tb_location.created_at',
                                                 'tb_location.id')
                            ->where('tb_location.id', $data->id)
                            ->get();
            
            $regional_office_name = $regionalOfficeName[0]->regional_office_name;
            $kc_supervisi_name = $regionalOfficeName[0]->kc_supervisi_name;
            $branch_name = $regionalOfficeName[0]->branch_name;

            return view('mazer_template.admin.form_location.edit', compact('data','regional_office_name','kc_supervisi_name','branch_name'));

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = TbLocation::findOrFail($id);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit location!');
            return redirect()->route('admin.location.index');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'regional_office_id' => 'required',
            'kc_supervisi_id' => 'required',
            'branch_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
        ],$messages);

        // check if the alamt values have changed
        if ($request->input('address') !== $data->address) {
            $validator->addRules(['address' => 'required|unique:tb_location,address']);
        }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

        TbLocation::where('id',$id)
        ->update([
            'regional_office_id' => $request->input('regional_office_id'),
            'kc_supervisi_id' => $request->input('kc_supervisi_id'),
            'branch_id' => $request->input('branch_id'),
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
        ]);

        DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.edit');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.edit');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.edit');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.edit');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.edit');
        }

        return response()->json(['message' => 'Lokasi berhasil diupdate']);

    }

    public function destroy($id) {
        try {
            DB::beginTransaction();

            $tb_location = TbLocation::findOrFail($id);
            $tb_location->delete();

            DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.index');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.index');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.index');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.location.index');
        }

        return response()->json(['message' => 'Location berhasil dihapus']);

    }

    


}