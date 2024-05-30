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
                    <a href="{{ url('datasantri') }}">Data Santri</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Detail Santri</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Detail Santri</h4>
                        </div>
                    </div>
                    <div class="row gutters-sm">
                        <div class="col mt-5">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset("{$data_santri->foto}") }}"
                                        class="img-thumbnail" width="150">

                                </div>
                            </div>
                        </div>
                        <div class="col-8 mt-5">
                            <div class="mb-3">
                                <div class="card-body">
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
                                            <h4>: {{ $data_santri->nama }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Tempat Tanggal Lahir</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_santri->tempat_lahir }},
                                                {{ date('d F Y', strtotime($data_santri->tanggal_lahir)) }} </h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Jenis Kelamin</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_santri->jenis_kelamin }}</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Sekolah</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_santri->sekolah->nama_sekolah }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Alamat</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_santri->alamat }}</h4>
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
                                            <h4>: {{ $data_santri->nama_ayah }}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h4>Nama Ibu</h4>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4>: {{ $data_santri->nama_ibu }}</h4>
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
                                            <h4>: {{ $data_santri->no_hp }}</h4>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Data Pembayaran Santri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Jenis Tagihan</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($dataTagihan as $tagihan)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if ($tagihan->jenis_tagihan_id == '1')
                                                    {{ $tagihan->bulan }} {{ $tagihan->created_at->format('Y') }}
                                                @elseif ($tagihan->jenis_tagihan_id == '2')
                                                    {{ $tagihan->thn_ajaran }}
                                                @endif
                                            </td>
                                            <td>{{ $tagihan->JenisTagihan->jenis_tagihan }}</td>
                                            <td>{{ $tagihan->nominal_tagihan }}</td>
                                            <td><span
                                                    class="{{ $tagihan->status_pembayaran === 'Sudah Bayar' ? 'badge  bg-success text-light ' : 'badge  bg-danger text-light' }} badge">{{ $tagihan->status_pembayaran }}</span>
                                            </td>
                                            <td>
                                                @if ($tagihan->pembayaran)
                                                    {{ $tagihan->pembayaran->created_at->format('d F Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($tagihan->status_pembayaran === 'Belum Bayar')
                                                    {{-- {{ route('show-bayar-form', $tagihan->id) }} --}}
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#bayar{{ $tagihan->id }}"
                                                        data-tagihan-id="{{ $tagihan->id }}">
                                                        Bayar
                                                    </button>
                                                @elseif ($tagihan->status_pembayaran === 'Sudah Bayar')
                                                    <button class="btn btn-primary btn-sm">cetak bukti</button>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="bayar{{ $tagihan->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header no-bd">
                                                        <h3 class="modal-title">
                                                            Tambah Pembayaran
                                                        </h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('bayar', $tagihan->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="metode">Metode Pembayaran</label>
                                                                        <select class="form-control" id="metode"
                                                                            name="metode">
                                                                            <option value="">Metode Pembayaran
                                                                            </option>
                                                                            <option value="Cash"> Cash</option>
                                                                            <option value="Transfer">Transfer Bank
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="bukti_transfer">Unggah Bukti</label>
                                                                        <input type="file" class="form-control"
                                                                            name="bukti_transfer" id="bukti_transfer">
                                                                    </div>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 mr-2">
                                                                        <button class="btn btn-primary btn-sm "
                                                                            type="submit">Simpan</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
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
