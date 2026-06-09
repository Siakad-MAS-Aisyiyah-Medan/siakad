<?php

namespace App\Http\Requests\PPDB;

use App\Services\PpdbBerkasService;
use Illuminate\Foundation\Http\FormRequest;

class UploadBerkasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('jenis_berkas')) {
            $this->merge([
                'jenis_berkas' => PpdbBerkasService::normalizeJenis($this->input('jenis_berkas')),
            ]);
        }
    }

    public function rules(): array
    {
        $maxKb = (int) config('ppdb.berkas.max_size_kb', 2048);
        $jenis = implode(',', PpdbBerkasService::allJenisKeys());

        return [
            'jenis_berkas' => 'required|string|in:'.$jenis,
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:'.$maxKb,
        ];
    }

    public function messages(): array
    {
        $maxKb = (int) config('ppdb.berkas.max_size_kb', 2048);

        return [
            'file.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file maksimal '.round($maxKb / 1024, 1).' MB.',
        ];
    }
}
