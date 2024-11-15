<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:custom-job-runner')->everyMinute();
