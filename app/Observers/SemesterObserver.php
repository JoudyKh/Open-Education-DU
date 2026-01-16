<?php

namespace App\Observers;

use App\Models\Semester;

class SemesterObserver
{
    public function deleting(Semester $semester)
    {
        // Soft delete related records
        if (!$semester->isForceDeleting()) {
            $semester->academicFees()->delete();
            $semester->discounts()->delete();
            $semester->universityServicesFees()->delete();
            $semester->examinationHalls()->delete();
            $semester->examinationDates()->delete();
        }
    }
    public function restoring(Semester $semester)
    {
        // Restore related records
        $semester->academicFees()->restore();
        $semester->discounts()->restore();
        $semester->universityServicesFees()->restore();
        $semester->examinationHalls()->restore();
        $semester->examinationDates()->restore();
    }
}
