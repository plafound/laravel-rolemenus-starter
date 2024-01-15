<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Dosen;

class DosenImport implements ToModel
{
    public function model(array $row)
    {
        return new Dosen([
            'nama' => $row[0] ?? null,
            'pendidikan' => $row[1] ?? null,
            'no_telp' => $row[2] ?? null,
            'matkul_id' => $row[3] ?? null,
            // tambahkan kolom lainnya sesuai kebutuhan
        ]);
    }
}
