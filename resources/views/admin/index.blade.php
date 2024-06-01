<x-app-layout>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Data Admin</h4>
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
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Admin</h4>
                            <a href="{{ url('add-admin') }}" class="btn btn-primary btn-sm ml-auto">
                                <i class="fa fa-plus"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($admin as $admin)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $admin->username }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>
                                                <form action="{{ route('destroy.admin', ['id' => $admin->id]) }}" method="post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-grid gap-2 d-md-flex">
                                                        <button type="button" class="btn btn-danger btn-sm delete-button">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </form>
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


    
</x-app-layout>
