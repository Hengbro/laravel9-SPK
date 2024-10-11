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
        <table>
            <tr>
            <td style="padding-right: 240px; padding-left: 20px">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/logoptboss.png'))) }}" width="90" height="90" alt="Logo">
                <td>
                    <center>
                        <font size="4">PMKS PT BOSS</font><br>
                        <font size="4">telp: 0895678945</font><br>
                        <font size="2">Alamat PT. BOSS</font><br>
                        <font size="2">Kode Pos: 22865</font><br>
                    </center>
                </td>
            </tr>
        </table>

        <hr class="garis1" />

        <div style="margin-top: 25px; margin-bottom: 25px;">
            <center><strong><u>LIST LAPORAN</u></strong></center>
        </div>

        <div class="collapse show" id="rank">
            <div class="card-body">
                <div class="table-responsive">
                    @php
                        $totals = []; // Array untuk menyimpan total
                    @endphp

                    @foreach($normalisasiTahapTiga as $key => $value)
                        @php 
                            $total = 0;  // Inisialisasi total untuk setiap baris
                        @endphp
                        @foreach($value as $value_1)
                            @php 
                                $total += $value_1;  // Tambahkan nilai ke total
                            @endphp
                        @endforeach
                        @php 
                            $totals[$key] = $total; // Simpan total dalam array
                        @endphp
                    @endforeach

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; padding-bottom: 40px">Nama / Bobot</th>
                                @foreach ($kriteria as $value)
                                    <th>{{ $value->nama_kriteria }}</th>
                                @endforeach
                                <th rowspan="2" style="text-align: center; padding-bottom: 40px">Total</th>
                                <th rowspan="2" style="text-align: center; padding-bottom: 40px">Rank</th>
                            </tr>
                            <tr>
                                @foreach ($kriteria as $key => $value)
                                    <th>{{ $value->bobot }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($totals as $key => $total)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach($normalisasiTahapTiga[$key] as $key_1 => $value_1)
                                        <td>{{ $value_1 }}</td>
                                    @endforeach
                                    <td>{{ number_format($total, 1) }}</td>  {{-- Tampilkan total --}}
                                    <td>{{ $no++ }}</td>  {{-- Tampilkan rank --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
