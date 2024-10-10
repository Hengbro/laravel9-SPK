@extends('layouts.app')
@section('title', 'SPK Metode SAW')
@section('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')



    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahalternatif" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data Karyawan</h6>
                </a>
            
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="tambahalternatif">
                <div class="card-body">
                    @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Infor</strong> {{ Session::get('msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif

                    <form action="{{ route('alternatif.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Karyawan</label>
                            <input type="text" class="form-control @error ('nama_alternatif') is-invalid @enderror" name="nama_alternatif" value="{{ old('nama_alternatif') }}">

                            @error('nama_alternatif')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="nama">NIK</label>
                            <input type="number" class="form-control @error ('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}">

                            @error('nik')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
    <label for="nama">Agama</label>
    <select class="form-control @error('agama') is-invalid @enderror" name="agama">
        <option value="">Pilih Agama</option>
        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
        <option value="Protestan" {{ old('agama') == 'Protestan' ? 'selected' : '' }}>Protestan</option>
        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
        <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
    </select>

    @error('agama')
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>


                        <div class="form-group">
                            <label for="nama">Umur</label>
                            <input type="text" class="form-control @error ('umur') is-invalid @enderror" name="umur" value="{{ old('umur') }}">

                            @error('umur')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
    <label for="nama">Jenis Kelamin</label>
    <select class="form-control @error('jk') is-invalid @enderror" name="jk">
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Pria" {{ old('jk') == 'Pria' ? 'selected' : '' }}>Pria</option>
        <option value="Wanita" {{ old('jk') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
    </select>

    @error('jk')
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>

                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control @error ('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}">

                            @error('jabatan')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="nama">Alamat</label>
                            <input type="text" class="form-control @error ('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}">

                            @error('alamat')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="nama">Telepon</label>
                            <input type="number" class="form-control @error ('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}">

                            @error('telepon')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">List Karyawan</h6>
                </a>
            
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="listkriteria">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{ URL::to('download-alternatif-pdf') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                            class="fas fa-download fa-sm text-white-50"></i>Download Laporan</a>
                        <table class="table table-striped table-hover" id="DataTable" data-paging="false">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>NIK</th>
                                    <th>Agama</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($alternatif as $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->nama_alternatif }}</td>
                                        <td>{{ $row->nik }}</td>
                                        <td>{{ $row->agama }}</td>
                                        <td>{{ $row->umur }}</td>
                                        <td>{{ $row->jk }}</td>
                                        <td>{{ $row->jabatan }}</td>
                                        <td>{{ $row->alamat }}</td>
                                        <td>{{ $row->telepon }}</td>
                                        <td>
                                            <a href="{{ route('alternatif.edit',$row->id) }}" class="btn btn-sm btn-circle btn-warning">
                                            <i  class="fa fa-edit"></i>
                                            </a>

                                            <a href="{{ route('alternatif.destroy',$row->id) }}" class="btn btn-sm btn-circle btn-danger hapus">
                                            <i  class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $alternatif->links() }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    </div>






@stop
@section('js')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#DataTable').DataTable();

        $('.hapus').on('click', function(){
            swal({
                title: "Apa anda yakin?",
                text: "Sekali anda menghapus data, data tidak dapat dikembalikan lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: $(this).attr('href'),
                        type: 'DELETE',
                        data: {
                            '_token' : "{{ csrf_token() }}"
                        },
                        success:function()
                        {
                            swal("Data berhasil dihapus!", {
                            icon: "success",
                            }).then((willDelete) => {
                                window.location = "{{ route('alternatif.index') }}"
                            });
                        }
                    })
                } else {
                    swal("Data Aman!");
                }
            });

            return false;
        })
    })
</script>

@stop
    