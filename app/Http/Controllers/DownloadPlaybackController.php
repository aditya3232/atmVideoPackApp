<?php

namespace App\Http\Controllers;

use App\Models\TbTid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDOException;
use Throwable;
use GuzzleHttp\Client;

class DownloadPlaybackController extends Controller
{
    //index
    public function index(Request $request)
    {
        $client = new Client();

        // format $request->start_date_time from this '2023-10-23T21:34' to this '2023-10-23 21:34:00'
        $start_date_time = $request->start_date_time;
        $end_date_time = $request->end_date_time;

        if ($start_date_time !== null) {
            $formattedStartDateTime = SupportCarbon::createFromFormat('Y-m-d\TH:i', $start_date_time)->format('Y-m-d H:i:s');
        } else {
            $formattedStartDateTime = null;
        }

        if ($end_date_time !== null) {
            $formattedEndDateTime = SupportCarbon::createFromFormat('Y-m-d\TH:i', $end_date_time)->format('Y-m-d H:i:s');
        } else {
            $formattedEndDateTime = null;
        }

        try {
            $response = $client->request('POST', env('API_DOWNLOAD_PLAYBACK_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
                'form_params' => [
                    'tid' => $request->tid,
                    'date_time' => $request->date_time,
                    'start_date' => $formattedStartDateTime,
                    'end_date' => $formattedEndDateTime,

                ],
            ]);

            $download_playback_data = json_decode($response->getBody())->data;

            $total_data = count($download_playback_data);

            $download_playback = [];

            foreach ($download_playback_data as $data) {
                $tid = $data->tid;
                $date_modified = $data->date_modified;
                $duration_minutes = $data->duration_minutes;
                $file_size_bytes = $data->file_size_bytes;
                $filename = $data->filename;
                $url = $data->url;

                $combined_data = [
                    'tid' => $tid,
                    'date_modified' => $date_modified,
                    'duration_minutes' => $duration_minutes,
                    'file_size_bytes' => $file_size_bytes,
                    'filename' => $filename,
                    'url' => $url,
                ];

                $download_playback[] = $combined_data;

            }

        } catch (\Illuminate\Database\QueryException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('QueryException !');
            // return redirect()->route('admin.index');
            // i want return view with no data
            return view('mazer_template.admin.form_download_playback.index');
        
        } catch (ModelNotFoundException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Modul Not Found Exception !');
            // return redirect()->route('admin.index');
            return view('mazer_template.admin.form_download_playback.index');

        } catch (\Exception $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Data not found !');
            // return redirect()->route('admin.index');
            return view('mazer_template.admin.form_download_playback.index');

        } catch (PDOException $e) {
            // Alert::error($e->getMessage());
            // Alert::error('PDO Exception !');
            // return redirect()->route('admin.index');
            return view('mazer_template.admin.form_download_playback.index');

        } catch (Throwable $e) {
            // Alert::error($e->getMessage());
            // Alert::error('Throwable !');
            // return redirect()->route('admin.index');
            return view('mazer_template.admin.form_download_playback.index');
            
        }

        return view('mazer_template.admin.form_download_playback.index', [
            'download_playback' => $download_playback,
            'tid' => $request->tid,
            'start_date_time' => $formattedStartDateTime,
            'end_date_time' => $formattedEndDateTime,
        ]);
    }

    public function select2Tid(Request $request) {
        $search = $request->search;

        if($search) {
            $tids = TbTid::select('id', 'tid')
                            ->where('tid', 'LIKE', "%{$search}%")
                            ->limit(100)
                            ->get();
        } else {
            $tids = TbTid::select('id', 'tid')
                            ->limit(100)
                            ->get();
        }

        $response = array();
            foreach($tids as $tid){
                $response[] = array(
                    "id"=> $tid->tid,
                    "text"=> $tid->tid
                );
            }

        return response()->json($response);
    }

}