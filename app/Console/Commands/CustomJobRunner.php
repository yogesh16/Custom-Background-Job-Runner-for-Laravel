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

        try {
            $class = app()->make($job->class);
            $method = $job->method;
            $parameters = json_decode($job->parameters, true);

            if (!method_exists($class, $method)) {
                throw new \Exception("Method {$method} does not exist on {$class}");
            }

            $class->$method(...$parameters);
            $job->update(['status' => 'completed', 'completed_at' => now()]);
        } catch (\Exception $e) {
            Log::error('[CustomJobRunner]', [$e->getMessage()]);
        }
            
    }
}
