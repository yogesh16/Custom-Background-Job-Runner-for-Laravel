<?php

use App\Models\BackgroundJob;

function runBackgroundJob($class, $method, array $parameters = [])
{
    // Validate class and method
    if (!class_exists($class) || !method_exists($class, $method)) {
        throw new \Exception("Invalid class or method");
    }

    // Schedule the job in the database
    $job = BackgroundJob::create([
        'class' => $class,
        'method' => $method,
        'parameters' => json_encode($parameters),
        'status' => 'pending',
    ]);

    // Run the job runner command in the background
    $command = 'php ' . base_path('artisan') . ' app:custom-job-runner';

    if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
        pclose(popen("start /B {$command}", "r"));
    } else {
        exec("{$command} > /dev/null &");
    }

    return $job;
}