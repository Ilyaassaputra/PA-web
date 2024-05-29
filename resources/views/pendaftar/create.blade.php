<x-app-layout>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Pendaftar</h4>
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
                    <a href="{{ url('datapendaftar') }}">Data Pendaftar</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah Data Pendaftar</a>
                </li>                                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Tambah Data Pendaftar</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <form method="POST" action="{{ url('tambah.pendaftar') }}" enctype="multipart/form-data">
                            @csrf                            
                            <div class="row mb-3">
                                <div class="col">
                                    <h4><b>Data Pendafatar</b></h4>
                                </div>                                
                                <div class="col-md-6">                                    
                                    <h4><b>Informasi akun</b></h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control mb-4 mb-md-0" type="text" name="nama" id="nama" for="nama" :value="old('nama')" required placeholder="Nama Lengkap"/>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control mb-4 mb-md-0" type="text" name="username" id="username" for="username" :value="old('username')" placeholder="Userame" required />
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="text" name="tempat_lahir" id="tempat_lahir" for="tempat_lahir" :value="old('tempat_lahir')" required placeholder="Tempat Lahir"/>
                                </div>
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="email" name="email" id="email" for="email" :value="old('email')" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="date" name="tanggal_lahir" id="tanggal_lahir" for="tanggal_lahir" :value="old('tanggal_lahir')" required placeholder="Tanggal Lahir"/>
                                </div>
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="password" name="password" id="password" for="password" :value="old('password')" placeholder="Password" required />
                                </div>
                            </div>
             
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" for="jenis_kelamin">
                                        <option value="">Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="password" name="password_confirmation" id="password_confirmation" for="password_confirmation" :value="old('password_confirmation')" placeholder="Konfirmasi Password" required />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                                                            
                                        <select class="form-control" id="sekolah_id" name="sekolah_id" for="sekolah_id">
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($daftarSekolah as $sekolah)
                                            <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                                            
                                            @endforeach
                                        </select>
                                    
                                </div>                               
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="text" name="nama_ayah" id="nama_ayah" for="nama_ayah" :value="old('nama_ayah')" required placeholder="Nama Ayah"/>
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="text" name="nama_ibu" id="nama_ibu" for="nama_ibu" :value="old('nama_ibu')" required placeholder="Nama Ibu"/>
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="text" name="alamat" id="alamat" for="alamat" :value="old('alamat')" required placeholder="Alamat"/>
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="number" name="no_hp" id="no_hp" for="no_hp" :value="old('no_hp')" required placeholder="Kontak"/>
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">                                    
                                    <input class="form-control mb-4 mb-md-0" type="file" name="foto" id="foto" for="foto" :value="old('foto')" required placeholder="Foto"/>
                                </div>                                
                            </div>

                            <hr>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-2">
                            <button class="btn btn-primary mr-2" type="submit">Simpan</button>
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


