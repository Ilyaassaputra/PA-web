    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group">            
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" placeholder="Current Password"/>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" /> 
        </div>                       
        <div class="form-group">  
            <label for="password">New Password</label> 
            <input id="password" name="password" type="password" placeholder="New Password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="form-group">  
            <label for="password_confirmation">{{ __('Confirm Password') }}</label> 
            <input id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 mr-2"> 
            <button class="btn btn-primary btn-md">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    
            </div>
        </div>
    </div>
    
    

    

