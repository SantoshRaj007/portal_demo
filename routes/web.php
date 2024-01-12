<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsCantroller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobsCantroller::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobsCantroller::class,'detail'])->name('jobDetail');

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
            // Route::get('/job-details/{jobId}','jobDetails')->name('account.jobDetails');
        });

    });
});

// Without Group Controller

// Route::get('/account/register',[AccountController::class,'registration'])->name('account.registration');
// Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
// Route::get('/account/login',[AccountController::class,'login'])->name('account.login');


