<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HumanDetectionController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_human_detection.index');
    }
}