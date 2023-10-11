<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamingCctvController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_streaming_cctv.index');
    }
}
