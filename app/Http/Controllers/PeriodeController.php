<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'tahun' => 'required|string',
        'bulan' => 'required|string',
    ]);

    $periode = $request->tahun . '-' . $request->bulan;
    $label = $request->tahun . ' ' . $request->bulan;

    // Simpan data periode ke database
    $periodeRecord = Periode::create([
        'periode' => $periode,
        'label' => $label,
        'tahun' => $request->tahun, 
        'bulan' => $request->bulan
    ]);

    return response()->json($periodeRecord, 201);
}

    public function index()
    {
        $periodes = Periode::all();
        return response()->json($periodes);
    }
}
