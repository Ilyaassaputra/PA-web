<x-guest-layout>

    <div class="row align-items-center justify-content-center">
        <div class="col-md-6 py-xl-5">
            <div class="card">
                <x-auth-session-status class="mb-4" :status="session('status')" />
               
                <div class="card-body">
                    <h4 class="card-title">Lupa Password</h4>
                    <p class="card-text">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="email" id="email"
                                placeholder="Masukkan Email Anda" value="{{ old('email') }}" required autofocus>
                        </div>
                        
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button class="btn btn-primary " type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
</x-guest-layout>
