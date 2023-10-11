<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    //index
    public function index()
    {
        return view('mazer_template.admin.form_branch.index');
    }
}
