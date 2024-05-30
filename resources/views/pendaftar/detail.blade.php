<x-app-layout>
    @if ($data_pendaftar->status == 1)
        <?php $statusText = 'Belum Bayar'; ?>
    @elseif($data_pendaftar->status == 2)
        <?php $statusText = 'Butuh Verifikasi'; ?>
    @endif
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Pendaftar</h4>
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
                    <a href="{{ url('datapendaftar') }}">Data Pendaftar</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Detail Pendaftar</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Detail Pendaftar</h4>
                        </div>
                    </div>
                    <div class="row gutters-sm">
                        <div class="col mt-5">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset("{$data_pendaftar->foto}") }}"
                                        class="img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-5">
                            <div class="mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4><b>Informasi Pendaftar</b></h4>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Lengkap</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->nama }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Tempat Tanggal Lahir</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->tempat_lahir }},
                                                {{ $data_pendaftar->tanggal_lahir }} </h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Jenis Kelamin</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->jenis_kelamin }}</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Sekolah</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->daftarSekolah->nama_sekolah }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Alamat</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->alamat }}</h4>
                                        </div>
                                    </div>
                                    <br>
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
                                            <h4>: {{ $data_pendaftar->nama_ayah }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Ibu</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_pendaftar->nama_ibu }}</h4>
                                        </div>
                                    </div>
                                    <br>
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
                                            <h4>: {{ $data_pendaftar->no_hp }}</h4>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Status Pembayaran</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: <span
                                                    class="{{ $data_pendaftar->status === '2' ? 'badge bg-warning text-light' : 'badge bg-danger text-light' }} badge">{{ $statusText }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Bukti Pembayaran</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            @if ($data_pendaftar->bukti_pembayaran === null)
                                                <h4>: -</h4>
                                            @else
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#bukti">
                                                    Lihat Bukti Pembayaran
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <form
                                            action="{{ route('konfirmasi.pendaftar', ['id' => $data_pendaftar->id]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary bt-sm">Konfirmasi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="bukti" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header no-bd">
                                        <h3 class="modal-title">
                                            Bukt Pembayaran
                                        </h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset("{$data_pendaftar->bukti_pembayaran}") }}"
                                            class="img-fluid cursor-pointer" alt="Bukti Pembayaran">
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

</x-app-layout>
