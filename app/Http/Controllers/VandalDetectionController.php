<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VandalDetectionController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_vandal_detection.index');
    }
}
