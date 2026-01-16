<?php

namespace App\Services\Admin\StudentMark;
use App\Exports\StudentMarkExport;
use App\Http\Requests\Api\Admin\StudentMark\CreateStudentMarkRequest;
use App\Http\Requests\Api\Admin\StudentMark\UpdateSMarkRequest;
use App\Http\Resources\StudentMarkResource;
use App\Imports\StudentMarkImport;
use App\Models\Curriculum;
use App\Models\StudentMark;
use App\Traits\SearchTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class StudentMarkService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    use SearchTrait;
    public function index(Request $request)
    {
        $studentMarksQuery = StudentMark::query();

        if ($request->filled('semester_id') && $request->filled('curriculum_id')) {
            $studentMarksQuery->where('semester_id', $request->semester_id)
                              ->where('curriculum_id', $request->curriculum_id);

                $totalStudents = $studentMarksQuery->count();
                $successfulStudents = $studentMarksQuery->clone()->where('is_successful', true)->count();  

                $successPercentage = $totalStudents > 0 ? ($successfulStudents / $totalStudents) * 100 : 0;
                $failurePercentage = 100 - $successPercentage;

                $data = [
                    'success_percentage' => $successPercentage,
                    'failure_percentage' => $failurePercentage,
                ];
        } 
        $this->applySearchAndSort($studentMarksQuery, $request, StudentMark::$searchable);
        $studentMarks = $studentMarksQuery->paginate(config('app.pagination_limit'));

        $data['studentMarks'] = StudentMarkResource::collection($studentMarks);
        return $data;
    }
    public function store(CreateStudentMarkRequest $request)
    {
        $data = $request->validated();
        $studentMark = StudentMark::create($data);
        return StudentMarkResource::make($studentMark);
    }
    public function show(StudentMark $studentMark)
    {
        return StudentMarkResource::make($studentMark);
    }
    public function update(UpdateSMarkRequest $request, StudentMark $studentMark)
    {
        $data = $request->validated();
        $studentMark->update($data);
        $studentMark = StudentMark::find($studentMark->id);
        return StudentMarkResource::make($studentMark);
    }
    public function destroy($studentMark, $force = null)
    {
        if ($force) {
            $studentMark = StudentMark::onlyTrashed()->findOrFail($studentMark);
            $studentMark->forceDelete();
        } else {
            $studentMark = StudentMark::where('id', $studentMark)->first();
            $studentMark->delete();
        }
        return true;
    }
    public function restore($studentMark)
    {
        $studentMark = StudentMark::withTrashed()->find($studentMark);
        if ($studentMark && $studentMark->trashed()) {
            $studentMark->restore();
            return true;
        }
        throw new \Exception(__('messages.not_found'), 404);
    }
    public function importExcel(Request $request)
    {
        $sheet = $request->file('excel_file')->store('files');
        Excel::import(new StudentMarkImport, $sheet);
        return true;
    }
    public function exportPdf(string $id)
    {
        $locale = app()->getLocale();
        $curriculum = Curriculum::findOrFail($id);  
        $fileName = $curriculum->{'name_' . $locale} . '-students-marks.pdf';  
        $studentMarks = (new StudentMarkExport($id))->collection();

        $mpdf = new Mpdf([
            'default_font' => 'DejaVuSans'  
        ]);      
        $mpdf->WriteHTML('<table border="1" cellpadding="10" style="border-collapse: collapse;">');
        
        $headings = (new StudentMarkExport($id))->headings();
        $mpdf->WriteHTML('<tr>');
        foreach ($headings as $heading) {
            $mpdf->WriteHTML("<th>{$heading}</th>");
        }
        $mpdf->WriteHTML('</tr>');

        foreach ($studentMarks as $studentMark) {
            $mpdf->WriteHTML('<tr>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->university_id . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->first_name_ar . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->first_name_en . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->last_name_ar . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->last_name_en . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->father_name_ar . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->father_name_en . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->mother_name_ar . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->student->mother_name_en . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->mark . '</td>');
            $mpdf->WriteHTML('<td>' . $studentMark->written_mark . '</td>');
            $mpdf->WriteHTML('<td>' . ($studentMark->is_successful ? 'Success' : 'Fail') . '</td>');
            $mpdf->WriteHTML('</tr>');
        }

        $mpdf->WriteHTML('</table>');

        $mpdf->Output($fileName, 'D'); 
    }
}
