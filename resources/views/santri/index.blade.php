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
                    <a href="#">Data Santri</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                        <h4 class="card-title"> Data Santri</h4>
                            {{-- <a  href="" class="btn btn-primary btn-sm  ml-auto">
                            <i class="fa fa-plus"></i>
                              Tambah Data
                            </a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Sekolah</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($data_santri as $santri)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $santri->nama }}</td>
                                    <td>{{ $santri->jenis_kelamin }}</td>
                                    <td>{{ $santri->sekolah->nama_sekolah }}</td>
                                    <td>{{ $santri->alamat }}</td>
                                    <td>
                                        <a href="{{ route('santri.detail', $santri->id) }}" class="btn btn-primary btn-sm">Detail</a>
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

