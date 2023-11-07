<?php

namespace App\Http\Controllers;

use App\Models\TbRegionalOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class RegionalOfficeController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_regional_office.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'regional_office_name',
                            1 =>'created_at',
                            2 =>'id', //action
                        );

        $totalData = TbRegionalOffice::count();

        $totalFiltered = $totalData; 

        // $limit = $request->input('length');
        $limit = 100;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormTbRegionalOffices = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormTbRegionalOffices = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                            ->where('regional_office_name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TbRegionalOffice::select('regional_office_name', 'created_at', 'id')
                            ->where('regional_office_name','LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormTbRegionalOffices))
        {
            foreach ($FormTbRegionalOffices as $FormTbRegionalOffice)
            {
                $edit =  route('admin.regionaloffice.edit',$FormTbRegionalOffice->id);


                $TbRegionalOfficeId = $FormTbRegionalOffice->id;
                $regionalOfficeName = $FormTbRegionalOffice->regional_office_name;

                $nestedData['id'] = $FormTbRegionalOffice->id;
                $nestedData['regional_office_name'] = $FormTbRegionalOffice->regional_office_name;
                $nestedData['created_at'] = $FormTbRegionalOffice->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Edit' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <button type='button' class='btn btn-sm mt-2' id='delete-regional-office' style='border-radius:12px; background-color:#FF0000; color:white;' data-regional-office-name='{$regionalOfficeName}' data-tb-regional-office-id='{$TbRegionalOfficeId}'><i class='bi bi-trash'></i></button>
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
        return view('mazer_template.admin.form_regional_office.create');
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
            'regional_office_name' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('regional_office_name') != null) {
            $validator = Validator::make($request->all(),[
                'regional_office_name' => 'required|unique:tb_regional_office,regional_office_name',
            ],$messages);
        }

        // if($validator->fails()) {
        //     Alert::error('Cek kembali pengisian form, terima kasih !');
        //     return redirect()->route('admin.regionaloffice.create')->withErrors($validator->errors())->withInput();
        // }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
        DB::beginTransaction();

        DB::table('tb_regional_office')->insert([
            'regional_office_name' => $request->input('regional_office_name'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.regionaloffice.create');
        
    }

        // Alert::success('Sukses', 'Regional office berhasil ditambahkan.');
        // return redirect()->route('admin.regionaloffice.index');

        return response()->json(['message' => 'Regional office berhasil ditambahkan']);
    }

    public function edit($id) {
        try {
            $data = TbRegionalOffice::findOrFail($id);

            return view('mazer_template.admin.form_regional_office.edit', compact('data'));

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = TbRegionalOffice::findOrFail($id);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit regional office!');
            return redirect()->route('admin.regionaloffice.index');
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'regional_office_name' => 'required',
        ],$messages);

        // check if the regional_office_name values have changed
        if ($request->input('regional_office_name') !== $data->regional_office_name) {
            $validator->addRules(['regional_office_name' => 'required|unique:tb_regional_office,regional_office_name']);
        }

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();

        TbRegionalOffice::where('id',$id)
        ->update([
            'regional_office_name' => $request->input('regional_office_name'),
        ]);

        DB::commit();
        
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.regionaloffice.edit');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.regionaloffice.edit');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.regionaloffice.edit');
        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.regionaloffice.edit');
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('admin.regionaloffice.edit');
        }

        return response()->json(['message' => 'Regional office berhasil diupdate']);

    }

    public function destroy($id) {
        try {
            DB::beginTransaction();

            $tb_regional_office = TbRegionalOffice::findOrFail($id);
            $tb_regional_office->delete();

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

        return response()->json(['message' => 'Regional office berhasil dihapus']);

    }



}