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
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Detail Pembayaran Santri</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Detail Pembayaran Santri</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

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
                        <img src="{{ asset("{$tagihan->pembayaran()->first()->bukti_transfer}") }}"
                            class="img-fluid cursor-pointer" alt="Bukti Pembayaran">
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
            </div>
            <div class="text-right mt-4">
        <button class="btn btn-primary btn-print" onclick="window.print()">Cetak Halaman</button>
    </div>
        </div>
    </div>

    <style>
        @media print {
            /* Sembunyikan tombol cetak saat dicetak */
            .btn-print {
                display: none;
            }

            /* Contoh lain: mengatur margin halaman cetak */
            body {
                margin: 10mm 10mm 10mm 10mm;
            }
        }
    </style>
</x-app-layout>
