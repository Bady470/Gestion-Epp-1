<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\FichasImport;
use Maatwebsite\Excel\Facades\Excel;

class FichaImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new FichasImport, $request->file('file'));

        return response()->json(['message' => 'Fichas importadas correctamente']);
    }
}
