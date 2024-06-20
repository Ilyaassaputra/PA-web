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
                    <a href="{{ url('datasantri') }}">Profile</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Data Pembayaran Santri</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
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
                                                @if ($tagihan->status_pembayaran === 'Belum Bayar' || $tagihan->status_pembayaran === 'Cicilan')
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#bayar{{ $tagihan->id }}"
                                                        data-tagihan-id="{{ $tagihan->id }}">
                                                        Bayar
                                                    </button>
                                                @elseif ($tagihan->status_pembayaran === 'Sudah Bayar')
                                                    -
                                                    {{-- <button class="btn btn-primary btn-sm">Cetak Bukti</button> --}}
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
