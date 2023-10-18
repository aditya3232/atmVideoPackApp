<?php

namespace App\Http\Controllers;

use App\Models\TbTid;
use App\Models\TbStatusMc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;
use GuzzleHttp\Client;

class StreamingCctvController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_streaming_cctv.index');
    }

    public function streamingCctv($id) {
        try {
            $data = TbTid::findOrFail($id);

            $get_data_tb_mcu_id = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'tb_tid.ip_address',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.id')
                        ->where('tb_tid.id', $data->id)
                        ->get();

            $get_status_mc = TbStatusMc::where('tid_id', $data->id)
                                        // where latest date_time
                                        ->orderBy('date_time', 'desc')
                                        ->first();


        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk halaman streaming!');
            return redirect()->route('admin.streamingcctv.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk halaman streaming!');
            return redirect()->route('admin.streamingcctv.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk halaman streaming!');
            return redirect()->route('admin.streamingcctv.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk halaman streaming!');
            return redirect()->route('admin.streamingcctv.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk halaman streaming!');
            return redirect()->route('admin.streamingcctv.index');
        }

        return view('mazer_template.admin.form_streaming_cctv.streaming', compact('get_data_tb_mcu_id','get_status_mc'));
    }



    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_tid.tid',
                            1 =>'regional_office.regional_office_name',
                            2 =>'kc_supervisi.kc_supervisi_name',
                            3 =>'branch.branch_name',
                            4 =>'tb_tid.id', //action
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
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
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
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbTid::join('tb_location as location', 'location.id', '=', 'tb_tid.location_id')
                        ->join('tb_regional_office as regional_office', 'regional_office.id', '=', 'location.regional_office_id')
                        ->join('tb_kc_supervisi as kc_supervisi', 'kc_supervisi.id', '=', 'location.kc_supervisi_id')
                        ->join('tb_branch as branch', 'branch.id', '=', 'location.branch_id')
                        ->select('tb_tid.tid',
                            'regional_office.regional_office_name',
                            'kc_supervisi.kc_supervisi_name',
                            'branch.branch_name',
                            'tb_tid.id')
                            ->where('regional_office.regional_office_name','LIKE',"%{$search}%")
                            ->orWhere('kc_supervisi.kc_supervisi_name','LIKE',"%{$search}%")
                            ->orWhere('branch.branch_name','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.tid','LIKE',"%{$search}%")
                            ->orWhere('tb_tid.ip_address','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbTids))
        {
            foreach ($FormTbTids as $FormTbTid)
            {
                $edit =  route('admin.streamingcctv.streaming',$FormTbTid->id);


                $TbTidId = $FormTbTid->id;
                $Tid = $FormTbTid->tid;

                $nestedData['id'] = $FormTbTid->id;
                $nestedData['tid'] = $FormTbTid->tid;
                $nestedData['regional_office_name'] = $FormTbTid->regional_office_name;
                $nestedData['kc_supervisi_name'] = $FormTbTid->kc_supervisi_name;
                $nestedData['branch_name'] = $FormTbTid->branch_name;
                $nestedData['options'] = "
                <a href='{$edit}'  target='_blank' title='Streaming' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-pip-fill'></i></a>
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