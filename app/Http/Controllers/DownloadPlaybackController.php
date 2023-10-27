<?php

namespace App\Http\Controllers;

use App\Models\TbTid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        // convert $request->starthour_date & $request->endhour, from HH:MM to HH-MM
        $starthour_date = str_replace(':', '-', $request->starthour_date);
        $endhour = str_replace(':', '-', $request->endhour);

        try {
            $response = $client->request('POST', env('DOWNLOAD_CCTV_URL'), [
                'headers' => [
                'x-api-key' => 'YAHYAAJA',
                ],
                'form_params' => [
                    'tid' => $request->tid,
                    'folder_date' => $request->folder_date, // diisi YYYY-MM-DD
                    'starthour_date' => $starthour_date, // HH-MM
                    'endhour' => $endhour, // HH-MM

                ],
            ]);

            $download_playback_data = json_decode($response->getBody())->data;

            $total_data = count($download_playback_data);

            $download_playback = [];

            foreach ($download_playback_data as $data) {
                $filename = $data->filename;
                $url = $data->url;

                $combined_data = [
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

        // get request
        $tid = null;
        if ($request->has('tid_id')) {
            $tid = $request->tid;
        }

        $folder_date = null;
        if ($request->has('folder_date')) {
            $folder_date = $request->folder_date;
        }

        $starthour_date = null;
        if ($request->has('starthour_date')) {
            $starthour_date = $request->starthour_date;
        }

        $endhour = null;
        if ($request->has('endhour')) {
            $endhour = $request->endhour;
        }

        return view('mazer_template.admin.form_download_playback.index', [
            'download_playback' => $download_playback,
            'total_data' => $total_data,
            'tid' => $tid,
            'folder_date' => $folder_date,
            'starthour_date' => $starthour_date,
            'endhour' => $endhour,
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
                    "id"=> $tid->id,
                    "text"=> $tid->tid
                );
            }

        return response()->json($response);
    }

}