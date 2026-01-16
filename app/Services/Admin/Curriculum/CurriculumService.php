<?php

namespace App\Services\Admin\Curriculum;

use App\Http\Requests\Api\Admin\Curriculum\CreateCurriculumRequest;
use App\Http\Requests\Api\Admin\Curriculum\UpdateCurriculumRequest;
use App\Http\Resources\CurriculumWithSemesterResource;
use App\Models\Curriculum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CurriculumService
{
    /**
     * Create a new class instance.
     */
    public function store(CreateCurriculumRequest $request)
    {
        $data = $request->validated();
        try {
            if ($request->hasFile('description_file')) {
                $data['description_file'] = $data['description_file']->storePublicly('curriculums/file', 'public');
            }

            $curriculum = Curriculum::create($data);
            return CurriculumWithSemesterResource::make($curriculum);
        } catch (\Throwable $th) {
            Storage::disk('public')->delete($data['description_file']);

            throw $th;
        }
    }
    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('description_file')) {
                $oldFilePath = $curriculum->description_file;

                $data['description_file'] = $request->file('description_file')->storePublicly('curriculums/file', 'public');
            }
            $curriculum->update($data);
            $curriculum = Curriculum::find($curriculum->id);
            return CurriculumWithSemesterResource::make($curriculum);
        } catch (\Throwable $th) {
            if ($oldFilePath && Storage::exists("public/$oldFilePath")) {
                Storage::delete("public/$oldFilePath");
            }
            throw $th;
        }
    }
    public function destroy($curriculum, $force = null)
    {
        if ($force) {
            $curriculum = Curriculum::onlyTrashed()->findOrFail($curriculum);
            // DB::afterCommit(function () use ($curriculum) {
                if (Storage::exists("public/$curriculum->description_file")) {
                    Storage::delete("public/$curriculum->description_file");
                }
            // });
            $curriculum->forceDelete();
        } else {
            $curriculum = Curriculum::where('id', $curriculum)->first();
            $curriculum->delete();
        }
        return true;
    }
    public function restore($curriculum)
    {
        $curriculum = Curriculum::withTrashed()->find($curriculum);
        if ($curriculum && $curriculum->trashed()) {
            $curriculum->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
}
