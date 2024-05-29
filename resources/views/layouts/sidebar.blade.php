<!-- Sidebar -->
<div class="sidebar sidebar-style-2">			
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          <img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
        </div>
        <div class="info">
          <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
            <span>
              {{ optional(Auth::user())->username }}
              <span class="user-level">{{ optional(Auth::user())->email }}</span>
              
            </span>
          </a>
          

          
        </div>
      </div>
      <ul class="nav nav-primary">
        <li class="nav-item ">
          <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>            
          </a>
          
        </li>
        @if(Auth::user()->role == 'admin')
         
        <li class="nav-item">
          <a  href="{{ url('datapendaftar') }}">
            <i class="far fa-address-card"></i>
            <p>Data Pendaftar</p>            
          </a>
        </li>
        <li class="nav-item">
          <a  href="{{ url('datasantri') }}">
            <i class="fas fa-address-card"></i>
            <p>Data Santri</p>
          </a>          
        </li>
        <li class="nav-item">
          <a  href="{{ route('laporan.index') }}">
            <i class="fas fa-pen-square"></i>
            <p>Laporan</p>
          </a>          
        </li>
        <li class="nav-item">
          <a  href="{{ route('tagihan') }}">
            <i class="fas fa-coins"></i>
            <p>Tagihan</p>            
          </a>
        </li>
        <li class="nav-item">
          <a  href="{{ route('dataadmin') }}">
            <i class="fas fa-users"></i>
            <p>Data Admin</p>            
          </a>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('profilesantri') }}">
            <i class="fas fa-user"></i>
            <p>Profil</p>
          </a>          
        </li>
        @endif
        <li class="nav-item">
          <a  href="{{ route('profile.edit') }}">
            <i class="fas fa-user-gear"></i>
            <p>Pengaturan Akun</p>
          </a>          
        </li>
        <li class="nav-item">
          <a  href="{{ url('logout') }}">
            <i class="fas fa-arrow-right-from-bracket"></i>
            <p>Log Out</p>
          </a>          
        </li>
        
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->






