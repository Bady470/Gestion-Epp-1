<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\EppImport;
use Maatwebsite\Excel\Facades\Excel;


class EppImportController extends Controller
{
public function import(Request $request)
{
    $request->validate([
        'excel' => 'required|mimes:xlsx'
    ]);

    Excel::import(new EppImport, $request->file('excel'));

    return redirect()->back()->with('success', 'Archivo importado correctamente.');
}



}