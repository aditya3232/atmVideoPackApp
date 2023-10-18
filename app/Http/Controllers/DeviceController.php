<?php

namespace App\Http\Controllers;

use App\Models\TbTid;
use App\Models\TbLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class DeviceController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_device.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_tid.tid',
                            1 =>'tb_tid.sn_mini_pc',
                            2 =>'regional_office.regional_office_name',
                            3 =>'kc_supervisi.kc_supervisi_name',
                            4 =>'branch.branch_name',
                            5 =>'tb_tid.created_at',
                            6 =>'tb_tid.id', //action
                        );

        $totalData = TbTid::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbTids = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $FormTbTids = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.sn_mini_pc','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'tb_tid.sn_mini_pc',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.created_at',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.sn_mini_pc','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbTids))
        {
            foreach ($FormTbTids as $FormTbTid)
            {
                $edit =  route('admin.device.edit',$FormTbTid->id);


                $TbTidId = $FormTbTid->id;
                $Tid = $FormTbTid->tid;

                $nestedData['id'] = $FormTbTid->id;
                $nestedData['tid'] = $FormTbTid->tid;
                $nestedData['sn_mini_pc'] = $FormTbTid->sn_mini_pc;
                $nestedData['regional_office_name'] = $FormTbTid->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbTid->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbTid->branch_name;
                $nestedData['created_at'] = $FormTbTid->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-tid-id='$TbTidId' data-tid='$Tid' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteKcSupervisi' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
        return view('mazer_template.admin.form_device.create');
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
            'tid' => 'required',
            'ip_address' => 'required',
            'sn_mini_pc' => 'required',
            'location_id' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('tid') != null) {
            $validator = Validator::make($request->all(),[
                'tid' => 'required|unique:tb_tid,tid',
            ],$messages);
        }

        if($request->input('ip_address') != null) {
            $validator = Validator::make($request->all(),[
                'ip_address' => 'required|unique:tb_tid,ip_address',
            ],$messages);
        }

        if($request->input('sn_mini_pc') != null) {
            $validator = Validator::make($request->all(),[
                'sn_mini_pc' => 'required|unique:tb_tid,sn_mini_pc',
            ],$messages);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.device.create')->withErrors($validator->errors())->withInput();
        }

        try {
        DB::beginTransaction();

        TbTid::insert([
            'tid' => $request->input('tid'),
            'ip_address' => $request->input('ip_address'),
            'sn_mini_pc' => $request->input('sn_mini_pc'),
            'location_id' => $request->input('location_id'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.device.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.device.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.device.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.device.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.device.create');
        
    }

        Alert::success('Sukses', 'Device berhasil ditambahkan.');
        return redirect()->route('admin.device.index');
    }

    public function select2Location(Request $request) {
        $search = $request->search;

        if($search) {
            $locations = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
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
                            ->limit(100)
                            ->get();
        } else {
            $locations = TbLocation::join('tb_regional_office as regional_office', 'regional_office.id', '=', 'tb_location.regional_office_id')
                            ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'tb_location.kc_supervisi_id')
                            ->join('tb_branch as branch', 'branch.id', '=', 'tb_location.branch_id')
                            ->select('regional_office.regional_office_name',
                                                 'kc_supervisi.kc_supervisi_name',
                                                 'branch.branch_name',
                                                 'tb_location.address',
                                                 'tb_location.postal_code',
                                                 'tb_location.created_at',
                                                 'tb_location.id')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($locations as $location){
                $response[] = array(
                    "id"=> $location->id,
                    "text"=> $location->regional_office_name . ' - ' . $location->kc_supervisi_name . ' - ' . $location->branch_name . ' - ' . $location->address . ' - ' . $location->postal_code
                );
            }

        return response()->json($response);
    }

}
