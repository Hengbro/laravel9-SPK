<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use PDF;
use Carbon\Carbon;

class AlgoritmaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    private function getPeriode()
{
    return Penilaian::select('periode')->distinct()->get();
}

    public function index()
    {
        $periode = $this->getPeriode();
        return view('admin.perhitungan.index', compact('periode'));
    }

    public function filter(Request $request)
{
    $selectedPeriode = $request->input('periode');

    // Jika periode tidak dipilih, redirect ke pemilihan periode
    if (!$selectedPeriode) {
        return redirect()->route('perhitungan.index');
    }

    // Mengambil data berdasarkan periode yang dipilih
    $penilaian = Penilaian::with('crips', 'alternatif')
        ->where('periode', $selectedPeriode)
        ->get();

    // Mengambil alternatif berdasarkan periode yang dipilih
    $alternatif = Alternatif::with(['penilaian' => function ($query) use ($selectedPeriode) {
        $query->where('periode', $selectedPeriode);
    }, 'penilaian.crips'])->get();

    $kriteria = Kriteria::with(['penilaian' => function ($query) use ($selectedPeriode) {
        $query->where('periode', $selectedPeriode);
    }, 'penilaian.crips'])->get();

    // Jika tidak ada penilaian untuk periode yang dipilih
    if ($penilaian->isEmpty()) {
        return back()->with('msg', 'Tidak ada data untuk periode yang dipilih.');
    }

    // Ambil semua periode agar dapat digunakan di tampilan
    $periode = Penilaian::select('periode')->distinct()->get();

    // Fuzzy Normalisasi
    $fuzzyNormalisasi = [];
    $detailPerhitungan = [];

    foreach ($kriteria as $kriteriaItem) {
        foreach ($penilaian as $penilaianItem) {
            // Pastikan nilai yang diambil sesuai dengan kriteria saat ini
            if ($penilaianItem->kriteria_id == $kriteriaItem->id) {
                $nilai = $penilaianItem->nilai; // Ambil nilai yang sesuai dengan kriteria dan alternatif
                $batasBawah = 60;
                $batasAtas = 80;
                $hasil = ($nilai - $batasBawah) / ($batasAtas - $batasBawah);
                
                // Simpan hasil perhitungan
                $fuzzyNormalisasi[$penilaianItem->alternatif->nama_alternatif][$kriteriaItem->id] = $hasil;
                
                // Simpan detail perhitungan
                $detailPerhitungan[$penilaianItem->alternatif->nama_alternatif][$kriteriaItem->id] = "($nilai - $batasBawah) / ($batasAtas - $batasBawah) = $hasil";
            }
        }
    }

    // Normalisasi Tahap Kedua
    $normalisasiTahapDua = [];
    $detailPerhitunganTahapDua = [];

    foreach ($kriteria as $kriteriaItem) {
        foreach ($penilaian as $penilaianItem) {
            // Pastikan nilai yang diambil sesuai dengan kriteria saat ini
            if ($penilaianItem->kriteria_id == $kriteriaItem->id) {
                $alternatifName = $penilaianItem->alternatif->nama_alternatif;

                // Ambil nilai yang sesuai dengan kriteria dan alternatif
                $nilai = $penilaianItem->nilai; 
                $batasBawah = 60;
                $batasAtas = 80;
                $fuzzyNormalisasiValue = ($nilai - $batasBawah) / ($batasAtas - $batasBawah);
                
                // Cari nilai maksimum per alternatif dan kriteria di dalam $fuzzyNormalisasi
                $maxFuzzy = max($fuzzyNormalisasi[$alternatifName]);
                $hasilNormalisasi = bcdiv((string) $fuzzyNormalisasiValue, (string) $maxFuzzy, 16);

                $normalisasiTahapDua[$alternatifName][$kriteriaItem->id] = number_format($hasilNormalisasi, 2);
                $detailPerhitunganTahapDua[$alternatifName][$kriteriaItem->id] = 
                    "$fuzzyNormalisasiValue / $maxFuzzy = " . number_format($hasilNormalisasi, 4);
            }
        }
    }

    // Normalisasi Tahap Ketiga
    $normalisasiTahapTiga = [];
    $detailPerhitunganTahapTiga = [];
    $total = 0;

    foreach ($kriteria as $key => $value) {
        foreach ($normalisasiTahapDua as $namaAlternatif => $hasil) {
            // Mengakses nilai yang tepat dari $hasil berdasarkan $value['id']
            if (isset($hasil[$value['id']])) {
                $nilaiNormalisasi = $hasil[$value['id']];
                $bobot = $value['bobot'] / 100;

                // Menggunakan bcmul untuk hasil perhitungan dengan presisi tinggi
                $hasilNormalisasi = bcmul((string) $bobot, (string) $nilaiNormalisasi, 16);

                // Simpan hasil normalisasi tahap ketiga
                $normalisasiTahapTiga[$namaAlternatif][$value['id']] = $hasilNormalisasi;

                // Simpan detail perhitungan
                $detailPerhitunganTahapTiga[$namaAlternatif][$value['id']] = 
                    "(" . number_format($bobot, 2) . " * " . number_format($nilaiNormalisasi, 2) . ") = " . number_format($hasilNormalisasi, 4);
            }
        }
    }

    return view('admin.perhitungan.index', compact('alternatif', 'kriteria', 'fuzzyNormalisasi', 'detailPerhitungan', 'normalisasiTahapDua', 'detailPerhitunganTahapDua', 'normalisasiTahapTiga', 'detailPerhitunganTahapTiga', 'penilaian', 'selectedPeriode', 'periode'));
}

    

public function downloadPDF(Request $request) 
{
    Carbon::setLocale('id');
    $selectedPeriode = $request->input('periode');

    // Jika periode tidak dipilih, redirect ke pemilihan periode
    if (!$selectedPeriode) {
        return redirect()->route('perhitungan.index');
    }

    // Mengambil data berdasarkan periode yang dipilih
    $penilaian = Penilaian::with('crips', 'alternatif')
        ->where('periode', $selectedPeriode)
        ->get();

    // Mengambil alternatif berdasarkan periode yang dipilih
    $alternatif = Alternatif::with(['penilaian' => function ($query) use ($selectedPeriode) {
        $query->where('periode', $selectedPeriode);
    }, 'penilaian.crips'])->get();

    $kriteria = Kriteria::with(['penilaian' => function ($query) use ($selectedPeriode) {
        $query->where('periode', $selectedPeriode);
    }, 'penilaian.crips'])->get();

    // Jika tidak ada penilaian untuk periode yang dipilih
    if ($penilaian->isEmpty()) {
        return back()->with('msg', 'Tidak ada data untuk periode yang dipilih.');
    }

    if (count($penilaian) == 0) {
        return redirect(route('penilaian.index'));
    }

    // Proses Fuzzy dan Normalisasi
    $minMax = [];
    foreach ($kriteria as $key => $value) {
        foreach ($penilaian as $key_1 => $value_1) {
            if ($value->id == $value_1->kriteria_id) {
                if ($value->attribut == 'Benefit' || $value->attribut == 'Cost') {
                    $minMax[$value->id][] = $value_1->nilai;
                }
            }
        }
    }

    // Proses Fuzzy dan Normalisasi Tahap 1 dan 2
    $fuzzyNormalisasi = [];
    $detailPerhitungan = [];
    foreach ($kriteria as $kriteriaItem) {
        foreach ($penilaian as $penilaianItem) {
            if ($penilaianItem->kriteria_id == $kriteriaItem->id) {
                $nilai = $penilaianItem->nilai;
                $batasBawah = 60;
                $batasAtas = 80;
                $hasil = ($nilai - $batasBawah) / ($batasAtas - $batasBawah);
                $fuzzyNormalisasi[$penilaianItem->alternatif->nama_alternatif][$kriteriaItem->id] = $hasil;
                $detailPerhitungan[$penilaianItem->alternatif->nama_alternatif][$kriteriaItem->id] = "($nilai - $batasBawah) / ($batasAtas - $batasBawah) = $hasil";
            }
        }
    }

    $normalisasiTahapDua = [];
    $detailPerhitunganTahapDua = [];
    foreach ($kriteria as $kriteriaItem) {
        foreach ($penilaian as $penilaianItem) {
            if ($penilaianItem->kriteria_id == $kriteriaItem->id) {
                $alternatifName = $penilaianItem->alternatif->nama_alternatif;
                $nilai = $penilaianItem->nilai; 
                $fuzzyNormalisasiValue = ($nilai - 60) / (80 - 60);
                $maxFuzzy = max($fuzzyNormalisasi[$alternatifName]);
                $hasilNormalisasi = $fuzzyNormalisasiValue / $maxFuzzy;

                $normalisasiTahapDua[$alternatifName][$kriteriaItem->id] = $hasilNormalisasi;
                $detailPerhitunganTahapDua[$alternatifName][$kriteriaItem->id] = 
                    "$fuzzyNormalisasiValue / $maxFuzzy = " . number_format($hasilNormalisasi, 4);
            }
        }
    }

    // Normalisasi Tahap Ketiga
    $normalisasiTahapTiga = [];
    $detailPerhitunganTahapTiga = [];
    $total = 0;

    foreach ($kriteria as $key => $value) {
        foreach ($normalisasiTahapDua as $namaAlternatif => $hasil) {
            // Mengakses nilai yang tepat dari $hasil berdasarkan $value['id']
            if (isset($hasil[$value['id']])) {
                $nilaiNormalisasi = $hasil[$value['id']];
                $bobot = $value['bobot'] / 100;

                // Menggunakan bcmul untuk hasil perhitungan dengan presisi tinggi
                $hasilNormalisasi = bcmul((string) $bobot, (string) $nilaiNormalisasi, 16);

                // Simpan hasil normalisasi tahap ketiga
                $normalisasiTahapTiga[$namaAlternatif][$value['id']] = $hasilNormalisasi;

                // Simpan detail perhitungan
                $detailPerhitunganTahapTiga[$namaAlternatif][$value['id']] = 
                    "(" . number_format($bobot, 2) . " * " . number_format($nilaiNormalisasi, 2) . ") = " . number_format($hasilNormalisasi, 4);
            }
        }
    }

    // PDF Generation
    $pdf = PDF::loadView('admin.perhitungan.perhitungan-pdf', compact(
        'alternatif', 'kriteria', 'fuzzyNormalisasi', 
        'normalisasiTahapDua', 'detailPerhitungan', 'normalisasiTahapTiga', 'detailPerhitunganTahapTiga',
        'selectedPeriode'
    ));
    $pdf->setPaper('A3', 'potrait');
    return $pdf->stream('perhitungan.pdf');
}

}
