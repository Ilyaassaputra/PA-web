<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('santri.addPayment', ['id' => $data_santri->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-input-label for="jenis_tagihan" :value="__('Jenis Tagihan')" />
                        <select name="tagihan_id" id="jenis_pembayaran" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Jenis Pembayaran</option>
                            @foreach($dataTagihan as $jenis_tagihan)
                            <option value="{{ $jenis_tagihan->id }}" data-nominal="{{ $jenis_tagihan->nominal_tagihan }}" data-form="{{ $jenis_tagihan->jenis_tagihan }}">{{ $jenis_tagihan->jenis_tagihan }}</option>
                        @endforeach
                        </select>
                    </div>

              <!-- Menampilkan / menyembunyikan elemen berdasarkan jenis pembayaran -->
              <div id="form_pembayaran" class="mt-4">
                <!-- Form untuk jenis pembayaran Bulanan -->
                <div id="form_bulanan" style="display: none;">
                    <x-input-label for="bulan" :value="__('Bulan')" />
                    <x-text-input id="bulan" class="block mt-1 w-full" type="text" name="bulan" :value="old('bulan')" />
                    <x-input-error :messages="$errors->get('bulan')" class="mt-2" />
                </div>

                <!-- Form untuk jenis pembayaran Daftar Ulang -->
                <div id="form_daftar_ulang" style="display: none;">
                    <!-- Tidak perlu menampilkan form untuk 'bulan' pada Daftar Ulang -->
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="nominal_tagihan" :value="__('Nominal')" />
                <x-text-input id="nominal_tagihan" class="block mt-1 w-full" type="text" name="nominal_tagihan" :value="old('nominal_tagihan')" disabled/>
                <x-input-error :messages="$errors->get('nominal_tagihan')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="metode" :value="__('Metode')" />
                <select name="metode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Metode Pembayaran</option>
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="bukti_transfer" :value="__('Bukti Transfer')" />
                <x-text-input id="bukti_transfer" style="display: none;" class="block mt-1 w-full" type="file" name="bukti_transfer" :value="old('bukti_transfer')" />
                <x-input-error :messages="$errors->get('bukti_transfer')" class="mt-2" />
            </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('jenis_pembayaran').addEventListener('change', function () {
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
