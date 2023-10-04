<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Mcu;
use App\Models\Office;
use App\Models\UserMcu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;

class CardController extends Controller
{
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_card.index');
    }

    public function dataTable(Request $request) {
        // disini harus semua kolom yang ada di table di definisikan
        $columns = array( 
                            0 =>'tb_entry.no_card',
                            1 =>'tb_entry.state',
                            2 =>'tb_office.office_name',
                            3 =>'tb_entry.created_at',
                            4 =>'id', //action
                        );

        $totalData = Card::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $FormCards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_entry.*', 'tb_office.office_name')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $FormCards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_entry.*', 'tb_office.office_name')
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('no_card', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                            ->select('tb_entry.*', 'tb_office.office_name')
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('no_card', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($FormCards))
        {
            foreach ($FormCards as $FormCard)
            {
                $edit =  route('admin.card.edit',$FormCard->id);
                // $edit = route('admin.card.edit', [$FormCard->id, $FormCard->tb_office_id]);


                $tbEntryId = $FormCard->id;
                $card = $FormCard->no_card;

                $nestedData['id'] = $FormCard->id;
                $nestedData['no_card'] = $FormCard->no_card;
                $nestedData['office_name'] = $FormCard->office_name;
                $nestedData['created_at'] = $FormCard->created_at;
                $nestedData['options'] = "
                <a href='{$edit}' title='Assign Mcu' class='btn btn-sm mt-2' style='border-radius:12px; background-color:#0000FF; color:white;'><i class='bi bi-wrench'></i></a>
                <a data-tb-entry-id='$tbEntryId' data-card='$card' title='DESTROY' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalDeleteCard' style='border-radius:12px; background-color:#FF0000; color:white;'><i class='bi bi-trash'></i></a>
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
        return view('mazer_template.admin.form_card.create');
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
            'no_card' => 'required',
            'tb_office_id' => 'required',
        ],$messages);

        // if input no_card not null then must unique, but when null or string '' then not unique
        if($request->input('no_card') != null) {
            $validator = Validator::make($request->all(),[
                'no_card' => 'required|unique:tb_entry,no_card',
            ],$messages);
        }

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.card.create')->withErrors($validator->errors())->withInput();
        }

        try {
        DB::beginTransaction();

        DB::table('tb_entry')->insert([
            'no_card' => $request->input('no_card'),
            'tb_office_id' => $request->input('tb_office_id'),
        ]);

        DB::commit();

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.card.create');
        
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.card.create');

    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.card.create');

    } catch (PDOException $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.card.create');

    } catch (Throwable $e) {
        DB::rollBack();
        Alert::error($e->getMessage());
        return redirect()->route('admin.card.create');
        
    }

        Alert::success('Sukses', 'No Card berhasil ditambahkan.');
        return redirect()->route('admin.card.index');
    }

    public function edit($id) {
        try {
            $data = Card::findOrFail($id);

            // for select2 office name
            $dataOffice = Office::select('id', 'office_name')
                                        ->where('id', $data->tb_office_id)
                                        ->first();
            
            $data->office_name = $dataOffice->office_name;
            $data->office_id = $dataOffice->id;


            $get_data_tb_mcu_id = DB::table('tb_entry_mcu as a')
                                    ->join('tb_mcu as b', 'b.id', '=', 'a.tb_mcu_id')
                                    ->select('b.id', 'b.door_name_mcu')
                                    ->where('a.tb_entry_id', $data->id)
                                    ->get();

        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal masuk form edit card!');
            return redirect()->route('admin.card.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal masuk form edit card!');
            return redirect()->route('admin.card.index');
        } catch (\Exception $e) {
            Alert::error('Gagal masuk form edit card!');
            return redirect()->route('admin.card.index');
        } catch (PDOException $e) {
            Alert::error('Gagal masuk form edit card!');
            return redirect()->route('admin.card.index');
        } catch (Throwable $e) {
            Alert::error('Gagal masuk form edit card!');
            return redirect()->route('admin.card.index');
        }

        return view('mazer_template.admin.form_card.edit', compact('data','get_data_tb_mcu_id'));
    }

    public function assignMcu(Request $request, $card_id) {
        try {
            $card = Card::findOrFail($card_id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
        } catch (PDOException $e) {
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
        } catch (Throwable $e) {
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
        }   
        

        try {
            DB::beginTransaction();

            // add data in tb_entry_mcu (contains tb_mcu_id and tb_entry_id)
            // from multiple select mcu
            $mcus = $request->mcu;

            foreach ($mcus as $mcu) {
                $entry_mcu = DB::table('tb_entry_mcu')
                        ->insert([
                            'tb_mcu_id' => $mcu,
                            'tb_entry_id' => $card_id
                        ]);
            }

            DB::commit();
            
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses mcu!');
            return back();
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses mcu!');
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses mcu!');
            return back();

        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses mcu!');
            return back();

        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses mcu!');
            return back();

        }   

        return back()->with('success', 'Akses mcu berhasil ditambahkan!');
    }

    public function deleteMcu($tb_entry_id, $tb_mcu_id) {
         DB::table('tb_entry_mcu')
                ->where('tb_entry_id', $tb_entry_id)
                ->where('tb_mcu_id', $tb_mcu_id)
                ->delete();

        Alert::success('Sukses', 'Akses mcu telah dihapus');
        return back();
    }

    public function select2Mcu(Request $request, $officeId, $cardId) {
        $search = $request->search;

        if($search) {

            // get data tb_mcu_id from tb_entry_mcu in array
            $excludedIds = DB::table('tb_entry_mcu')
                ->where('tb_entry_mcu.tb_entry_id', $cardId)
                ->pluck('tb_entry_mcu.tb_mcu_id') // pluck adalah mengambil nilainya saja
                ->toArray();

            $Mcus = Mcu::join('tb_office', 'tb_mcu.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_mcu.id', 'tb_mcu.door_name_mcu', 'tb_mcu.door_token', 'tb_office.office_name')
                        ->where('tb_mcu.tb_office_id', $officeId) // where office id
                        ->whereNotIn('tb_mcu.id', $excludedIds)
                        ->where(function ($query) use ($search) {
                            $query->where('tb_mcu.door_name_mcu', 'LIKE', "%{$search}%")
                                ->orWhere('tb_mcu.door_token', 'LIKE', "%{$search}%")
                                ->orWhere('tb_office.office_name', 'LIKE', "%{$search}%");
                        })
                        ->limit(100)
                        ->get();
        } else {
            // get data tb_mcu_id from tb_entry_mcu in array
            $excludedIds = DB::table('tb_entry_mcu')
                ->where('tb_entry_mcu.tb_entry_id', $cardId)
                ->pluck('tb_entry_mcu.tb_mcu_id')
                ->toArray();
                                    
            $Mcus = Mcu::join('tb_office', 'tb_mcu.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_mcu.id', 'tb_mcu.door_name_mcu', 'tb_mcu.door_token', 'tb_office.office_name')
                        ->where('tb_mcu.tb_office_id', $officeId) 
                        ->whereNotIn('tb_mcu.id', $excludedIds)   
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Mcus as $Mcu){
                $response[] = array(
                    "id"=>$Mcu->id,
                    "text"=>$Mcu->door_name_mcu . ' - ' . $Mcu->door_token . ' - ' . $Mcu->office_name
                );
            }

        return response()->json($response);
    }

    public function update(Request $request, $id) {
       try {
            $Card = Card::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.index');
        } catch (\Exception $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.index');
        } catch (PDOException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.index');
        } catch (Throwable $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.index');
        }
        
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            'tb_office_id' => 'required',
        ],$messages);

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.card.edit',$id)->withErrors($validator->errors())->withInput();
        }

        try {
            Card::where('id',$id)
                ->update([
                    'tb_office_id' => $request->input('tb_office_id'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.edit',$id);
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.edit',$id);
        } catch (\Exception $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.edit',$id);
        } catch (PDOException $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.edit',$id);
        } catch (Throwable $e) {
            Alert::error('Gagal update lokasi kantor!');
            return redirect()->route('admin.card.edit',$id);
        }

        Alert::success('Sukses', 'Update lokasi kantor berhasil');
        return redirect()->route('admin.card.index');

    }

    public function destroy($id) {
        try {
            $card = Card::findOrFail($id);
            $card->delete();
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.card.index');
            
        } catch (ModelNotFoundException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.card.index');

        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.card.index');

        } catch (PDOException $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.card.index');

        } catch (Throwable $e) {
            Alert::error($e->getMessage());
            return redirect()->route('admin.card.index');
            
        }

        Alert::success('Sukses', 'No Card berhasil dihapus.');
        return redirect()->route('admin.card.index');
    }

}