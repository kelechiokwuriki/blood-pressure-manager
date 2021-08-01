<?php

namespace App\Exports;

use App\Observation;
use Maatwebsite\Excel\Concerns\FromCollection;

class ObservationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Observation::all();
    }
}
