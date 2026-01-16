<?php

namespace App\Imports;

use App\Models\Curriculum;
use App\Models\Student;
use App\Models\StudentMark;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;  

class StudentMarkImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    protected $chunkSize = 1000;

    public function collection(Collection $rows)
    {

        DB::transaction(function () use ($rows) {
            $studentsMarksData = [];
            foreach ($rows as $index => $row) {
                $error = !DB::table('semester_curriculum')
                    ->where('semester_id', $row['semester_id'])
                    ->where('curriculum_id', $row['curriculum_id'])
                    ->exists();
                if($error)
                throw ValidationException::withMessages(["There was an error on row " . ($index + 1) . ". The curriculum_id field is invalid."]);  

                $student = Student::where('university_id', $row['university_id'])->first();

                if ($student) {
                    $curriculum = Curriculum::find($row['curriculum_id']);
                    $isSuccessful = $curriculum ? $row['mark'] >= $curriculum->min_pass_mark : false;

                    $studentsMarksData[] = [
                        'student_id' => $student->id,
                        'semester_id' => $row['semester_id'],
                        'curriculum_id' => $row['curriculum_id'],
                        'mark' => $row['mark'],
                        'written_mark' => $row['written_mark'],
                        'is_successful' => $isSuccessful,
                        'created_at' => Carbon::now(),
                    ];
                }
            }

            if (!empty($studentsMarksData)) {
                StudentMark::insert($studentsMarksData);
            }
        });
    }

    public function chunkSize(): int
    {
        return $this->chunkSize;
    }

    public function rules(): array
    {
        return [
            'university_id' => 'required|exists:students,university_id',
            'semester_id' => 'required|exists:semesters,id',
            'curriculum_id' => 'required',
            'mark' => 'required|numeric|between:1,100',
            'written_mark' => 'required|string|max:255',
        ];
    }
}
