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
                            <h4 class="card-title">Detail Santri</h4>
                        </div>
                    </div>
                    <div class="row gutters-sm">
                        <div class="col mt-5">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="{{ asset("{$data_santri->foto}") }}" class="img-thumbnail" width="150">
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
                            <h4 class="card-title">Data Pembayaran Santri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan / Tahun Ajaran</th>
                                        <th>Jenis Tagihan</th>
                                        <th>Nominal (Rp)</th>
                                        <th>Status</th>
                                        <th>Jumlah Dibayar (Rp)</th>
                                        <th>Sisa Pembayaran (Rp)</th>
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
                                            <td>{{ number_format($tagihan->nominal_tagihan, 2) }}</td>
                                            <td>
                                                <span
                                                    class="{{ $tagihan->status_pembayaran === 'Sudah Bayar' ? 'badge bg-success text-light' : ($tagihan->status_pembayaran === 'Cicilan' ? 'badge bg-warning text-dark' : 'badge bg-danger text-light') }} badge">
                                                    {{ $tagihan->status_pembayaran }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($tagihan->pembayaran)
                                                    {{ number_format($tagihan->pembayaran()->latest()->first()->jumlah_dibayar, 2) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            @if ($tagihan->status_pembayaran === 'Cicilan' && $tagihan->pembayaran()->exists())
                                                <td>{{ number_format($tagihan->pembayaran()->latest()->first()->sisa_pembayaran, 2) }}
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>
                                                @if ($tagihan->pembayaran)
                                                    {{ $tagihan->pembayaran()->latest()->first()->created_at->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#bayar{{ $tagihan->id }}"
                                                    data-tagihan-id="{{ $tagihan->id }}">
                                                    Bayar
                                                </button>
                                                <a href="{{ route('tagihan.detail', $tagihan->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                        <!-- Modal Bayar-->
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
                                                                            name="metode"
                                                                            onchange="toggleInstallmentInput(this.value, {{ $tagihan->id }})">
                                                                            <option value="">Pilih Metode
                                                                                Pembayaran</option>
                                                                            <option value="Cash">Cash</option>
                                                                            <option value="Transfer">Transfer Bank
                                                                            </option>
                                                                            <option value="Cicil">Cicil</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group"
                                                                        id="installmentInput{{ $tagihan->id }}"
                                                                        style="display: none;">
                                                                        <label for="jumlah_dibayar">Jumlah yang
                                                                            Dibayarkan</label>
                                                                        <input type="number" class="form-control"
                                                                            id="jumlah_dibayar" name="jumlah_dibayar"
                                                                            min="1" step="0.01">
                                                                    </div>
                                                                    @if ($tagihan->status_pembayaran === 'Cicilan' && $tagihan->pembayaran()->exists())
                                                                        <div class="form-group">
                                                                            <label for="sisa_pembayaran">Sisa
                                                                                Pembayaran</label>
                                                                            <input type="text" class="form-control"
                                                                                id="sisa_pembayaran"
                                                                                value="{{ number_format($tagihan->pembayaran()->latest()->first()->sisa_pembayaran, 2) }}"
                                                                                readonly>
                                                                        </div>
                                                                    @endif

                                                                    <div class="form-group">
                                                                        <label for="bukti_transfer">Unggah
                                                                            Bukti</label>
                                                                        <input type="file" class="form-control"
                                                                            name="bukti_transfer" id="bukti_transfer">
                                                                    </div>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 mr-2">
                                                                        <button class="btn btn-primary btn-sm"
                                                                            type="submit">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Cetak -->
                                        <div class="modal fade" id="modalCetak{{ $tagihan->id }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><strong>Riwayat Pembayaran</strong>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Jumlah Tagihan:
                                                            {{ number_format($tagihan->nominal_tagihan, 2) }}</p>
                                                        <p>Tanggal Pembayaran:
                                                            @if ($tagihan->pembayaran()->exists())
                                                                {{ $tagihan->pembayaran()->latest()->first()->created_at->format('d/m/Y') }}
                                                            @else
                                                                Belum ada data pembayaran
                                                            @endif
                                                        </p>
                                                        <p>Metode Pembayaran:
                                                            @if ($tagihan->pembayaran()->exists())
                                                                {{ $tagihan->pembayaran()->latest()->first()->metode }}
                                                            @else
                                                                Belum ada data pembayaran
                                                            @endif
                                                        </p>
                                                        <p>Bukti Pembayaran :</p>
                                                        @if ($tagihan->pembayaran()->exists())
                                                            @php
                                                                $hasBuktiTransfer = false;
                                                            @endphp
                                                            @foreach ($tagihan->pembayaran as $pembayaran)
                                                                @if (isset($pembayaran->bukti_transfer) && $pembayaran->bukti_transfer)
                                                                    <img src="{{ asset("{$pembayaran->bukti_transfer}")}}"
                                                                        class="img-fluid cursor-pointer"
                                                                        alt="Bukti Pembayaran">
                                                                    @php
                                                                        $hasBuktiTransfer = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if (!$hasBuktiTransfer)
                                                                -
                                                            @endif
                                                        @else
                                                            -
                                                        @endif


                                                        <h5>History Pembayaran cicilan</h5>
                                                        @if ($tagihan->pembayaran()->exists())
                                                            @foreach ($tagihan->pembayaran()->get() as $pembayaran)
                                                                <p>Tanggal Pembayaran:
                                                                    {{ $pembayaran->created_at->format('d/m/Y') }} -
                                                                    {{ number_format($pembayaran->jumlah_dibayar, 2) }}
                                                                </p>
                                                                <p>Sisa Pembayaran:
                                                                    {{ number_format($pembayaran->sisa_pembayaran, 2) }}
                                                                </p>
                                                            @endforeach
                                                        @else
                                                            <p>Belum ada history pembayaran cicilan.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Tutup</button>
                                                        <!-- Tombol untuk mencetak modal -->
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            onclick="cetakBukti('modalCetak{{ $tagihan->id }}')">Cetak</button>
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
    <script>
        function cetakBukti(modalId) {
            var printContents = document.getElementById(modalId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <script>
        function toggleInstallmentInput(value, tagihanId) {
            var installmentInput = document.getElementById('installmentInput' + tagihanId);
            if (value === 'Cicil') {
                installmentInput.style.display = 'block';
            } else {
                installmentInput.style.display = 'none';
            }
        }
    </script>

    @section('script')
        <script>
            $('#add-row').DataTable({
                "pageLength": 10,
            })
        </script>
    @endsection
</x-app-layout>
