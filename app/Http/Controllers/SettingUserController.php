<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Entry;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\SettingUser;
use App\Models\UserMcu;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Support\Facades\Validator;
use PDOException;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingUserController extends Controller
{
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin hapus?";
        confirmDelete($title, $text);
        return view('mazer_template.admin.form_setting_user.index');
    }

    public function dataTable(Request $request) {
        $columns = array( 
                            0 =>'tb_entry.no_card',
                            1 =>'tb_user_mcu.username_card',
                            2 =>'tb_user_mcu.status_pekerja',
                            3 =>'tb_user_mcu.status_user',
                            4 =>'tb_office.office_name',
                            5 =>'lokasi_kantor_yg_dikunjungi',
                            6 => 'id', //action
                        );

        $totalData = UserMcu::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        $noCard = $request->input('no_card');
        $usernameCard = $request->input('username_card');
        $statusPekerja = $request->input('status_pekerja');
        $statusUser = $request->input('status_user');
        $officeName = $request->input('office_name');
        $lokasiKantorYangDikunjungi = $request->input('lokasi_kantor_yg_dikunjungi');

        $SettingUsers = UserMcu::join('tb_office', 'tb_user_mcu.tb_office_id', '=', 'tb_office.id')
                        ->leftJoin('tb_entry', 'tb_user_mcu.tb_entry_id', '=', 'tb_entry.id')
                        ->select(
                            'tb_user_mcu.*',
                            'tb_entry.no_card',
                            'tb_office.office_name',
                            DB::raw('(SELECT to2.office_name FROM tb_entry te INNER JOIN tb_office to2 ON te.tb_office_id = to2.id WHERE te.no_card = tb_entry.no_card) AS lokasi_kantor_yg_dikunjungi')
                        )
                        ->when($noCard, function ($query) use ($noCard) {
                        return $query->where('tb_entry.no_card', 'LIKE', "%{$noCard}%");
                        })
                        ->when($usernameCard, function ($query) use ($usernameCard) {
                        return $query->where('tb_user_mcu.username_card', 'LIKE', "%{$usernameCard}%");
                        })
                        ->when($statusPekerja, function ($query) use ($statusPekerja) {
                        return $query->where('tb_user_mcu.status_pekerja', 'LIKE', "%{$statusPekerja}%");
                        })
                        ->when($statusUser, function ($query) use ($statusUser) {
                        return $query->where('tb_user_mcu.status_user', 'LIKE', "%{$statusUser}%");
                        })
                        ->when($officeName, function ($query) use ($officeName) {
                        return $query->where('tb_office.office_name', 'LIKE', "%{$officeName}%");
                        })
                        ->when($lokasiKantorYangDikunjungi, function ($query) use ($lokasiKantorYangDikunjungi) {
                        return $query->whereRaw('(SELECT to2.office_name FROM tb_entry te INNER JOIN tb_office to2 ON te.tb_office_id = to2.id WHERE te.no_card = tb_entry.no_card) LIKE ?', ["%{$lokasiKantorYangDikunjungi}%"]);
                        })

                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                        // ->toSql();
            // echo $SettingUsers;

        $totalFiltered = UserMcu::join('tb_office', 'tb_user_mcu.tb_office_id', '=', 'tb_office.id')
                        ->leftJoin('tb_entry', 'tb_user_mcu.tb_entry_id', '=', 'tb_entry.id')
                        ->select(
                            'tb_user_mcu.*',
                            'tb_entry.no_card',
                            'tb_office.office_name',
                            DB::raw('(SELECT to2.office_name FROM tb_entry te INNER JOIN tb_office to2 ON te.tb_office_id = to2.id WHERE te.no_card = tb_entry.no_card) AS lokasi_kantor_yg_dikunjungi')
                        )
                        ->when($noCard, function ($query) use ($noCard) {
                        return $query->where('tb_entry.no_card', 'LIKE', "%{$noCard}%");
                        })
                        ->when($usernameCard, function ($query) use ($usernameCard) {
                        return $query->where('tb_user_mcu.username_card', 'LIKE', "%{$usernameCard}%");
                        })
                        ->when($statusPekerja, function ($query) use ($statusPekerja) {
                        return $query->where('tb_user_mcu.status_pekerja', 'LIKE', "%{$statusPekerja}%");
                        })
                        ->when($statusUser, function ($query) use ($statusUser) {
                        return $query->where('tb_user_mcu.status_user', 'LIKE', "%{$statusUser}%");
                        })
                        ->when($officeName, function ($query) use ($officeName) {
                        return $query->where('tb_office.office_name', 'LIKE', "%{$officeName}%");
                        })
                        ->when($lokasiKantorYangDikunjungi, function ($query) use ($lokasiKantorYangDikunjungi) {
                        return $query->whereRaw('(SELECT to2.office_name FROM tb_entry te INNER JOIN tb_office to2 ON te.tb_office_id = to2.id WHERE te.no_card = tb_entry.no_card) LIKE ?', ["%{$lokasiKantorYangDikunjungi}%"]);
                        })
                        ->count();


        $data = array();
        if(!empty($SettingUsers))
        {
            foreach ($SettingUsers as $UserMcu)
            {
                $user_access =  route('admin.settinguser.edit',$UserMcu->id);

                if ($UserMcu->status_user == 0) {
                    $UserMcu->status_user = "<span class='badge bg-success mb-2' style='border-radius: 12px;'>Active</span>";
                } else {
                    $UserMcu->status_user = "<span class='badge bg-danger mb-2' style='border-radius: 12px;'>Not Active</span>";
                }

                $UserMcuId = $UserMcu->id;
                $UserName = $UserMcu->username_card;

                $nestedData['id'] = $UserMcu->id;
                $nestedData['no_card'] = $UserMcu->no_card;
                $nestedData['username_card'] = $UserMcu->username_card;
                $nestedData['status_pekerja'] = $UserMcu->status_pekerja;
                $nestedData['status_user'] = $UserMcu->status_user;
                $nestedData['office_name'] = $UserMcu->office_name;
                $nestedData['lokasi_kantor_yg_dikunjungi'] = $UserMcu->lokasi_kantor_yg_dikunjungi;
                
                // if else options for block user, if 0 show block user button else dont show
                if ($UserMcu->status_user == "<span class='badge bg-success mb-2' style='border-radius: 12px;'>Active</span>") {

                    $nestedData['options'] = "

                    <a data-user-id='$UserMcuId' data-user-name='$UserName' title='Block User' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalBlockUser' 
                    style='border-radius:12px; background-color:#FFA500; color:white;'><i class='bi bi-lock'></i></a>
                    <a href='{$user_access}' title='Settings' class='btn btn-sm mt-2' style='border-radius: 12px; background-color: #0000FF; color: white;'><i class='bi bi-wrench'></i></a>
                    
                    ";

                } else {
                    
                    $nestedData['options'] = "

                    <a data-user-id='$UserMcuId' data-user-name='$UserName' title='Unblock User' class='btn btn-sm mt-2' data-bs-toggle='modal' data-bs-target='#modalUnblockUser' 
                    style='border-radius:12px; background-color:#56B000; color:white;'><i class='bi bi-unlock'></i></a>
                    <a href='{$user_access}' title='Settings' class='btn btn-sm mt-2' style='border-radius: 12px; background-color: #0000FF; color: white;'><i class='bi bi-wrench'></i></a>
                    
                    ";
                    
                }
                
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

    // action for block user (update status user to 1)
    public function blockUser($id) {
        // find id user
        try {
            $user_mcu = UserMcu::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
        } catch (\Exception $e) {
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
        } catch (PDOException $e) {
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
        } catch (Throwable $e) {
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
        }   
        

        try {
            DB::beginTransaction();

            $user = DB::table('tb_user_mcu')
                    ->where('id', $id)
                    ->update([
                        'status_user' => 1
                    ]);

            DB::commit();
            
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');

        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');

        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal block user!');
            return redirect()->route('admin.settinguser.index');

        }   

        return redirect()->route('admin.settinguser.index')->with('success', 'User berhasil di block!');
    }

    // action for unblock user (update status user to 0)
    public function unblockUser($id) {
        // find id user
        try {
            $user_mcu = UserMcu::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
        } catch (\Exception $e) {
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
        } catch (PDOException $e) {
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
        } catch (Throwable $e) {
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
        }   
        

        try {
            DB::beginTransaction();

            $user = DB::table('tb_user_mcu')
                    ->where('id', $id)
                    ->update([
                        'status_user' => 0
                    ]);

            DB::commit();
            
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');

        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');

        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal unblock user!');
            return redirect()->route('admin.settinguser.index');

        }   

        return redirect()->route('admin.settinguser.index')->with('success', 'User berhasil di unblock!');
    }

    // edit akses user mcu
    public function edit($user_mcu_id) {
        try {
            $data = UserMcu::findOrFail($user_mcu_id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
        } 

        try {
            // for no_card
            $no_card = Card::select('no_card')
                        ->where('id', $data->tb_entry_id)
                        ->first();

            if ($no_card) {
            $data->no_card = $no_card->no_card;
            } else {
                $data->no_card = 'Silahkan Pilih No Card';
            }

        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');
            
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            Alert::error('Gagal masuk halaman edit user akses!');
            return redirect()->route('admin.settinguser.index');

        }

        return view('mazer_template.admin.form_setting_user.edit', compact('data'));
    }

    // action for update access user
    public function assignMcu(Request $request, $user_mcu_id) {
        try {
            $user_mcu = UserMcu::findOrFail($user_mcu_id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal menambahkan akses user!');
            return back();
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal menambahkan akses user!');
            return back();
        } catch (\Exception $e) {
            Alert::error('Gagal menambahkan akses user!');
            return back();
        } catch (PDOException $e) {
            Alert::error('Gagal menambahkan akses user!');
            return back();
        } catch (Throwable $e) {
            Alert::error('Gagal menambahkan akses user!');
            return back();
        }   
        

        try {
            DB::beginTransaction();

            // select tb_entry_id from User Mcu
            $tb_entry_id = DB::table('tb_user_mcu')
                            ->select('tb_entry_id')
                            ->where('id', $user_mcu_id)
                            ->first();
            
            // add data in tb_entry_mcu (contains tb_mcu_id and tb_entry_id)
            // from multiple select mcu
            $mcus = $request->mcu;

            foreach ($mcus as $mcu) {
                $entry_mcu = DB::table('tb_entry_mcu')
                        ->insert([
                            'tb_mcu_id' => $mcu,
                            'tb_entry_id' => $tb_entry_id->tb_entry_id
                        ]);
            }

            DB::commit();
            
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses user!');
            return back();
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses user!');
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses user!');
            return back();

        } catch (PDOException $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses user!');
            return back();

        } catch (Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal menambahkan akses user!');
            return back();

        }   

        return back()->with('success', 'User akses berhasil ditambahkan!');
    }

    // deleteMcu
    public function deleteMcu($tb_entry_id, $tb_mcu_id) {
         DB::table('tb_entry_mcu')
                ->where('tb_entry_id', $tb_entry_id)
                ->where('tb_mcu_id', $tb_mcu_id)
                ->delete();

        Alert::success('Sukses', 'Akses telah dihapus');
        return back();
    }

    public function select2Entry(Request $request, $officeId) {
        $search = $request->search;
        
        if($search) {
            $Cards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_entry.id', 'tb_entry.no_card', 'tb_office.office_name')
                        ->where('tb_entry.tb_office_id', $officeId)
                        ->where(function ($query) use ($search) {
                            $query->where('tb_entry.no_card', 'LIKE',"%{$search}%")
                            ->orWhere('tb_office.office_name', 'LIKE',"%{$search}%");
                        })
                        ->limit(100)
                        ->get();
        } else {
            $Cards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_entry.id', 'tb_entry.no_card', 'tb_office.office_name')
                        ->where('tb_entry.tb_office_id', $officeId)
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Cards as $Card){
                $response[] = array(
                    "id"=>$Card->id,
                    "text"=>$Card->no_card . ' - ' . $Card->office_name
                );
            }

        return response()->json($response);
    }

    public function select2EntryVisitor(Request $request, $officeId) {
        $search = $request->search;
        
        if($search) {
            $excludedIds = Office::where('id', $officeId)
                            ->pluck('id')
                            ->toArray();

            $Cards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                        ->select('tb_entry.id', 'tb_entry.no_card', 'tb_office.office_name')
                        ->whereNotIn('tb_entry.tb_office_id', $excludedIds)
                        ->where(function ($query) use ($search) {
                            $query->where('tb_entry.no_card', 'LIKE',"%{$search}%")
                            ->orWhere('tb_office.office_name', 'LIKE',"%{$search}%");
                        })
                        ->limit(100)
                        ->get();
        } else {
            $excludedIds = Office::where('id', $officeId)
                            ->pluck('id')
                            ->toArray();

            $Cards = Card::join('tb_office', 'tb_entry.tb_office_id', '=', 'tb_office.id')
                        ->whereNotIn('tb_entry.tb_office_id', $excludedIds)
                        ->select('tb_entry.id', 'tb_entry.no_card', 'tb_office.office_name')
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Cards as $Card){
                $response[] = array(
                    "id"=>$Card->id,
                    "text"=>$Card->no_card . ' - ' . $Card->office_name
                );
            }

        return response()->json($response);
    }

    // select2 card / entry
    public function select2EntryInSettingUser(Request $request) {
        $search = $request->search;

        if($search) {
            $Cards = DB::table('tb_entry as a')
                        ->select('a.id', 'a.no_card')
                        ->where('a.no_card', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $Cards = DB::table('tb_entry as a')
                        ->select('a.id', 'a.no_card')        
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($Cards as $Card){
                $response[] = array(
                    "id"=>$Card->id,
                    "text"=>$Card->no_card
                );
            }

        return response()->json($response);
    }

    // select2 username / username_card
    public function select2UsernameMcuInSettingUser(Request $request) {
        $search = $request->search;

        if($search) {
            $UsernameCards = DB::table('tb_user_mcu as a')
                        ->select('a.id', 'a.username_card')
                        ->where('a.username_card', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $UsernameCards = DB::table('tb_user_mcu as a')
                        ->select('a.id', 'a.username_card')        
                        ->limit(100)
                        ->get();
        }

        $response = array();
            foreach($UsernameCards as $UsernameCard){
                $response[] = array(
                    "id"=>$UsernameCard->id,
                    "text"=>$UsernameCard->username_card
                );
            }

        return response()->json($response);
    } 

    // select2 kantor / office
    public function select2KantorInSettingUser(Request $request) {
        $search = $request->search;

        if($search) {
            $Offices = DB::table('tb_office as a')
                        ->select('a.id', 'a.office_name')
                        ->distinct()
                        ->where('a.office_name', 'LIKE',"%{$search}%")
                        ->limit(100)
                        ->get();
        } else {
            $Offices = DB::table('tb_office as a')
                        ->select('a.id', 'a.office_name')  
                        ->distinct()
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


    public function update(Request $request, $id) {
       try {
            $UserMcu = UserMcu::findOrFail($id);
            
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.index');
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.index');
        } catch (\Exception $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.index');
        } catch (PDOException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.index');
        } catch (Throwable $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.index');
        }
        
        $messages = [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute harus diisi minimal :min karakter.',
            'max' => ':attribute harus diisi maksimal :max karakter.',
            'size' => ':attribute harus diisi tepat :size karakter.',
            'unique' => ':attribute sudah terpakai.',
        ];

        $validator = Validator::make($request->all(),[
            // 'tb_entry_id' => 'required',
            'status_pekerja' => 'required',
            'keperluan' => 'required',
        ],$messages);

        if($validator->fails()) {
            Alert::error('Cek kembali pengisian form, terima kasih !');
            return redirect()->route('admin.settinguser.edit',$id)->withErrors($validator->errors())->withInput();
        }

        try {
            UserMcu::where('id',$id)
                ->update([
                    'tb_entry_id' => $request->input('tb_entry_id'),
                    'status_pekerja' => $request->input('status_pekerja'),
                    'keperluan' => $request->input('keperluan'),
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.edit',$id);
        } catch (ModelNotFoundException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.edit',$id);
        } catch (\Exception $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.edit',$id);
        } catch (PDOException $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.edit',$id);
        } catch (Throwable $e) {
            Alert::error('Gagal settings user mcu!');
            return redirect()->route('admin.settinguser.edit',$id);
        }

        Alert::success('Sukses', 'Settings user mcu berhasil');
        return redirect()->route('admin.settinguser.index');

    }
    
}