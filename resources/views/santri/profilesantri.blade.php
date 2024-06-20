<x-app-layout>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Santri</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/profilesantri') }}">Profile</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Detail Santri</h4>
                            @if(auth()->user()->role == 'santri')
                                @foreach ($santris as $santri)
                                    <a href="{{ route('santri.history', ['id' => $santri->id]) }}">Lihat Riwayat</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row gutters-sm">
                        <div class="col mt-5">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset("{$data_pendaftars->foto}") }}" class="img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>
                        <div class="col-8 mt-5">
                            <div class="mb-3">
                                <div class="card-body">
                                    <!-- Informasi Santri -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4><b>Informasi Santri</b></h4>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Lengkap</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->nama }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Tempat Tanggal Lahir</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->tempat_lahir }},
                                                {{ date('d F Y', strtotime($data_pendaftars->tanggal_lahir)) }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Jenis Kelamin</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->jenis_kelamin }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Alamat</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->alamat }}</h4>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Informasi Orang Tua -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4><b>Informasi Orang Tua</b></h4>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Ayah</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->nama_ayah }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Ibu</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->nama_ibu }}</h4>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Kontak -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4><b>Kontak</b></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>No Hp</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftars->no_hp }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            $('#add-row').DataTable({
                "pageLength": 10,
            })
        </script>
    @endsection
</x-app-layout>
