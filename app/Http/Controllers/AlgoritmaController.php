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

    public function index()
    {
       
        $alternatif = Alternatif::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->get();
        // $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria','ASC')->get();
        $penilaian = Penilaian::with('crips','alternatif')->get();
         if (count($penilaian) == 0) {
             return redirect(route('penilaian.index'));
         }
        
        //mencari min max normalisasi
        $minMax = [];
foreach ($kriteria as $key => $value) {
    foreach ($penilaian as $key_1 => $value_1) {
        if ($value->id == $value_1->kriteria_id) {
            $minMax[$value->id][] = $value_1->nilai;
        }
    }
}

$fuzzyNormalisasi = [];
$detailPerhitungan = [];

// Proses Fuzzy
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



$normalisasiTahapDua = [];
$detailPerhitunganTahapDua = [];

// Proses Normalisasi Tahap Kedua
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
            
            // Hitung hasil normalisasi dengan maxFuzzy berdasarkan alternatif tersebut
            $hasilNormalisasi = $fuzzyNormalisasiValue / $maxFuzzy;

            // Simpan hasil normalisasi tahap kedua
            $normalisasiTahapDua[$alternatifName][$kriteriaItem->id] = $hasilNormalisasi;

            // Simpan detail perhitungan dengan hasil yang diformat ke 4 angka desimal
            $detailPerhitunganTahapDua[$alternatifName][$kriteriaItem->id] = 
                "$fuzzyNormalisasiValue / $maxFuzzy = " . number_format($hasilNormalisasi, 4);
        }
    }
}



// 𝑉3 = (0,30 ∗ 0.61) + (0,10 ∗ 0,38) + (0,15 ∗ 0.38) + (0,20 ∗ 1) + (0,10 ∗ 1) + (0,15
// ∗ 0,67)

$normalisasiTahapTiga = [];
    $detailPerhitunganTahapTiga = [];
    $total = 0;

    foreach ($kriteria as $key => $value) {
        foreach ($normalisasiTahapDua as $namaAlternatif => $hasil) {
            // Mengakses nilai yang tepat dari $hasil berdasarkan $value['id']
            if (isset($hasil[$value['id']])) {
                $nilaiNormalisasi = $hasil[$value['id']];
                $bobot = $value['bobot'] / 100;
                $hasilNormalisasi = $bobot * $nilaiNormalisasi;
                
                // Simpan hasil normalisasi tahap ketiga
                $normalisasiTahapTiga[$namaAlternatif][$value['id']] = number_format($hasilNormalisasi, 4);
                
                // Simpan detail perhitungan
                $detailPerhitunganTahapTiga[$namaAlternatif][$value['id']] = 
                   "(" . number_format($bobot, 2) . " * " . number_format($nilaiNormalisasi, 4) . ") = " . number_format($hasilNormalisasi, 4);
            }
        }
    }


// Perhitungan Fuzzy Tsukamoto dengan Detail
// Perhitungan Fuzzy Tsukamoto dengan Detail
$fuzzyValues = [];
$fuzzyDetails = []; // Menyimpan detail perhitungan untuk setiap alternatif

foreach ($alternatif as $alt => $valt) {
    $penilaianAlternatif = $valt->penilaian; 
    $fuzzyValues[$valt->nama_alternatif] = ['hasil' => 0, 'detail' => ''];
    $fuzzyDetails[$valt->nama_alternatif] = []; 

    $rules = [];
    foreach ($penilaianAlternatif as $nilaiKriteria) {
        $nilai = $nilaiKriteria->nilai;

        $low = 0;
        $medium = 0;
        $high = 0;

        // Proses penentuan derajat keanggotaan
if ($nilai <= 60) {
    $low = 1;
    $fuzzyDetails[$valt->nama_alternatif][] = number_format($low, 2);
} elseif ($nilai > 60 && $nilai <= 80) {
    $low = (80 - $nilai) / 20;
    $medium = ($nilai - 60) / 20;
    $fuzzyDetails[$valt->nama_alternatif][] = number_format($low, 2) . ", " . number_format($medium, 2);
} elseif ($nilai > 80 && $nilai <= 100) {
    $medium = (100 - $nilai) / 20;
    $high = ($nilai - 80) / 20;
    $fuzzyDetails[$valt->nama_alternatif][] = number_format($medium, 2) . ", " . number_format($high, 2);
}


        $rules[] = [
            'low' => $low,
            'medium' => $medium,
            'high' => $high,
            'nilai' => $nilai, 
        ];
    }

    // Defuzzifikasi
    $numerator = 0;
    $denominator = 0;
    foreach ($rules as $rule) {
        $nilaiCrisp = $rule['nilai'];

        // Menambahkan hasil perkalian derajat keanggotaan dengan nilai crisp ke numerator
        $numerator += $rule['low'] * $nilaiCrisp + $rule['medium'] * $nilaiCrisp + $rule['high'] * $nilaiCrisp;
        $denominator += $rule['low'] + $rule['medium'] + $rule['high'];
    }

    // Tambahkan detail perhitungan numerator dan denominator
    $fuzzyValues[$valt->nama_alternatif]['detail'] = implode(' + ', array_map(function($rule) {
        return "({$rule['low']}*{$rule['nilai']}) + ({$rule['medium']}*{$rule['nilai']}) + ({$rule['high']}*{$rule['nilai']})";
    }, $rules)) . " = " .  number_format($numerator , 2) . "\n"  . implode(' + ', array_map(function($rule) {
        return "({$rule['low']} + {$rule['medium']} + {$rule['high']})";
    }, $rules)) . ")" . " = " .  number_format($denominator, 2);

    // Hitung hasil akhir defuzzifikasi jika denominator > 0
    if ($denominator > 0) {
        $hasilDefuzzifikasi = $numerator / $denominator;
        $fuzzyValues[$valt->nama_alternatif]['hasil'] = $hasilDefuzzifikasi;

        // Tampilkan hasil pembagian
        $fuzzyValues[$valt->nama_alternatif]['detail'] .= "\n Hasil Defuzzifikasi: " . number_format($numerator, 2) . " / " . number_format($denominator, 2) . " = "  . number_format($hasilDefuzzifikasi, 2)  ;
    } else {
        $fuzzyValues[$valt->nama_alternatif]['hasil'] = 0;
    }
}

        
        // dd( $fuzzyNormalisasi, $normalisasiTahapDua, json_encode($normalisasiTahapTiga));
        return view('admin.perhitungan.index', compact('alternatif','kriteria','fuzzyNormalisasi','detailPerhitungan', 'normalisasiTahapDua', 'detailPerhitunganTahapDua', 'normalisasiTahapTiga', 'detailPerhitunganTahapTiga', 'fuzzyValues','fuzzyDetails'));
       
    }

    public function downloadPDF() {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');
        $alternatif = Alternatif::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->get();
        $penilaian = Penilaian::with('crips','alternatif')->get();


        if (count($penilaian) == 0) {
            return redirect(route('penilaian.index'));
        }
        //mencari min max normalisasi
        foreach ($kriteria as $key => $value) {
            foreach ($penilaian as $key_1 => $value_1) {
                if ($value->id == $value_1->kriteria_id)
                {
                    if ($value->attribut == 'Benefit') {
                        $minMax[$value->id][] = $value_1->nilai;
                    }elseif ($value->attribut == 'Cost') {
                        $minMax[$value->id][] = $value_1->nilai;
                    }
                }
            }
        }

        // Proses Fuzzy 
$fuzzyNormalisasi = [];
foreach ($penilaian as $key_1 => $value_1) {
    $fuzzyNormalisasi[$value_1->alternatif->nama_alternatif][$value->id] = ($value_1->nilai - 60) / (80-60);

}

// Proses Normalisasi
$normalisasiTahapDua = [];
foreach ($kriteria as $key => $value) {
    foreach ($penilaian as $key_1 => $value_1) {
        $maxFuzzy = max(array_map('max', $fuzzyNormalisasi));
        $normalisasiTahapDua[$value_1->alternatif->nama_alternatif][$value->id] = ($value_1->nilai - 60) / (80-60) / $maxFuzzy;

    }
}

// 𝑉3 = (0,30 ∗ 0.61) + (0,10 ∗ 0,38) + (0,15 ∗ 0.38) + (0,20 ∗ 1) + (0,10 ∗ 1) + (0,15
// ∗ 0,67)

// Proses Normalisasi tahap 3
$normalisasiTahapTiga = [];
$total = 0;
foreach ($kriteria as $key => $value) {
    foreach ($normalisasiTahapDua as $namaAlternatif => $hasil) {
        // Mengakses nilai yang tepat dari $hasil berdasarkan $value['id']
        if (isset($hasil[$value['id']])) {
            $nilaiNormalisasi = $hasil[$value['id']];
            // Hitung normalisasi tahap tiga menggunakan bobot dari $value
            $normalisasiTahapTiga[$namaAlternatif][$value['id']] = 
                number_format(($value['bobot'] / 100) * $nilaiNormalisasi, 4);
        }
    }
}


        /// Perhitungan Fuzzy Tsukamoto
// Perhitungan Fuzzy Tsukamoto dengan Detail
$fuzzyValues = [];
$fuzzyDetails = []; // Menyimpan detail perhitungan untuk setiap alternatif

foreach ($alternatif as $alt => $valt) {
    $penilaianAlternatif = $valt->penilaian; 
    $fuzzyValues[$valt->nama_alternatif] = 0;
    $fuzzyDetails[$valt->nama_alternatif] = []; 

    $rules = [];
    foreach ($penilaianAlternatif as $nilaiKriteria) {
        $nilai = $nilaiKriteria->nilai;

        $low = 0;
        $medium = 0;
        $high = 0;

        if ($nilai <= 60) {
            $low = 1;
            $fuzzyDetails[$valt->nama_alternatif][] = "Nilai $nilai dianggap sepenuhnya LOW (derajat keanggotaan = 1)";
        } elseif ($nilai > 60 && $nilai <= 80) {
            $low = (80 - $nilai) / 20;
            $medium = ($nilai - 60) / 20;
            $fuzzyDetails[$valt->nama_alternatif][] = "Nilai $nilai memiliki derajat keanggotaan LOW = " . number_format($low, 2) . ", MEDIUM = " . number_format($medium, 2);
        } elseif ($nilai > 80 && $nilai <= 100) {
            $medium = (100 - $nilai) / 20;
            $high = ($nilai - 80) / 20;
            $fuzzyDetails[$valt->nama_alternatif][] = "Nilai $nilai memiliki derajat keanggotaan MEDIUM = " . number_format($medium, 2) . ", HIGH = " . number_format($high, 2);
        }

        $rules[] = [
            'low' => $low,
            'medium' => $medium,
            'high' => $high,
            'nilai' => $nilai, 
        ];
    }

    // Defuzzifikasi 
    $numerator = 0;
    $denominator = 0;
    foreach ($rules as $rule) {
    
        $nilaiCrisp = $rule['nilai'];

        
        $numerator += $rule['low'] * $nilaiCrisp + $rule['medium'] * $nilaiCrisp + $rule['high'] * $nilaiCrisp;
        $denominator += $rule['low'] + $rule['medium'] + $rule['high'];
    }

    if ($denominator > 0) {
        $fuzzyValues[$valt->nama_alternatif] = $numerator / $denominator;
        $fuzzyDetails[$valt->nama_alternatif][] = "Hasil defuzzifikasi = " . number_format($fuzzyValues[$valt->nama_alternatif], 4);
    } else {
        $fuzzyValues[$valt->nama_alternatif] = 0; 
        $fuzzyDetails[$valt->nama_alternatif][] = "Tidak ada aturan yang memenuhi, hasil defuzzifikasi = 0";
    }
}

        
     //   arsort($ranking);




        $pdf = PDF::loadView('admin.perhitungan.perhitungan-pdf',compact('alternatif','kriteria','fuzzyNormalisasi', 'normalisasiTahapDua', 'normalisasiTahapTiga', 'fuzzyValues','fuzzyDetails', 'tanggal'));
        $pdf->setPaper('A3', 'potrait');
        return $pdf->stream('perhitungan.pdf');
    }
}
