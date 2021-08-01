<?php

namespace App\Exports;

use App\user;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StaffExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role', 'admin')->orWhere('role', 'doctor')->orWhere('role', 'nurse')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Role',
            'Created date',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->role,
            Carbon::parse($user->created_at)->toDateTimeString(),
        ];
    }
}
