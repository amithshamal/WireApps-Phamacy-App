<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public function collection()
    {
        return User::all()->select('name', 'username');;
    }

    public function headings(): array
    {
        return ['Name', 'User Name']; // Specify the column headings
    }
}

