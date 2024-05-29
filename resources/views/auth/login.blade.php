<x-guest-layout>
    <!-- Session Status -->
    <div class="row align-items-center justify-content-center">
        <div class="col-md-6 py-xl-5">
            <div class="card">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="loginname"> Email atau Username</label>
                            <input type="text" class="form-control" name="loginname" id="loginname"
                                placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="password">
                        </div>
                        <div class="block mt-2">
                            @if (Route::has('password.request'))
                                <a class="text-sm"
                                    href="{{ route('password.request') }}">
                                    {{ __('Lupa Password ?') }}
                                </a>
                            @endif
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mr-2">
                            <button class="btn btn-primary " type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-guest-layout>
