<?php

namespace App\Observers;

use App\Models\Doctor;

class DoctorObserver
{
    /**
     * Handle the Doctor "created" event.
     */
    public function deleting(Doctor $doctor)
    {
        // Soft delete related records
        if (!$doctor->isForceDeleting()) {
            $doctor->achievements()->delete();
            $doctor->positions()->delete();
            $doctor->infos()->delete();
        }
    }
    public function restoring(Doctor $doctor)
    {
        $doctor->achievements()->restore();
        $doctor->positions()->restore();
        $doctor->infos()->restore();
    }
}
