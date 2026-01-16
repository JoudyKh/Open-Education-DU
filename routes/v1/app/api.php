<?php

use App\Http\Controllers\Api\App\Student\StudentController as AppStudentController;
use App\Http\Controllers\Api\App\StudentMark\StudentMarkController;
use App\Http\Controllers\Api\General\Branch\BranchController;
use App\Http\Controllers\Api\General\City\CityController;
use App\Http\Controllers\Api\General\Country\CountryController;
use App\Http\Controllers\Api\General\Curriculum\CurriculumController;
use App\Http\Controllers\Api\General\Info\HomeController;
use App\Http\Controllers\Api\General\Nationality\NationalityController;
use App\Http\Controllers\Api\General\News\NewsContoller;
use App\Http\Controllers\Api\General\Product\ProductController;
use App\Http\Controllers\Api\General\Province\ProvinceContoller;
use App\Http\Controllers\Api\General\Semester\SemesterController;
use App\Http\Controllers\Api\General\Student\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\General\Auth\AuthController;
use App\Http\Controllers\Api\General\Info\InfoController;
use App\Http\Controllers\Api\General\Offer\OfferController;
use App\Http\Controllers\Api\General\Section\SectionController;
use App\Http\Controllers\Api\App\Auth\AuthController as AppAuthController;
use App\Http\Controllers\Api\App\ContactMessage\ContactMessageController;
use App\Http\Controllers\Api\General\PurchaseCode\PurchaseCodeController;

/** @Auth */

Route::post('login', [AppAuthController::class, 'login']);
Route::post('register', [AppAuthController::class, 'register']);//
Route::post('send/verification-code', [AuthController::class, 'sendVerificationCode']);//
Route::post('check/verification-code', [AuthController::class, 'checkVerificationCode']);//
    
Route::post('reset-password', [AppAuthController::class, 'resetPassword'])->middleware('auth:student');
Route::group(['middleware' => ['auth:student', 'role:student', 'last.active', 'check.student.password.change']], function () {
    /** @Auth */
    Route::post('logout', [AuthController::class, 'logout']);//
    Route::get('/check/auth', [AuthController::class, 'authCheck']);//

    Route::prefix('/student')->group(function(){
        Route::get('/', [StudentController::class, 'show']);
        Route::put('/', [AppStudentController::class, 'update'])->middleware('is.checked');
    });
    Route::put('change-password', [AuthController::class, 'changePassword']);//
    Route::get('/marks/{semester}', [StudentMarkController::class, 'index']);
});


/**@Guest */

Route::prefix('/news')->group(function(){
    Route::get('/', [NewsContoller::class, 'index']);
    Route::get('/{news}', [NewsContoller::class, 'show']);
});

Route::prefix('/provinces')->group(function(){
    Route::get('/', [ProvinceContoller::class, 'index']);
});

Route::prefix('/countries')->group(function(){
    Route::get('/', [CountryController::class, 'index']);
});

Route::prefix('/cities')->group(function(){
    Route::get('/', [CityController::class, 'index']);
});

Route::prefix('/nationalities')->group(function(){
    Route::get('/', [NationalityController::class, 'index']);
});

Route::prefix('/curriculums')->group(function(){
    Route::get('/', [CurriculumController::class, 'index']);
    Route::get('/{curriculum}', [CurriculumController::class, 'show']);
});
Route::prefix('/semesters')->group(function(){
    Route::get('/', [SemesterController::class, 'index']);
    Route::get('/{semester}', [SemesterController::class, 'show']);
});

Route::prefix('infos')->group(function () {
    Route::get('/', [InfoController::class, 'index']);//
});