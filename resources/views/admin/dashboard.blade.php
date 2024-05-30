<x-app-layout>
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    <h5 class="text-white op-7 mb-2">Welcome</h5>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    {{-- <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                    <a href="#" class="btn btn-secondary btn-round">Add Customer</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Pendaftar</p>
                                    <h4 class="card-title">{{ $jumlahPendaftar }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Santri</p>
                                    <h4 class="card-title">{{ $jumlahSantri }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="flaticon-graph"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total</p>
                                    <h4 class="card-title">$ 1,345</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="flaticon-success"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total</p>
                                    <h4 class="card-title">576</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="row row-card-no-pd">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title"> Data Pendaftar</h4>

                        <a href="{{ url('tambah.pendaftar') }}" class="btn btn-primary btn-sm  ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="add-row" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Pembayaran</th>
                                    <th>Sekolah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_pendaftar as $pendaftar)
                                    @if ($pendaftar->status == 1)
                                        <?php $statusText = 'Belum Bayar'; ?>
                                    @elseif($pendaftar->status == 2)
                                        <?php $statusText = 'Butuh Verifikasi'; ?>
                                    @elseif($pendaftar->status == 3)
                                        <?php continue; ?>
                                        <!-- Jika status 3, lewati loop dan lanjutkan ke data berikutnya -->
                                    @endif
                                    <tr>
                                        <!-- Tampilkan data pendaftar -->
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $pendaftar->nama }}</td>
                                        <td>{{ $pendaftar->created_at->format('d F Y') }}</td>
                                        <td>{{ $pendaftar->jenis_kelamin }}</td>
                                        <td><span
                                                class="{{ $pendaftar->status === '2' ? 'badge bg-warning text-light' : 'badge bg-danger text-light' }} badge">{{ $statusText }}</span>
                                        </td>
                                        <td>{{ $pendaftar->daftarSekolah->nama_sekolah }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-flex">
                                                <a href="{{ route('pendaftar.detail', $pendaftar->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">Detail
                                                </a>

                                                <form
                                                    action="{{ route('konfirmasi.pendaftar', ['id' => $pendaftar->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm mr-2">Konfirmasi</button>
                                                </form>
                                                <form
                                                        action="{{ route('destroy.pendaftar', ['id' => $pendaftar->id]) }}"
                                                        data-confirm-delete="true" method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" id="deleted"
                                                            class="btn btn-danger btn-sm " data-confirm-delete="true">
                                                            Tolak
                                                            {{-- <i class="fas fa-trash"></i> --}}
                                                        </button>

                                                    </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
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
