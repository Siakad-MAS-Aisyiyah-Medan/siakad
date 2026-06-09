<?php

namespace App\Exceptions;

use InvalidArgumentException;

class JadwalConflictException extends InvalidArgumentException
{
    public const JAM_INVALID = 'jam_tidak_valid';

    public const GURU = 'guru_bentrok';

    public const KELAS = 'kelas_bentrok';

    public const RUANGAN = 'ruangan_bentrok';

    public function __construct(
        public readonly string $conflictType,
        string $message
    ) {
        parent::__construct($message);
    }
}
