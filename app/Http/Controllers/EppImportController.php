<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\EppImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class EppImportController extends Controller
{

public function import(Request $request)
{
    $request->validate([
        'excel' => 'required|mimes:xlsx'
    ]);

    try {
        Excel::import(new EppImport, $request->file('excel'));

        return back()->with('success', 'Archivo importado correctamente.');

    } catch (ValidationException $e) {

        $failures = $e->failures();

        return back()->with('error',
            'El archivo contiene filas con errores. Verifique que el campo nombre no esté vacío.'
        );
    }
}




}
