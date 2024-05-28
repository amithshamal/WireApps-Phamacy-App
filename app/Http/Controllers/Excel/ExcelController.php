<?php

namespace App\Http\Controllers\Excel;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));

        return redirect('/')->with('success', 'All good!');
    }
}
