<?php

namespace App\Http\Controllers;

use App\Models\TbBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class BranchController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_branch.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'branch_name',
                            1 =>'branch_code',
                            2 =>'created_at',
                            3 =>'id', //action
                        );

        $totalData = TbBranch::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbBranchs = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbBranchs = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                            ->where('branch_name','LIKE',"%{$search}%")
                            ->orWhere('branch_code', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbBranch::select('branch_name', 'branch_code', 'created_at', 'id')
                            ->where('branch_name','LIKE',"%{$search}%")
                            ->orWhere('branch_code', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbBranchs))
        {
            foreach ($FormTbBranchs as $FormTbBranch)
            {
                $edit =  route('admin.branch.edit',$FormTbBranch->id);


                $tbBranchId = $FormTbBranch->id;
                $branchName = $FormTbBranch->branch_name;

                $nestedData['id'] = $FormTbBranch->id;
                $nestedData['branch_name'] = $FormTbBranch->branch_name;
                $nestedData['branch_code'] = $FormTbBranch->branch_code;
                $nestedData['created_at'] = $FormTbBranch->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$tbBranchId' data-branch-name='$branchName' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteBranch' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
        return view('mazer_template.admin.form_branch.create');
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
            'branch_name' => 'required',
            'branch_code' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('branch_name') != null) {
            $validator = Validator::make($request->all(),[
                'branch_name' => 'required|unique:tb_branch,branch_name',
            ],$messages);
        }

        if($request->input('branch_code') != null) {
            $validator = Validator::make($request->all(),[
                'branch_code' => 'required|unique:tb_branch,branch_code',
            ],$messages);
        }

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.branch.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
        DB::beginTransaction();

        DB::table('tb_branch')->insert([
            'branch_name' => $request->input('branch_name'),
            'branch_code' => $request->input('branch_code'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.branch.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.branch.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.branch.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.branch.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.branch.create');
        
    }

        // Alert::success('Sukses', 'Branch berhasil ditambahkan.');
        // return redirect()->route('admin.branch.index');
        
        return response()->json(['message' => 'Branch berhasil ditambahkan']);
    }


    public function edit($id) {
        try {
            $data = TbBranch::findOrFail($id);

            return view('mazer_template.admin.form_branch.edit', compact('data'));

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = TbBranch::findOrFail($id);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit branch!');
            return redirect()->route('admin.branch.index');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'branch_name' => 'required',
            'branch_code' => 'required',
        ],$messages);

        // check if the branch_name values have changed
        if ($request->input('branch_name') !== $data->branch_name) {
            $validator->addRules(['branch_name' => 'required|unique:tb_branch,branch_name']);
        }

        if ($request->input('branch_code') !== $data->branch_code) {
            $validator->addRules(['branch_code' => 'required|unique:tb_branch,branch_code']);
        }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

        TbBranch::where('id',$id)
        ->update([
            'branch_name' => $request->input('branch_name'),
            'branch_code' => $request->input('branch_code'),
        ]);

        DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.branch.edit');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.branch.edit');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.branch.edit');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.branch.edit');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.branch.edit');
        }

        return response()->json(['message' => 'Branch berhasil diupdate']);

    }


}