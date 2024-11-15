<?php

use App\CustomJobs\ExampleJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    runBackgroundJob(ExampleJob::class, 'execute', ['Param-1']);
    //return view('welcome');
});
