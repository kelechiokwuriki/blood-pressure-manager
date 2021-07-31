<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffAreaController extends Controller
{
    public function showStaffArea()
    {
        return view('staffarea');
    }
}
