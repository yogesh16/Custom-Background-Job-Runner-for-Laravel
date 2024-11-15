<?php

use App\Models\BackgroundJob;

function runBackgroundJob($class, $method, array $parameters = [], $priority = 1, $delay = 0)
{
    // Ensure only approved classes can be run
    $approvedClasses = config('background_jobs.approved_classes', []);
    if (!in_array($class, $approvedClasses)) {
        throw new \Exception("Unauthorized class {$class}");
    }
    
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
        'priority' => $priority,
        'scheduled_at' => $delay ? now()->addSeconds($delay) : null,
    ]);

    // Run the job runner command in the background
    $command = 'php ' . base_path('artisan') . ' app:custom-job-runner >> ' . storage_path('logs/background_jobs.log') . ' 2>> ' . storage_path('logs/background_jobs_errors.log') . ' &';

    if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
        pclose(popen("start /B {$command}", "r"));
    } else {
        exec("{$command} > /dev/null &");
    }

    return $job;
}