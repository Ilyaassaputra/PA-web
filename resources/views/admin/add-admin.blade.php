<x-app-layout>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Add Admin</h4>
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
                    <a href="#">Data Admin</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>   
                <li class="nav-item">
                    <a href="#">Add Admin</a>
                </li>                                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            
                        <h4 class="card-title"> Tambah Admin</h4>   
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('createAdmin') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirmation</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 mr-2"> 
                        <button type="submit" id="add" class="btn btn-primary btn-md mr-2 save" > Simpan </button> 
                        <button type="button" class="btn btn-secondary btn-md"
                                    onclick="history.back();">Kembali</button>                            
                      </div> 


                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>