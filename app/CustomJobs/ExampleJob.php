<?php

namespace App\CustomJobs;

use Illuminate\Support\Facades\Log;

class ExampleJob 
{
    public function execute($param) 
    {
        Log::debug('[ExampleJob]', [$param]);
    }
}