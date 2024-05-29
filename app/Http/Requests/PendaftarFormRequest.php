<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendaftarFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required','string','max:255'],
            'tanggal_lahir' => ['required','date'],
            'tanggal_daftar' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'sekolah_id' => ['required', 'string'],
            'nama_ayah' => ['required', 'string'],
            'nama_ibu' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string'],
            'foto' => ['image','mimes:jpeg,png,jpg,gif','max:2048'],
        ];
    }
}
