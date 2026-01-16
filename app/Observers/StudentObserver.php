<?php

namespace App\Observers;

use App\Models\Student;

    class StudentObserver
    {
        public function deleting(Student $student)
        {
            // Soft delete related records
            if (!$student->isForceDeleting()) {
                $student->contactInfo()->delete();
                $student->academicInfo()->delete();
                $student->marks()->delete();
            }
        }
        public function restoring(Student $student)
        {
            $student->contactInfo()->restore();
            $student->academicInfo()->restore();
            $student->mark()->restore();
        }
    }
