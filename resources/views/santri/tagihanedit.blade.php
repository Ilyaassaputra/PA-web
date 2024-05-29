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
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Ubah Nominal Tagihan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Ubah Nominal Tagihan</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tagihanedit.update') }}" method="post">
                            @csrf
                            @foreach ($jenisTagihan as $jenis)
                                <div class="form-group">
                                    <label for="nominal_tagihan{{ $jenis->id }}">{{ $jenis->jenis_tagihan }}</label>
                                    <input type="number" class="form-control" name="nominal_tagihan"
                                        id="nominal_tagihan{{ $jenis->id }}"
                                        value="{{ old('nominal_tagihan', $jenis->nominal_tagihan) }}" required autofocus
                                        autocomplete="username">
                                </div>
                                {{-- <div class="form-group">
                    <label for="nominal_tagihan{{ $jenis->id }}">{{ $jenis->jenis_tagihan }}</label>
                    <input type="number" class="form-control" id="nominal_tagihan{{ $jenis->id }}"
                        name="nominal_tagihan[{{ $jenis->id }}]" value="{{ $jenis->nominal_tagihan }}" required>
                </div> --}}
                            @endforeach
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mr-2">
                                <button type="submit" class="btn btn-primary btn-md mr-2">Simpan</button>
                                <button type="button" class="btn btn-secondary btn-md"
                                    onclick="history.back();">Kembali</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
