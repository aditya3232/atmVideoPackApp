<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_device.index');
    }
}
