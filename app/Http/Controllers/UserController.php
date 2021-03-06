<?php

namespace App\Http\Controllers;

use App\Exports\ObservationsExport;
use App\Exports\StaffExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function show($userId)
    {
        return view('singlepatient')->with(['id' => $userId]);
    }

    public function exportObservation($type)
    {
        return Excel::download(new ObservationsExport, 'observations.'.$type);
    }

    public function exportStaffs($type)
    {
        return Excel::download(new StaffExport, 'staffs.'.$type);
    }
}
