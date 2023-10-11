<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KcSupervisiController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_kc_supervisi.index');
    }
}
