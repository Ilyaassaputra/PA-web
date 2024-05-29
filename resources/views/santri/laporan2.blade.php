<x-app-layout>
    {{-- {{ dd($thnAjarans->toArray()) }} --}}
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Laporan Pembayaran</h4>
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
                    <a href="#">Laporan Pembayaran</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Filter Laporan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('laporan.index') }}">
                            @csrf
                            <div class="form-group">
                                <label for="jenis_tagihan_id">Jenis Pembayaran</label>
                                <select class="form-control" id="jenis_tagihan_id" name="jenis_tagihan_id">
                                    <option value="">Semua</option>
                                    <option value="2">Daftar Ulang</option>
                                    <option value="1">Bulanan</option>
                                </select>
                            </div>
                            <div id="bulanTahun">
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label for="bulan">Tahun</label>
                                    <select class="form-control" id="tahun" name="tahun">
                                        <option value="">Pilih Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group" id="ajaran">
                                <label for="thnajaran">Tahun Ajaran</label>
                                <select class="form-control" name="thnajaran" id="thnajaran">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($thnAjarans->toArray() as $tahun)
                                        <option value="{{ $tahun['thn_ajaran'] }}">{{ $tahun['thn_ajaran'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_pembayaran">Status Pembayaran</label>
                                <select class="form-control" id="status_pembayaran" name="status_pembayaran">
                                    <option value="">Semua</option>
                                    <option value="Sudah Bayar">Lunas</option>
                                    <option value="Belum Bayar">Belum Lunas</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 d-md-flex mt-2 ml-2">
                                {{-- <button type="submit" class="btn btn-primary btn-md">
                                    <i class="icon-magnifier"></i> Cari
                                </button> --}}
                                <button type="button" id="btn-cari" class="btn btn-primary btn-md">
                                    <i class="icon-magnifier"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Laporan Pembayaran</h4>
                            <a href="" class="btn btn-primary btn-md  ml-auto">
                                <i class="icon-printer"></i>
                                Print
                            </a>
                        </div>
                    </div>
                    <div id="alert-kosong">
                        @if ($laporan->isEmpty())
                            <br>
                            <center>
                                <h3>Tidak ada data pembayaran untuk periode yang dipilih.</h3>
                            </center>
                            <br>
                        @else
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Santri</th>
                                        <th>Jenis Tagihan</th>
                                        <th>Bulan</th>
                                        <th>Nominal</th>
                                        <th>Metode</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="data-laporan">
                                    <?php $no = 1; ?>
                                    @foreach ($laporan as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->santri->nama }}</td>
                                            <td>{{ $data->jenisTagihan->jenis_tagihan }}</td>
                                            <td>
                                                @if ($data->jenis_tagihan_id == '1')
                                                    {{ $data->bulan }} {{ $data->created_at->format('Y') }}
                                                @elseif ($data->jenis_tagihan_id == '2')
                                                    {{ $data->thn_ajaran }}
                                                @endif
                                            </td>
                                            <td>{{ $data->nominal_tagihan }}</td>
                                            <td>{{ $data->pembayaran ? $data->pembayaran->metode : '-' }}</td>
                                            <td>
                                                @if ($data->pembayaran)
                                                    {{ $data->pembayaran->created_at->format('d F Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $data->status_pembayaran }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    @section('script')
        <script>
            $('#bulanTahun').hide();
            $('#ajaran').hide();
            $('#jenis_tagihan_id').change(function(e) {
                e.preventDefault();

                let jenis_pembayran = $(this).val();

                if (jenis_pembayran == 2) {
                    $('#bulanTahun').hide();
                    $('#ajaran').show();
                } else if (jenis_pembayran == 1) {
                    $('#bulanTahun').show();
                    $('#ajaran').hide();
                } else {
                    // refresh halaman
                    location.reload();
                }

            });

            $('#btn-cari').click(function(e) {
                e.preventDefault();
                let data = [];
                let jenis_pembayaran = $('#jenis_tagihan_id').val();
                if (jenis_pembayaran == 1) {
                    let bulan = $('#bulan').val();
                    let tahun = $('#tahun').val();
                    let status_pembayaran = $('#status_pembayaran').val();
                    // alert(bulan + tahun + status_pembayaran);
                    data = {
                        jenis_pembayaran: jenis_pembayaran,
                        bulan: bulan,
                        tahun: tahun,
                        status_pembayaran: status_pembayaran
                    };
                } else if (jenis_pembayaran == 2) {
                    let thnajaran = $('#thnajaran').val();
                    let status_pembayaran = $('#status_pembayaran').val();
                    data = {
                        jenis_pembayaran: jenis_pembayaran,
                        thnajaran: thnajaran,
                        status_pembayaran: status_pembayaran
                    };
                }

                $.ajax({
                    type: "get",
                    url: "api/cari",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.data.length == 0) {
                            $('#alert-kosong').html(`
                            <br>
                            <center>
                                <h3>Tidak ada data pembayaran untuk periode yang dipilih.</h3>
                            </center>
                            <br>
                            `);
                            $('#data-laporan').html('');
                        } else {
                            let html = '';
                            let no = 1;

                            $.map(response, function(elementOrValue, indexOrKey) {
                                $.map(elementOrValue, function(elementOrValue1, indexOrKey1) {
                                    html += '<tr>';
                                    html += '<td>' + no++ + '</td>';
                                    html += '<td>' + elementOrValue1.santri.nama + '</td>';
                                    html += '<td>' + elementOrValue1.jenis_tagihan
                                        .jenis_tagihan + '</td>';
                                    html += '<td>' + elementOrValue1.bulan + ' ' +
                                        elementOrValue1.created_at + '</td>';
                                    html += '<td>' + elementOrValue1.nominal_tagihan +
                                        '</td>';
                                    html += '<td>' + (elementOrValue1.pembayaran ?
                                            elementOrValue1.pembayaran.metode : '-') +
                                        '</td>';
                                    html += '<td>' + (elementOrValue1.pembayaran ?
                                            elementOrValue1.pembayaran.created_at : '-') +
                                        '</td>';
                                    html += '<td>' + elementOrValue1.status_pembayaran +
                                        '</td>';
                                    html += '</tr>';
                                });
                                $('#alert-kosong').html('');
                                $('#data-laporan').html('');
                                $('#data-laporan').html(html);
                            });
                        }

                    }
                });
            });
        </script>
    @endsection

</x-app-layout>
