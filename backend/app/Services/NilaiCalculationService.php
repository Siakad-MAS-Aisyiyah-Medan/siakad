<?php

namespace App\Services;

class NilaiCalculationService
{
    public function calculate(array $input): array
    {
        $tugas = (int) ($input['nilai_tugas'] ?? 0);
        $uts = (int) ($input['nilai_uts'] ?? 0);
        $uas = (int) ($input['nilai_uas'] ?? 0);
        $praktik = array_key_exists('nilai_praktik', $input) && $input['nilai_praktik'] !== null && $input['nilai_praktik'] !== ''
            ? (int) $input['nilai_praktik']
            : null;
        $sikap = array_key_exists('nilai_sikap', $input) && $input['nilai_sikap'] !== null && $input['nilai_sikap'] !== ''
            ? (int) $input['nilai_sikap']
            : null;

        foreach ([$tugas, $uts, $uas] as $n) {
            $this->assertRange($n);
        }
        if ($praktik !== null) {
            $this->assertRange($praktik);
        }
        if ($sikap !== null) {
            $this->assertRange($sikap);
        }

        if ($praktik !== null) {
            $weights = config('nilai.weights.with_praktik');
            $nilaiAkhir = (int) round(
                $tugas * $weights['tugas']
                + $uts * $weights['uts']
                + $uas * $weights['uas']
                + $praktik * $weights['praktik']
            );
        } else {
            $weights = config('nilai.weights.default');
            $nilaiAkhir = (int) round(
                $tugas * $weights['tugas']
                + $uts * $weights['uts']
                + $uas * $weights['uas']
            );
        }

        return [
            'nilai_tugas' => $tugas,
            'nilai_uts' => $uts,
            'nilai_uas' => $uas,
            'nilai_praktik' => $praktik,
            'nilai_sikap' => $sikap,
            'nilai_akhir' => $nilaiAkhir,
            'nilai_angka' => $nilaiAkhir,
            'predikat' => $this->predikat($nilaiAkhir),
        ];
    }

    public function predikat(int $nilai): string
    {
        foreach (config('nilai.predikat', []) as $row) {
            if ($nilai >= $row['min']) {
                return $row['grade'];
            }
        }

        return 'E';
    }

    protected function assertRange(int $nilai): void
    {
        if ($nilai < 0 || $nilai > 100) {
            throw new \InvalidArgumentException('Nilai harus antara 0 dan 100.');
        }
    }
}
