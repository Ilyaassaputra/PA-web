<x-app-layout>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Tagihan</h4>
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
                    <a href="#">Data Tagihan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Tagihan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('add-tagihan') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="jenis_tagihan_id">Jenis Tagihan</label>
                                <select class="form-control" id="jenis_tagihan_id" name="jenis_tagihan_id">
                                    <option value="">Jenis Pembayaran</option>
                                    @foreach ($jenis_tagihan as $jenis_tagihan)
                                        <option value="{{ $jenis_tagihan->id }}"
                                            data-nominal="{{ $jenis_tagihan->nominal_tagihan }}"
                                            data-form="{{ $jenis_tagihan->jenis_tagihan }}">
                                            {{ $jenis_tagihan->jenis_tagihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="form_bulanan" style="display: none;">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="">Pilih Bulan</option>
                                    <?php

                                    for ($i = 0; $i < 12; $i++) {
                                    $AmbilNamaBulan = strtotime(sprintf('%d months', $i));
                                    $LabelBulan     = date('F', $AmbilNamaBulan);
                                    $ValueBulan     = date('F', $AmbilNamaBulan);?>
                                    <option value="<?php echo $ValueBulan; ?>"><?php echo $LabelBulan; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <!-- Form untuk jenis pembayaran Daftar Ulang -->
                            <div class="form-group" id="form_daftar_ulang" style="display: none;">
                                <label for="thn_ajaran">Tahun Ajaran</label>
                                <input type="text" class="form-control" name="thn_ajaran" id="thn_ajaran"
                                    placeholder="Tahun">
                            </div>
                            <div class="form-group">
                                <label for="nominal_tagihan">Nominal Tagihan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nominal_tagihan"
                                        id="nominal_tagihan" placeholder="Nominal" readonly>
                                    <div class="input-group-append">

                                        <a href="{{ route('editindex') }}" class="btn btn-outline-primary btn-md"
                                            style="margin-left: 10px;">
                                                <i class="fas fa-edit"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mr-2">
                                <button class="btn btn-primary" id="add" type="submit">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Riwayat Tagihan</h4>
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
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($dataTagihanDetail as $tagihan)
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
                                            <td>{{ $tagihan->created_at->format('d F Y') }}</td>
                                            <td>
                                                <form action="{{ route('tagihan.destroy', $tagihan->batch_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
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
    </div>
    @section('script')
        <script>
            $('#add-row').DataTable({
                "pageLength": 10,
            })
        </script>
    @endsection
    <script>
        document.getElementById('jenis_tagihan_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var nominal = selectedOption.getAttribute('data-nominal');
            var formType = selectedOption.getAttribute('data-form');

            // Atur nilai nominal
            document.getElementById('nominal_tagihan').value = nominal;

            // Tampilkan / sembunyikan form berdasarkan jenis pembayaran
            if (formType === 'Bulanan') {
                document.getElementById('form_bulanan').style.display = 'block';
                document.getElementById('form_daftar_ulang').style.display = 'none';
            } else if (formType === 'Daftar Ulang') {
                document.getElementById('form_bulanan').style.display = 'none';
                document.getElementById('form_daftar_ulang').style.display = 'block';
            } else {
                // Sembunyikan kedua form jika tidak sesuai jenis pembayaran yang diketahui
                document.getElementById('form_bulanan').style.display = 'none';
                document.getElementById('form_daftar_ulang').style.display = 'none';
            }
        });
    </script>

</x-app-layout>
