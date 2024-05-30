<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\ListSekolah;
use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function showRegistrationForm()
    {
        $daftarSekolah = ListSekolah::all();
        return view('auth.register', compact('daftarSekolah'));
    }

    public function register(Request $request)
    {
        $request->validate([
            // Validasi untuk form pendaftaran santri
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required','string','max:255'],
            'tanggal_lahir' => ['required','date'],
            'jenis_kelamin' => ['required', 'string'],
            'sekolah_id' => ['required', 'string'],
            'nama_ayah' => ['required', 'string'],
            'nama_ibu' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string'],
            'foto' => ['image','mimes:jpeg,png,jpg,gif'],


            // Validasi untuk form akun
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan foto ke dalam direktori penyimpanan
        $fotoPath = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->file('foto')->store('foto', 'public');
        }
        $user = $this->createUser($request->all(), $fotoPath);  // Kirim $fotoPath ke createUser
        event(new Registered($user));

        return $this->registered($request, $user);
    }

    protected function createUser(array $data, $fotoPath)
    {
        // Buat pengguna dalam tabel users
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        DataPendaftar::create([
            'user_id' => $user->id,
            'nama' => $data['nama'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'sekolah_id' => $data['sekolah_id'],
            'nama_ayah' => $data['nama_ayah'],
            'nama_ibu' => $data['nama_ibu'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'foto' => $fotoPath,
        ]);

        // Buat token untuk pengguna yang baru didaftarkan
        $token = $user->createToken('api-token');

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        if ($user) {
            event(new Registered($user));
            Auth::login($user);
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User registered successfully',
                    'user' => $user,
                    'token' => $user->createToken('api-token')->plainTextToken,
                ], 201);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to register user.'], 400);
            } else {
                return redirect()->route('login')->withErrors(['message' => 'Failed to register user.']);
            }
        }
    }


}
