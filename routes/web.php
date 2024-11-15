<?php

use App\CustomJobs\ExampleJob;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    runBackgroundJob(ExampleJob::class, 'execute', ['Param-1']);
    //return view('welcome');
});

Route::get('/jobs', [JobController::class, 'index']);
