<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CctvController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_cctv.index');
    }
}
