<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsCantroller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobsCantroller::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobsCantroller::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobsCantroller::class,'applyJob'])->name('applyJob');
Route::post('/save-job',[JobsCantroller::class,'saveJob'])->name('saveJob');
Route::get('/forgot-password',[AccountController::class,'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password',[AccountController::class,'processForgotPassword'])->name('account.processForgotPassword');
Route::get('/reset-password/{token}',[AccountController::class,'resetPassword'])->name('account.resetPassword');

// Admin Route Controller

Route::group(['prefix' => 'admin','middleware' => 'checkRole'], function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
    Route::delete('/users',[UserController::class,'destroy'])->name('admin.users.destroy');
    Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
    Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
    Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.jobs.destroy');
    Route::get('/job-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');
    Route::delete('/job-applications',[JobApplicationController::class,'destroy'])->name('admin.jobApplications.destroy');
});

// Using Group Controller

Route::controller(AccountController::class)->group(function(){   

    Route::group(['prefix' => 'account'], function(){

        // Guest Route

        Route::group(['middleware' => 'guest'], function(){
            Route::get('/register','registration')->name('account.registration');
            Route::post('/process-register','processRegistration')->name('account.processRegistration');
            Route::get('/login','login')->name('account.login');
            Route::post('/authenticate','authenticate')->name('account.authenticate');
        });

        // Authenticate Route

        Route::group(['middleware' => 'auth'], function(){
            Route::get('/profile','profile')->name('account.profile');
            Route::put('/update-profile','updateProfile')->name('account.updateProfile');
            Route::post('/update-profile-pic','updateProfilePic')->name('account.updateProfilePic');
            Route::get('/logout','logout')->name('account.logout');
            Route::get('/create-job','createJob')->name('account.createJob');
            Route::post('/save-job','saveJob')->name('account.saveJob');
            Route::get('/my-jobs','myJobs')->name('account.myJobs');
            Route::get('/my-jobs/edit/{jobId}','editJob')->name('account.editJob');
            Route::post('/update-job/{jobId}','updateJob')->name('account.updateJob');
            Route::post('/delete-job','deleteJob')->name('account.deleteJob');
            Route::get('/my-job-applications','myJobApplications')->name('account.myJobApplications');
            Route::post('/remove-job-application','removeJob')->name('account.removeJob');
            Route::get('/saved-jobs','savedJobs')->name('account.savedJobs');
            Route::post('/remove-saved-job','removeSavedJob')->name('account.removeSavedJob');
            Route::post('/update-password','updatePassword')->name('account.updatePassword');

        });

    });
});

// Without Group Controller

// Route::get('/account/register',[AccountController::class,'registration'])->name('account.registration');
// Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
// Route::get('/account/login',[AccountController::class,'login'])->name('account.login');


