<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    protected $jenis;
    protected $soalList;

    public function __construct($jenis = 'pretest')
    {
        $this->jenis = $jenis;

        // ambil soal dari bank_soal
        $this->soalList = DB::table('bank_soal')
            ->where('jenis', $jenis)
            ->orderBy('id')
            ->get();
    }

    public function collection()
    {
        $students = DB::table('users')
            ->where('role', 'siswa')
            ->get();

        $rows = [];

        foreach ($students as $student) {

            // 🔥 FIX: pakai bank_soal_id
            $answers = DB::table('jawaban_siswa')
                ->where('siswa_id', $student->id)
                ->where('jenis', $this->jenis)
                ->get()
                ->keyBy('bank_soal_id');

            $row = [];
            $row[] = $student->name;

            $benar = 0;
            $total = count($this->soalList);

            foreach ($this->soalList as $i => $soal) {

                // 🔥 ambil berdasarkan bank_soal_id
                $jawabanData = $answers->get($soal->id);

                $jawaban = $jawabanData->jawaban ?? '-';
                $isBenar = $jawabanData->benar ?? 0;

                // 🔥 kolom soal (S1, S2, ...)
                $row[] = strip_tags($soal->pertanyaan);


                // 🔥 kolom jawaban (J1, J2, ...)
                $row[] = $jawaban;

                if ($isBenar) {
                    $benar++;
                }
            }

            $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

            $row[] = $nilai;

            $rows[] = $row;
        }

        return new Collection($rows);
    }

    public function headings(): array
    {
        $headings = ['Nama'];

        foreach ($this->soalList as $i => $soal) {
            $headings[] = "S" . ($i + 1);
            $headings[] = "J" . ($i + 1);
        }

        $headings[] = 'Score';

        return $headings;
    }
}
