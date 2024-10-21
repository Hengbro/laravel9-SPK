<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style type="text/css">
        .garis1{
            border-top:3px solid black;
            height: 2px;
            border-bottom:1px solid black;

        }

            #camat{
            text-align:center;
            }
            #nama-camat{
            margin-top:100px;
            text-align:center;
            }
            #ttd {
            position: absolute;
            bottom: 10;
            right: 20;
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
                <font size="4">PMKS PT BOSS</font><br>
                <font size="4">Telp: 0895678945</font><br>
                <font size="2">Alamat PT. BOSS</font><br>
                <font size="2">Kode Pos: 22865</font><br>
            </div>
        </td>
    </tr>
</table>         

      <hr class="garis1"/>
      <div style="margin-top: 25px; margin-bottom: 25px;">
        <center><strong><u>LIST PENILAIAN</u></strong></center>
      </div>

      <div class="collapse show" id="listkriteria">
        <div class="card-body">
            <div class="table-responsive">
               
                <br><br>
                <table class="table table-striped table-hover" id="DataTable">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            @foreach ($kriteria as $key => $value)
                                <th>{{ $value->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alternatif as $alt => $valt)
                            <tr>
                                <td>{{ $valt->nama_alternatif }}</td>
                                @if (count($valt->penilaian) > 0)
                                @foreach($valt->penilaian as $key => $value)
                                <td> 
                                    {{ $value->nilai }}
                                </td>
                                @endforeach

                            @endif
                            </tr>
                        @empty
                            <tr>
                                <td>Tidak ada data!</td>
                            </tr>
                        

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="ttd" class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <p id="camat">Medan, {{ $tanggal }}</p>
          <p id="camat"><strong>KETUA KELOMPOK</strong></p>
          <div id="nama-camat"><strong><u>DEVI PURBA</u></strong><br />NPM. 200840045</div>
      </div>
        </div>
</div>
</body>



</html>