<?php

namespace App\Traits;
use App\Models\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

trait LogsModelChanges
{
    protected static function bootLogsModelChanges()
    {
        $getRequestPayload = function () {
            try {
                $data = request()->all();
                if (isset($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                }
                return json_encode($data, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                return null;
            }
        };
        
        static::created(function ($model) use ($getRequestPayload) {
            $excludedModels = explode(',', request()->input('excluded_models', ''));
            if (self::shouldLogOperation($model, 'create', $excludedModels)) {
                self::logModelChange($model, 'create', $getRequestPayload());
            }
        });

        static::updated(function ($model) use ($getRequestPayload) {
            $excludedModels = explode(',', request()->input('excluded_models', ''));
            if ($model->isDirty() && self::shouldLogOperation($model, 'update', $excludedModels)) {
                self::logModelChange($model, 'update', $getRequestPayload());
            }
        });

        static::deleted(function ($model) use ($getRequestPayload) {
            $operation = self::getDeleteOperation($model);
            if (self::shouldLogOperation($model, $operation)) {
                self::logModelChange($model, $operation, $getRequestPayload());
            }
        });

        if (in_array(SoftDeletes::class, class_uses(static::class))) {
            static::restored(function ($model) use ($getRequestPayload) {
                if (self::shouldLogOperation($model, 'restore')) {
                    self::logModelChange($model, 'restore', $getRequestPayload());
                }
            });
        }
    }

    /**
     * Get the Arabic name for the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    protected static function getModelNameInArabic($model)
    {
        $modelClass = get_class($model);
        
        // Define the mapping between model class names and Arabic names
        $modelNamesInArabic = [
            \App\Models\User::class => 'المستخدم',
            \App\Models\AcademicFee::class => 'الرسم الأكاديمي',
            \App\Models\City::class => 'المدينة',
            \App\Models\Country::class => 'البلد',
            \App\Models\Curriculum::class => 'المقرر',
            \App\Models\Discount::class => 'الخصم',
            \App\Models\DiscountType::class => 'نوع الخصم',
            \App\Models\Doctor::class => 'الدكتور',
            \App\Models\DoctorAcademicInfo::class => 'المعلومات الأكاديمية للدكتور',
            \App\Models\DoctorAcademicPosition::class => 'المناصب الأكاديمية للدكتور',
            \App\Models\DoctorAchievement::class => 'إنجازات الدكتور',
            \App\Models\Employee::class => 'الموظف',
            \App\Models\ExaminationDate::class => 'موعد الإختبار',
            \App\Models\ExaminationHall::class => 'قاعة الإختبار',
            \App\Models\Nationality::class => 'الجنسية',
            \App\Models\News::class => 'الأخبار',
            \App\Models\ProgramRule::class => 'قواعد البرنامج',
            \App\Models\Province::class => 'المقاطعة',
            \App\Models\Section::class => 'القسم',
            \App\Models\Semester::class => 'الفصل',
            \App\Models\Student::class => 'الطالب',
            \App\Models\StudentMark::class => 'علامات الطالب',
            \App\Models\UniversityServicesFee::class => 'رسم الخدمات الجامعية',
        ];

        // Return the Arabic name if exists, otherwise fallback to the original class name
        return $modelNamesInArabic[$modelClass] ?? $modelClass;
    }

    /**
     * Determine if an operation should be logged.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $operation
     * @param array $excludedModels
     * @return bool
     */
    protected static function shouldLogOperation($model, $operation, $excludedModels = [])
    {
        return !in_array(get_class($model), $excludedModels)
            && !($operation === 'update' && $model instanceof \App\Models\User && $model->isDirty('last_active_at'))
            && !($operation === 'update' && $model->isDirty('deleted_at'));
        }

    /**
     * Log the model change to the logs table.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $operation
     * @param string|null $requestPayload
     * @return void
     */
    protected static function logModelChange($model, $operation, $requestPayload)
    {
        Log::create([
            'user_id' => auth()->id()??null,
            'model_type' => self::getModelNameInArabic($model),  // Use Arabic model name
            'model_id' => $model->id,
            'operation' => $operation,
            'request_payload' => $requestPayload,
        ]);
    }

    /**
     * Determine the delete operation type (force_delete or soft_delete).
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    protected static function getDeleteOperation($model)
    {
        return in_array(SoftDeletes::class, class_uses($model)) && !$model->isForceDeleting()
            ? 'soft_delete'
            : 'force_delete';
    }

}
