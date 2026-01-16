<?php

namespace App\Exports;

use App\Models\StudentMark;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class StudentMarkExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $curriculumID;

    public function __construct($curriculumID)
    {
        $this->curriculumID = $curriculumID;
    }
    public function collection()
    {
        return StudentMark::with('student')
        ->where('curriculum_id', $this->curriculumID)
        ->get();
        
    }
    public function map($studentMark): array
    {
        return [
            $studentMark->student->university_id,        // university_id
            $studentMark->student->first_name_ar,        // student_name_ar
            $studentMark->student->first_name_en,        // student_name_en
            $studentMark->student->last_name_ar,         // last_name_ar
            $studentMark->student->last_name_en,         // last_name_en
            $studentMark->student->father_name_ar,       // father_name_ar
            $studentMark->student->father_name_en,       // father_name_en
            $studentMark->student->mother_name_ar,       // mother_name_ar
            $studentMark->student->mother_name_en,       // mother_name_en
            $studentMark->mark,                          // mark
            $studentMark->written_mark,                  // written_mark
            $studentMark->is_successful ? 'Success' : 'Fail',  // is_successful
        ];
    }
    public function headings(): array
    {
        return [
            'University id',
            'Student name ar',
            'Student name en',
            'Last name ar',
            'Last name en',
            'Father name ar',
            'Father name en',
            'Mother name ar',
            'Mother name en',
            'Mark',
            'Written mark',
            'Result',
        ];
    }
}
