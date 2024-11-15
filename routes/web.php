<?php

use App\CustomJobs\ExampleJob;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', [JobController::class, 'index']);

Route::get('/run-test-job', function() {
    runBackgroundJob(ExampleJob::class, 'execute', ['Param-1']);
});