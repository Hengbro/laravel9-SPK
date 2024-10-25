<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style type="text/css">
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
        }

        #camat {
            text-align: center;
        }

        #nama-camat {
            margin-top: 100px;
            text-align: center;
        }

        #ttd {
            position: absolute;
            bottom: 10px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div>
    
    <table style="width: 90%;">
    <tr>
        <td style="width: 90px; padding-right: 20px; vertical-align: middle;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/logoptboss.png'))) }}" 
                 width="90" height="90" alt="Logo">
        </td>
        <td style="vertical-align: middle; text-align: center;">
            <div>
                <font size="4">Laporan Hasil Penilaian Karyawan</font><br>
                <font size="4">PMKS PT. BOSS</font><br>
                <font size="2">Telp: 0895678945 - Alamat PT. BOSS - Kode Pos: 22865</font><br>
                <font size="2">Sejak {{ $selectedPeriode}} </font><br>
            </div>
        </td>
    </tr>
</table>



        <hr class="garis1" />

        <div style="margin-top: 25px; margin-bottom: 25px;">
            <center><strong><u>LIST LAPORAN</u></strong></center>
        </div>

        <div class="card shadow mb-4">

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="rank">
    <div class="table-responsive">
        @php
            $totals = []; // Array untuk menyimpan total
        @endphp

        @foreach($normalisasiTahapTiga as $key => $value)
            @php 
                $total = array_sum($value); // Hitung total langsung
                $totals[$key] = $total; // Simpan total dalam array
            @endphp
        @endforeach

        @php
            // Urutkan total dari yang terbesar ke terkecil
            arsort($totals);
            $topAlternatifs = array_slice($totals, 0, 5, true);
        @endphp

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; padding-bottom: 40px">Nama</th>
                    <th style="text-align: center; padding-bottom: 40px">Total</th>
                    <th style="text-align: center; padding-bottom: 40px">Rank</th>
                </tr>
            </thead>
            <tbody>
                @php $rank = 1; @endphp
                @foreach($totals as $key => $total)
                    <tr>
                        <td>{{ $key }}</td> {{-- Tampilkan nama --}}
                        <td>{{ number_format($total, 4) }}</td>  {{-- Tampilkan total --}}
                        <td>{{ $rank++ }}</td> {{-- Tampilkan ranking --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    </div>

    <!-- Kesimpulan -->
    <div class="mt-4">
                    <h6 class="font-weight-bold">Kesimpulan:</h6>
                    <p>
                        Dari tabel di atas dapat disimpulkan bahwa peluang terbesar yang akan terpilih
                        menjadi Karyawan terbaik diperoleh oleh:
                        @foreach($topAlternatifs as $alt => $value)
                            {{ $alt }} dengan nilai {{ number_format($value, 4) }}{{ $loop->last ? '.' : ',' }}
                        @endforeach 
                        Untuk lebih jelasnya, dapat dilihat pada tabel di atas.
                    </p>
                </div>
    </div>
</body>
</html>
