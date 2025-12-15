<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            {{-- PERBAIKAN: Mengarah ke route 'dashboard' --}}
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        
        {{-- MENU DROPDOWN USER (POJOK KANAN) --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user mr-2"></i>
                <b>{{ Auth::user()->nama ?? 'User' }}</b>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Menu Pengguna</span>
                <div class="dropdown-divider"></div>
                
                {{-- 1. TOMBOL LIHAT PROFIL --}}
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-id-card mr-2"></i> Lihat Profil Saya
                </a>
                
                <div class="dropdown-divider"></div>

                {{-- 2. TOMBOL LOGOUT --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>