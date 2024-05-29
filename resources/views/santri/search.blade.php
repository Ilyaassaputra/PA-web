<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran2') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="get" action="{{ route('santri.search') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="keyword" :value="__('Cari Nama Santri')" />
                        <x-text-input id="keyword" class="block mt-1 w-full" type="text" name="keyword" />
                        {{-- <x-input-error :messages="$errors->get('bulan')" class="mt-2" /> --}}

                            <x-primary-button class="ms-4">
                                {{ __('Cari') }}
                            </x-primary-button>
                    </div>
                </form>
                                @if(count($santris) > 0)
                    <h2>Hasil Pencarian untuk "{{ $keyword }}"</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Santri</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Sekolah</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santris as $santri)
                                <tr>
                                    <td>{{ $santri->nama }}</td>
                                    <td>{{ $santri->tempat_lahir }}</td>                                    
                                    <td>{{ $santri->tanggal_lahir }}</td>                                    
                                    <td>{{ $santri->jenis_kelamin }}</td>
                                    
                                    <td>{{ $santri->sekolah->nama_sekolah }}</td>
                                    
                                    <td>
                                        <a href="{{ route('santri.detail', ['id' => $santri->id]) }}">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada hasil untuk "{{ $keyword }}".</p>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>