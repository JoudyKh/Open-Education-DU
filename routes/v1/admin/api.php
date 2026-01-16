<?php

use App\Constants\Constants;
use App\Http\Controllers\Api\Admin\AcademicFee\AcademicFeeController as AdminAcademicFeeController;
use App\Http\Controllers\Api\Admin\Country\CountryController as AdminCountryController;
use App\Http\Controllers\Api\Admin\Curriculum\CurriculumController as AdminCurriculumController;
use App\Http\Controllers\Api\Admin\Discount\DiscountController as AdminDiscountController;
use App\Http\Controllers\Api\Admin\DiscountType\DiscountTypeController as AdminDiscountTypeController;
use App\Http\Controllers\Api\Admin\Doctor\AcademicInfoController as AdminAcademicInfoController;
use App\Http\Controllers\Api\Admin\Doctor\AcademicPositionController as AdminAcademicPositionController;
use App\Http\Controllers\Api\Admin\Doctor\AchievementController as AdminAchievementController;
use App\Http\Controllers\Api\Admin\Doctor\DoctorController as AdminDoctorController;
use App\Http\Controllers\Api\Admin\Employee\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Api\Admin\ExaminationDate\ExaminationDateController as AdminExaminationDateController;
use App\Http\Controllers\Api\Admin\ExaminationHall\ExaminationHallController as AdminExaminationHallController;
use App\Http\Controllers\Api\Admin\Log\LogController;
use App\Http\Controllers\Api\Admin\Nationality\NationalityController as AdminNationalityController;
use App\Http\Controllers\Api\Admin\News\NewsContoller as AdminNewsController;
use App\Http\Controllers\Api\Admin\ProgramRule\ProgramRuleController as AdminProgramRuleController;
use App\Http\Controllers\Api\Admin\Province\ProvinceContoller as AdminProvinceContoller;
use App\Http\Controllers\Api\Admin\Semester\SemesterController as AdminSemesterController;
use App\Http\Controllers\Api\Admin\Student\StudentContoller as AdminStudentContoller;
use App\Http\Controllers\Api\Admin\City\CityController as AdminCityController;
use App\Http\Controllers\Api\Admin\StudentMark\StudentMarkController as AdminStudentMarkController;
use App\Http\Controllers\Api\Admin\UniversityServicesFee\UniversityServicesFeeController as AdminUniversityServicesFeeController;
use App\Http\Controllers\Api\General\City\CityController;
use App\Http\Controllers\Api\General\Country\CountryController;
use App\Http\Controllers\Api\General\Curriculum\CurriculumController;
use App\Http\Controllers\Api\General\Nationality\NationalityController;
use App\Http\Controllers\Api\General\News\NewsContoller;
use App\Http\Controllers\Api\General\Province\ProvinceContoller;
use App\Http\Controllers\Api\General\Semester\SemesterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\Info\InfoController;
use App\Http\Controllers\Api\General\Auth\AuthController;
// use App\Http\Controllers\Api\General\Section\SectionController;
use App\Http\Controllers\Api\Admin\Info\InfoController as AdminInfoController;
use App\Http\Controllers\Api\Admin\ContactMessage\ContactMessageController;
// use App\Http\Controllers\Api\Admin\Section\SectionController as AdminSectionController;

/** @Auth */
Route::post('login', [AuthController::class, 'login'])->name('admin.login');//
Route::post('reset-password', [AuthController::class, 'resetPassword']);//
Route::post('send/verification-code', [AuthController::class, 'sendVerificationCode']);//
Route::post('check/verification-code', [AuthController::class, 'checkVerificationCode']);//

Route::group(['middleware' => ['auth:api', 'last.active', 'ability:' . Constants::SUPER_ADMIN_ROLE]], function () {

    /** @Auth */
    Route::post('logout', [AuthController::class, 'logout']);//
    Route::get('/check/auth', [AuthController::class, 'authCheck']);//
    Route::get('profile', [AuthController::class, 'profile']);//
    Route::put('change-password', [AuthController::class, 'changePassword']);//
    Route::put('profile/update', [AuthController::class, 'updateProfile']);//


    Route::prefix('contact-messages')->group(function () {
        Route::get('/', [ContactMessageController::class, 'index']);//
        Route::delete('{contactMessage}/{force?}', [ContactMessageController::class, 'delete']);//
        Route::patch('{contactMessage}/restore', [ContactMessageController::class, 'restore']);//
    });

    Route::prefix('/news')->group(function () {
        Route::get('/', [NewsContoller::class, 'index']);
        Route::post('/', [AdminNewsController::class, 'store']);
        Route::get('/{news}', [NewsContoller::class, 'show']);
        Route::put('/{news}', [AdminNewsController::class, 'update']);
        Route::delete('/{news}/{force?}', [AdminNewsController::class, 'destroy']);
        Route::get('/{news}/restore', [AdminNewsController::class, 'restore']);
    });

    Route::prefix('/provinces')->group(function () {
        Route::get('/', [ProvinceContoller::class, 'index']);
        Route::put('/{province}', [AdminProvinceContoller::class, 'update']);
    });

    Route::prefix('/students')->group(function () {
        Route::get('/', [AdminStudentContoller::class, 'index']);
        Route::post('/', [AdminStudentContoller::class, 'store']);
        Route::post('/import', [AdminStudentContoller::class, 'import']);
        Route::get('/{student}', [AdminStudentContoller::class, 'show']);
        Route::put('/{student}', [AdminStudentContoller::class, 'update']);
        Route::delete('/{id}/{force?}', [AdminStudentContoller::class, 'destroy']);
        Route::get('/{id}/restore', [AdminStudentContoller::class, 'restore']);

    });

    Route::prefix('/countries')->group(function () {
        Route::get('/', [CountryController::class, 'index']);
        Route::post('/', [AdminCountryController::class, 'store']);
        Route::put('/{country}', [AdminCountryController::class, 'update']);
        Route::delete('/{country}', [AdminCountryController::class, 'destroy']);
    });

    Route::prefix('/cities')->group(function () {
        Route::get('/', [CityController::class, 'index']);
        Route::post('/', [AdminCityController::class, 'store']);
        Route::put('/{city}', [AdminCityController::class, 'update']);
        Route::delete('/{city}', [AdminCityController::class, 'destroy']);
    });

    Route::prefix('/nationalities')->group(function () {
        Route::get('/', [NationalityController::class, 'index']);
        Route::post('/', [AdminNationalityController::class, 'store']);
        Route::put('/{nationality}', [AdminNationalityController::class, 'update']);
        Route::delete('/{nationality}', [AdminNationalityController::class, 'destroy']);
    });

    Route::prefix('/employees')->group(function () {
        Route::get('/', [AdminEmployeeController::class, 'index']);
        Route::get('/{employee}', [AdminEmployeeController::class, 'show']);
        Route::post('/', [AdminEmployeeController::class, 'store']);
        Route::put('/{employee}', [AdminEmployeeController::class, 'update']);
        Route::delete('/{employee}/{force?}', [AdminEmployeeController::class, 'destroy']);
        Route::get('/{employee}/restore', [AdminEmployeeController::class, 'restore']);
    });

    Route::prefix('/curriculums')->group(function () {
        Route::get('/', [CurriculumController::class, 'index']);
        Route::post('/', [AdminCurriculumController::class, 'store']);
        Route::get('/{curriculum}', [CurriculumController::class, 'show']);
        Route::put('/{curriculum}', [AdminCurriculumController::class, 'update']);
        Route::delete('/{curriculum}/{force?}', [AdminCurriculumController::class, 'destroy']);
        Route::get('/{curriculum}/restore', [AdminCurriculumController::class, 'restore']);
    });
    Route::prefix('/semesters')->group(function () {
        Route::get('/', [SemesterController::class, 'index']);
        Route::post('/', [AdminSemesterController::class, 'store']);
        Route::post('/{semester}/add/curriculums', [AdminSemesterController::class, 'addCurriculums']);
        Route::prefix("/{semester}")->group(function () {
            Route::get('/', [SemesterController::class, 'show']);

            Route::prefix('/academic-fees')->group(function () {
                Route::get('/', [AdminAcademicFeeController::class, 'index']);
                Route::post('/', [AdminAcademicFeeController::class, 'store']);
                Route::get('/{academicFee}', [AdminAcademicFeeController::class, 'show']);
                Route::put('/{academicFee}', [AdminAcademicFeeController::class, 'update']);
                Route::delete('/{academicFee}/{force?}', [AdminAcademicFeeController::class, 'destroy']);
                Route::get('/{academicFee}/restore', [AdminAcademicFeeController::class, 'restore']);
            });

            Route::prefix('/discounts')->group(function () {
                Route::get('/', [AdminDiscountController::class, 'index']);
                Route::post('/', [AdminDiscountController::class, 'store']);
                Route::get('/{discount}', [AdminDiscountController::class, 'show']);
                Route::put('/{discount}', [AdminDiscountController::class, 'update']);
                Route::delete('/{discount}/{force?}', [AdminDiscountController::class, 'destroy']);
                Route::get('/{discount}/restore', [AdminDiscountController::class, 'restore']);
            });
            Route::prefix('/university-services-fees')->group(function () {
                Route::get('/', [AdminUniversityServicesFeeController::class, 'index']);
                Route::post('/', [AdminUniversityServicesFeeController::class, 'store']);
                Route::get('/{universityServicesFee}', [AdminUniversityServicesFeeController::class, 'show']);
                Route::put('/{universityServicesFee}', [AdminUniversityServicesFeeController::class, 'update']);
                Route::delete('/{universityServicesFee}/{force?}', [AdminUniversityServicesFeeController::class, 'destroy']);
                Route::get('/{universityServicesFee}/restore', [AdminUniversityServicesFeeController::class, 'restore']);
            });
            Route::prefix('/examination-halls')->group(function () {
                Route::get('/', [AdminExaminationHallController::class, 'index']);
                Route::post('/', [AdminExaminationHallController::class, 'store']);
                Route::get('/{examinationHall}', [AdminExaminationHallController::class, 'show']);
                Route::put('/{examinationHall}', [AdminExaminationHallController::class, 'update']);
                Route::delete('/{examinationHall}/{force?}', [AdminExaminationHallController::class, 'destroy']);
                Route::get('/{examinationHall}/restore', [AdminExaminationHallController::class, 'restore']);
            });
            Route::prefix('/examination-dates')->group(function () {
                Route::get('/', [AdminExaminationDateController::class, 'index']);
                Route::post('/', [AdminExaminationDateController::class, 'store']);
                Route::get('/{examinationDate}', [AdminExaminationDateController::class, 'show']);
                Route::put('/{examinationDate}', [AdminExaminationDateController::class, 'update']);
                Route::delete('/{examinationDate}/{force?}', [AdminExaminationDateController::class, 'destroy']);
                Route::get('/{examinationDate}/restore', [AdminExaminationDateController::class, 'restore']);
            });
        });
        Route::put('/{semester}', [AdminSemesterController::class, 'update']);
        Route::delete('/{semester}/{force?}', [AdminSemesterController::class, 'destroy']);
        Route::get('/{semester}/restore', [AdminSemesterController::class, 'restore']);
    });

    Route::prefix('/discount-types')->group(function () {
        Route::get('/', [AdminDiscountTypeController::class, 'index']);
        Route::post('/', [AdminDiscountTypeController::class, 'store']);
        Route::get('/{discountType}', [AdminDiscountTypeController::class, 'show']);
        Route::put('/{discountType}', [AdminDiscountTypeController::class, 'update']);
        Route::delete('/{discountType}/{force?}', [AdminDiscountTypeController::class, 'destroy']);
        Route::get('/{discountType}/restore', [AdminDiscountTypeController::class, 'restore']);
    });

    Route::get('/logs', [LogController::class, 'index']);
    Route::get('/pdf', [AdminStudentContoller::class, 'export']);
    Route::prefix('/student-marks')->group(function () {
        Route::get('/', [AdminStudentMarkController::class, 'index']);
        Route::get('/{studentMark}', [AdminStudentMarkController::class, 'show']);
        Route::get('/{id}/restore', [AdminStudentMarkController::class, 'restore']);
        Route::get('/{id}/export-excel', [AdminStudentMarkController::class, 'exportExcel']);
        Route::get('/{id}/export-pdf', [AdminStudentMarkController::class, 'exportPdf']);
        Route::post('/', [AdminStudentMarkController::class, 'store']);
        Route::post('/import', [AdminStudentMarkController::class, 'importExcel']);
        Route::put('/{studentMark}', [AdminStudentMarkController::class, 'update']);
        Route::delete('/{id}/{force?}', [AdminStudentMarkController::class, 'destroy']);
    });

    Route::prefix('/program-rules')->group(function () {
        Route::get('/', [AdminProgramRuleController::class, 'index']);
        Route::post('/', [AdminProgramRuleController::class, 'store']);
        Route::get('/{programRule}', [AdminProgramRuleController::class, 'show']);
        Route::put('/{programRule}', [AdminProgramRuleController::class, 'update']);
        Route::delete('/{programRule}/{force?}', [AdminProgramRuleController::class, 'destroy']);
        Route::get('/{programRule}/restore', [AdminProgramRuleController::class, 'restore']);

    });

    Route::prefix('/doctors')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'index']);
        Route::prefix('/{doctor}')->group(function () {
            Route::get('/', [AdminDoctorController::class, 'show']);
            Route::prefix('/academic-infos')->group(function () {
                Route::get('/', [AdminAcademicInfoController::class, 'index']);
                Route::get('{academicInfo}', [AdminAcademicInfoController::class, 'show']);
                Route::post('/', [AdminAcademicInfoController::class, 'store']);
                Route::put('{academicInfo}', [AdminAcademicInfoController::class, 'update']);
                Route::delete('{academicInfo}/{force?}', [AdminAcademicInfoController::class, 'destroy']);
                Route::get('{academicInfo}/restore', [AdminAcademicInfoController::class, 'restore']);
            });
            Route::prefix('/academic-positions')->group(function () {
                Route::get('/', [AdminAcademicPositionController::class, 'index']);
                Route::get('{academicPosition}', [AdminAcademicPositionController::class, 'show']);
                Route::post('/', [AdminAcademicPositionController::class, 'store']);
                Route::put('{academicPosition}', [AdminAcademicPositionController::class, 'update']);
                Route::delete('{academicPosition}/{force?}', [AdminAcademicPositionController::class, 'destroy']);
                Route::get('{academicPosition}/restore', [AdminAcademicPositionController::class, 'restore']);
            });
            Route::prefix('/achievements')->group(function () {
                Route::get('/', [AdminAchievementController::class, 'index']);
                Route::get('{achievement}', [AdminAchievementController::class, 'show']);
                Route::post('/', [AdminAchievementController::class, 'store']);
                Route::put('{achievement}', [AdminAchievementController::class, 'update']);
                Route::delete('{achievement}/{force?}', [AdminAchievementController::class, 'destroy']);
                Route::get('{achievement}/restore', [AdminAchievementController::class, 'restore']);
            });
        });
        Route::post('/', [AdminDoctorController::class, 'store']);
        Route::put('/{doctor}', [AdminDoctorController::class, 'update']);
        Route::delete('/{doctor}/{force?}', [AdminDoctorController::class, 'destroy']);
        Route::get('{doctor}/restore', [AdminDoctorController::class, 'restore']);
    });
    Route::prefix('infos')->group(function () {
        Route::get('/', [InfoController::class, 'index']);//
        Route::post('/update', [AdminInfoController::class, 'update']);//
    });
});


