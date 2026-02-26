<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ProgramasImport;
use Maatwebsite\Excel\Facades\Excel;

class ProgramaImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProgramasImport, $request->file('file'));

        return response()->json(['message' => 'Programas importados correctamente']);
    }
}
