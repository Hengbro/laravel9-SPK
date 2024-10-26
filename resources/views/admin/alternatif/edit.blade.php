@extends('layouts.app')
@section('title', 'SPK Metode SAW ', $alternatif->nama_alternatif)
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahkriteria" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Edit Alternatif {{ $alternatif->nama_alternatif }}</h6>
                </a>
            
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="tambahkriteria">
                <div class="card-body">
                    @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Infor</strong> {{ Session::get('msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif

                    <form action="{{ route('alternatif.update', $alternatif->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="nama">Nama Alternatif</label>
                            <input type="text" class="form-control @error ('nama_alternatif') is-invalid @enderror" name="nama_alternatif" value="{{ $alternatif->nama_alternatif }}">

                            @error('nama_alternatif')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <!-- <div class="form-group">
                            <label for="nama">NIK</label>
                            <input type="number" class="form-control @error ('nik') is-invalid @enderror" name="nik" value="{{ $alternatif->nik }}">

                            @error('nik')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div> -->

                        <!-- <div class="form-group">
    <label for="agama">Agama</label>
    <select class="form-control @error('agama') is-invalid @enderror" name="agama">
        <option value="">-- Pilih Agama --</option>
        <option value="Islam" {{ (old('agama') ?? $alternatif->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
        <option value="Kristen" {{ (old('agama') ?? $alternatif->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
        <option value="Katolik" {{ (old('agama') ?? $alternatif->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
        <option value="Hindu" {{ (old('agama') ?? $alternatif->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
        <option value="Buddha" {{ (old('agama') ?? $alternatif->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
        <option value="Konghucu" {{ (old('agama') ?? $alternatif->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
    </select>

    @error('agama')
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div> -->


                        <div class="form-group">
                            <label for="nama">Umur</label>
                            <input type="number" class="form-control @error ('umur') is-invalid @enderror" name="umur" value="{{ $alternatif->umur }}">

                            @error('umur')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group">
    <label for="jk">Jenis Kelamin</label>
    <select class="form-control @error('jk') is-invalid @enderror" name="jk">
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki" {{ (old('jk') ?? $alternatif->jk) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="Perempuan" {{ (old('jk') ?? $alternatif->jk) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
    </select>

    @error('jk')
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>


                        <div class="form-group">
                            <label for="nama">Jabatan</label>
                            <input type="text" class="form-control @error ('jabatan') is-invalid @enderror" name="jabatan" value="{{ $alternatif->jabatan }}">

                            @error('jabatan')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="nama">Alamat</label>
                            <input type="text" class="form-control @error ('alamat') is-invalid @enderror" name="alamat" value="{{ $alternatif->alamat }}">

                            @error('alamat')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="nama">Telepon</label>
                            <input type="number" class="form-control @error ('telepon') is-invalid @enderror" name="telepon" value="{{ $alternatif->telepon }}">

                            @error('telepon')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('alternatif.index') }}" class="btn btn-success">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop