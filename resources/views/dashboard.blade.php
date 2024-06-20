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
                            <p>Silahkan melakukan pembayaran pendaftaran</p>
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

    @endif
    @section('script')
        <script>
            $('#add-row').DataTable({
                "pageLength": 10,
            })
        </script>
    @endsection
</x-app-layout>
