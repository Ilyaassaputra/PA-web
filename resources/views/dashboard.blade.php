<x-app-layout>
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h1 class="text-white  fw-bold">Hallo, {{ $data_pendaftars->nama }}</h1>
                    <h5 class="text-white op-7 mb-2">Welcome</h5>
                </div>
                {{-- <div class="ml-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                    <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
                </div> --}}
            </div>
        </div>
    </div>
    @if ($data_pendaftars->status === '1')
        <div class="page-inner mt--5">
            <div class="row mt--2">
                <div class="col-md">
                    <div class="card full-height">
                        <div class="card-body">
                            <div class="card-title">Unggah Bukti Pembayaran</div>
                            <div class="d-flex flex-wrap mt-4 ">

                                <form method="POST"
                                    action="{{ route('upload.bukti', ['id' => $data_pendaftars->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <input id="bukti_pembayaran" class="block mt-1 w-full" type="file"
                                            name="bukti_pembayaran" accept="image/* " />
                                        <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            {{ __('Upload') }}
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($data_pendaftars->status === '2')
        <div class="page-inner mt--5">
            <div class="row mt--2">
                <div class="col-md">
                    <div class="card full-height">
                        <div class="card-body">
                            <div class="card-title">Unggah Bukti Pembayaran</div>
                            <div class="d-flex flex-wrap mt-4 ">
                                <p>Anda telah mengupload bukti pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($data_pendaftars->status === '3')
        <div class="page-inner mt-3">
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
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>

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
    @endif
    @section('script')
        <script>
            $('#add-row').DataTable({
                "pageLength": 10,
            })
        </script>
    @endsection
</x-app-layout>
