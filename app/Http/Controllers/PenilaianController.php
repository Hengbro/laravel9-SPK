<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Crips;
use Carbon\Carbon;
use DB;
use PDF;



class PenilaianController extends Controller
{
    // public function index(){
    //     $alternatif = Alternatif::with('penilaian.crips')->get();
      
    //     $kriteria = Kriteria::with('crips')->get();
    //     //return response()->json($alternatif);
    //     return view('admin.penilaian.index', compact('alternatif','kriteria'));
    // }

    public function index()
{
    // Mengambil semua nilai periode yang unik dari tabel Penilaian
    $periode = Penilaian::select('periode')->distinct()->get();
    
    $alternatif = Alternatif::with('penilaian.crips')->get();
    $kriteria = Kriteria::with('crips')->get();
    
    // Mengirim data periode ke view
    return view('admin.penilaian.index', compact('alternatif', 'kriteria', 'periode'));
}


public function store(Request $request)
{
    try {
        $bulan = $request->input('bulan'); // Ambil bulan dari input form
        $tahun = $request->input('tahun');
        $periode = $bulan . '-' . $tahun;

        // Jangan gunakan TRUNCATE jika ingin menambah data tanpa menghapus data sebelumnya
        // DB::select("TRUNCATE penilaian");

        foreach ($request->crips_id as $key => $value) {
            foreach ($value as $key_1 => $value_1) {
                Penilaian::create([
                    'alternatif_id' => $key,
                    'nilai' => $value_1['kriteria_value'],
                    'kriteria_id' => $value_1['kriteria_id'],
                    'periode' => $periode
                ]);
            }
        }

        return back()->with('msg', 'Berhasil Disimpan!');
    } catch (Exception $e) {
        \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        die("Gagal");
    }
}


public function downloadPDF() {
    setlocale(LC_ALL, 'IND');
    $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');
    $periode = Penilaian::select('periode')->distinct()->get();
    $alternatif = Alternatif::with('penilaian.crips')->get();
    $kriteria = Kriteria::with('crips')->get();
    
    // Mengelompokkan data penilaian berdasarkan periode
    $penilaian = Penilaian::with('crips', 'alternatif')->get()->groupBy('periode');

    $pdf = PDF::loadView('admin.penilaian.penilaian-pdf', compact('kriteria', 'tanggal', 'alternatif', 'penilaian', 'periode'));
    $pdf->setPaper('A3', 'potrait');
    return $pdf->stream('penilaian.pdf');
}


}
