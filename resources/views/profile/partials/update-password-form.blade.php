    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ganti Password</h4>
                </div>
                <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">Password Saat Ini</label>
            <input type="password" id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" placeholder="Password Saat Ini"/>

        </div>
        <div class="form-group">
            <label for="password">Password Baru</label>
            <input id="password" name="password" type="password" placeholder="Password Baru" class="form-control" autocomplete="new-password" />

        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ __('Konfirmasi Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" type="password" class="form-control" autocomplete="new-password" />

        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 mr-2">
            <button class="btn btn-primary btn-md">{{ __('Save') }}</button>


        </div>
    </form>

            </div>
        </div>
    </div>





