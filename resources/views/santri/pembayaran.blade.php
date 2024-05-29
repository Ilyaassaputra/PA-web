<!-- resources/views/bayar.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bayar Tagihan') }}
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
                <form method="POST" action="{{ route('bayar', $dataTagihan->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="metode" :value="__('Metode Pembayaran')" />
                        <select name="metode" id="metode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="Tunai">Tunai</option>
                            <!-- Tambahkan opsi metode pembayaran lain jika diperlukan -->
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="bukti_transfer" :value="__('Bukti Transfer')" />
                        <x-text-input type="file" name="bukti_transfer" class="block mt-1 w-full" />
                        <x-input-error :messages="$errors->get('bukti_transfer')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Bayar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
