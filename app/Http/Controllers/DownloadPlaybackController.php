<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadPlaybackController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_download_playback.index');
    }
}
