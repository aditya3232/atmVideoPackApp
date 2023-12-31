<?php

namespace App\Http\Controllers;


use App\Models\TbKcSupervisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class KcSupervisiController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_kc_supervisi.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'kc_supervisi_name',
                            1 =>'created_at',
                            2 =>'id', //action
                        );

        $totalData = TbKcSupervisi::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbKcSupervisis = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbKcSupervisis = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                            ->where('kc_supervisi_name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbKcSupervisi::select('kc_supervisi_name', 'created_at', 'id')
                            ->where('kc_supervisi_name','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbKcSupervisis))
        {
            foreach ($FormTbKcSupervisis as $FormTbKcSupervisi)
            {
                $edit =  route('admin.kcsupervisi.edit',$FormTbKcSupervisi->id);


                $TbKcSupervisiId = $FormTbKcSupervisi->id;
                $kcSupervisiName = $FormTbKcSupervisi->kc_supervisi_name;

                $nestedData['id'] = $FormTbKcSupervisi->id;
                $nestedData['kc_supervisi_name'] = $FormTbKcSupervisi->kc_supervisi_name;
                $nestedData['created_at'] = $FormTbKcSupervisi->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <button type='button' class='btn btn-sm mt-2' id='delete-kc-supervisi' style='border-radius:12px; background-color:#FF0000; color:white;' data-kc-supervisi-name='{$kcSupervisiName}' data-tb-kc-supervisi-id='{$TbKcSupervisiId}'><i class='bi bi-trash'></i></button>
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
        return view('mazer_template.admin.form_kc_supervisi.create');
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
            'kc_supervisi_name' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('kc_supervisi_name') != null) {
            $validator = Validator::make($request->all(),[
                'kc_supervisi_name' => 'required|unique:tb_kc_supervisi,kc_supervisi_name',
            ],$messages);
        }

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.kcsupervisi.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
        DB::beginTransaction();

        DB::table('tb_kc_supervisi')->insert([
            'kc_supervisi_name' => $request->input('kc_supervisi_name'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.kcsupervisi.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.kcsupervisi.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.kcsupervisi.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.kcsupervisi.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.kcsupervisi.create');
        
    }

        // Alert::success('Sukses', 'KC Supervisi berhasil ditambahkan.');
        // return redirect()->route('admin.kcsupervisi.index');

        return response()->json(['message' => 'KC Supervisi berhasil ditambahkan']);
    }

    public function edit($id) {
        try {
            $data = TbKcSupervisi::findOrFail($id);

            return view('mazer_template.admin.form_kc_supervisi.edit', compact('data'));

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = TbKcSupervisi::findOrFail($id);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit kc supervisi!');
            return redirect()->route('admin.kcsupervisi.index');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'kc_supervisi_name' => 'required',
        ],$messages);

        // check if the kc_supervisi_name values have changed
        if ($request->input('kc_supervisi_name') !== $data->kc_supervisi_name) {
            $validator->addRules(['kc_supervisi_name' => 'required|unique:tb_kc_supervisi,kc_supervisi_name']);
        }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

        TbKcSupervisi::where('id',$id)
        ->update([
            'kc_supervisi_name' => $request->input('kc_supervisi_name'),
        ]);

        DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.edit');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.edit');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.edit');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.edit');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.edit');
        }

        return response()->json(['message' => 'KC Supervisi berhasil diupdate']);

    }

    public function destroy($id) {
        try {
            DB::beginTransaction();

            $tb_kc_supervisi = TbKcSupervisi::findOrFail($id);
            $tb_kc_supervisi->delete();

            DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.index');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.index');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.index');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.kcsupervisi.index');
        }

        return response()->json(['message' => 'KC Supervisi berhasil dihapus']);

    }


}