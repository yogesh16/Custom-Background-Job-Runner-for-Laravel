<?php

namespace App\Console\Commands;

use App\Models\BackgroundJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CustomJobRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-job-runner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $job = BackgroundJob::where('status', 'pending')
            ->first();

        if(empty($job))
            return;

        $job->update(['status', 'running']);
        Log::channel('background_jobs')->info("Job {$job->id} running, Class: {$job->class}, Method: {$job->method}");

        try {
            $class = app()->make($job->class);
            $method = $job->method;
            $parameters = json_decode($job->parameters, true);

            if (!method_exists($class, $method)) {
                Log::channel('background_jobs_errors')->error("Job {$job->id} failed: {$method} does not exist on {$class}");
                throw new \Exception("Method {$method} does not exist on {$class}");
            }

            $class->$method(...$parameters);
            $job->update(['status' => 'completed', 'completed_at' => now()]);
            Log::channel('background_jobs')->info("Job {$job->id} completed.");
        } catch (\Exception $e) {
            Log::channel('background_jobs_errors')->error("Job {$job->id} failed: " . $e->getMessage());
        }
            
    }
}
