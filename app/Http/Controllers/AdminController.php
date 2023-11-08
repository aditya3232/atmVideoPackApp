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

class AdminController extends Controller
{
    public function index() {
        $client = new Client();
        
        try {
            $response = $client->request('POST', env('API_STATUS_MC_DETECTION_UP_OR_DOWN_URL'), [
                    'headers' => [
                    'x-api-key' => 'YAHYAAJA',
                    ],
                ]);
                
            $get_device_up_and_down = json_decode($response->getBody())->data;

            // Initialize counters
            $offlineCount = 0;
            $onlineCount = 0;

            // Loop through the data and count status_mc values
            foreach ($get_device_up_and_down as $item) {
                $status_mc = $item->status_mc;
                if ($status_mc === "offline") {
                    $offlineCount++;
                } elseif ($status_mc === "online") {
                    $onlineCount++;
                }
            }

            return view('mazer_template.admin.home.home', [
                'offlineCount' => $offlineCount,
                'onlineCount' => $onlineCount,
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('QueryException !');
            return redirect()->route('500');
            // i want return view with no data
            // return view('mazer_template.admin.home.home');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Modul Not Found Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Data not found !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('PDO Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Throwable !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');
            
        }

    }

    // data json deviceUpDown (buat chart)
    public function getDataDeviceUpAndDown(){
        $client = new Client();
        
        try {
            $response = $client->request('POST', env('API_STATUS_MC_DETECTION_UP_OR_DOWN_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
            ]);
                
            $get_device_up_and_down = json_decode($response->getBody())->data;

            // Initialize counters
            $offlineCount = 0;
            $onlineCount = 0;

            // Loop through the data and count status_mc values
            foreach ($get_device_up_and_down as $item) {
                $status_mc = $item->status_mc;
                if ($status_mc === "offline") {
                    $offlineCount++;
                } elseif ($status_mc === "online") {
                    $onlineCount++;
                }
            }

            return response()->json([
                'offlineCount' => $offlineCount,
                'onlineCount' => $onlineCount,
            ]);
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('QueryException !');
            return redirect()->return('500');
            // i want return view with no data
            // return view('mazer_template.admin.home.home');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Modul Not Found Exception !');
            return redirect()->return('500');
            // return view('mazer_template.admin.home.home');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Data not found !');
            return redirect()->return('500');
            // return view('mazer_template.admin.home.home');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('PDO Exception !');
            return redirect()->return('500');
            // return view('mazer_template.admin.home.home');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Throwable !');
            return redirect()->return('500');
            // return view('mazer_template.admin.home.home');
            
        }

    }

    public function getDatatablesDeviceDown(){
        $client = new Client();
       
        try {
            $response = $client->request('POST', env('API_STATUS_MC_DETECTION_UP_OR_DOWN_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
            ]);
                
            $get_device_down = json_decode($response->getBody())->data;

            $device_down = [];

            foreach ($get_device_down as $data) {
                
                $tid = $data->tid;
                $date_time = $data->date_time;
                $status_signal = $data->status_signal;
                $status_storage = $data->status_storage;
                $status_ram = $data->status_ram;
                $status_cpu = $data->status_cpu;

                // skip when status_mc is online
                if($data->status_mc == "online" || $data->status_mc == null){
                    continue;
                }

                $status_mc = $data->status_mc;

                $combined_data = [
                    'tid' => $tid,
                    'date_time' => $date_time,
                    'status_signal' => $status_signal,
                    'status_storage' => $status_storage,
                    'status_ram' => $status_ram,
                    'status_cpu' => $status_cpu,
                    'status_mc' => $status_mc,
                ];

                $device_down[] = $combined_data;

            }

            return view('mazer_template.admin.home.device-down', [
                'device_down' => $device_down,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('QueryException !');
            return redirect()->route('500');
            // i want return view with no data
            // return view('mazer_template.admin.home.home');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Modul Not Found Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Data not found !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('PDO Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Throwable !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');
            
        }
        
    }

    public function getDatatablesDeviceUp(){
        $client = new Client();
        
        try {
            $response = $client->request('POST', env('API_STATUS_MC_DETECTION_UP_OR_DOWN_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
            ]);
                
            $get_device_up = json_decode($response->getBody())->data;

            $device_up = [];

            foreach ($get_device_up as $data) {
                
                $tid = $data->tid;
                $date_time = $data->date_time;
                $status_signal = $data->status_signal;
                $status_storage = $data->status_storage;
                $status_ram = $data->status_ram;
                $status_cpu = $data->status_cpu;

                // skip when status_mc is offline
                if($data->status_mc == "offline" || $data->status_mc == null){
                    continue;
                }

                $status_mc = $data->status_mc;

                $combined_data = [
                    'tid' => $tid,
                    'date_time' => $date_time,
                    'status_signal' => $status_signal,
                    'status_storage' => $status_storage,
                    'status_ram' => $status_ram,
                    'status_cpu' => $status_cpu,
                    'status_mc' => $status_mc,
                ];

                $device_up[] = $combined_data;

            }

            return view('mazer_template.admin.home.device-up', [
                'device_up' => $device_up,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('QueryException !');
            return redirect()->route('500');
            // i want return view with no data
            // return view('mazer_template.admin.home.home');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Modul Not Found Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Data not found !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('PDO Exception !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Throwable !');
            return redirect()->route('500');
            // return view('mazer_template.admin.home.home');
            
        }
    }


}