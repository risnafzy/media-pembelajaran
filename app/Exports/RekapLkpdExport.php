<?php

namespace App\Exports;

use App\Models\LkpdAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapLkpdExport implements FromCollection, WithHeadings
{
    protected $courseId;

    public function __construct($courseId)
    {
        $this->courseId = $courseId;
    }

    public function collection()
    {
        $answers = LkpdAnswer::whereHas('subQuestion.question.case', function ($q) {
            $q->where('course_id', $this->courseId);
        })
        ->with(['student', 'subQuestion.question'])
        ->get();

        // 🔥 GROUP BY SISWA
        $grouped = $answers->groupBy('student_id');

        return $grouped->map(function ($items) {

            $row = [];

            $student = $items->first()->student;
            $row['Nama Siswa'] = $student->name ?? '-';

            $totalNilai = 0;
            $no = 1;

            foreach ($items as $item) {

                // 🔥 Bersihin HTML
                $data = json_decode($item->subQuestion->question, true);

                $soal = strip_tags($data['deskripsi'] ?? '-');

                $row["Soal $no"] = $soal;
                $row["Jawaban $no"] = $item->jawaban;

                $totalNilai += $item->score ?? 0;

                $no++;
            }

            // 🔥 NILAI AKHIR
            $row['Nilai Akhir'] = $totalNilai;

            return $row;
        })->values();
    }

    public function headings(): array
    {
        return []; // 🔥 otomatis dari key array
    }
}