<x-app-layout>
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
                    <a href="#">Data Pendaftar</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
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
                                                            class="btn btn-danger btn-sm" data-confirm-delete="true">
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
