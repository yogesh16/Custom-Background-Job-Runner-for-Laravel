
# Custom Background Job Runner for Laravel

This project provides a custom job runner for Laravel applications that runs jobs independently from Laravel's built-in queue system. It features job scheduling, execution, error handling, retries, and logging.
## Table of Contents

- [Features](#features)
- [Setup](#setup)
- [Configuration](#configuration)
- [Usage](#usage)
- [Log Files](#log-files)
- [Dashboard](#dashboard)



## Features

- **Run Jobs Independently**: Execute PHP classes and methods as background jobs, independently of Laravel's default queue system.
- **Cross-Platform Support**: Compatible with both Windows and Unix-based systems.
- **Error Handling**: Captures errors during job execution and logs them.
- **Retry Mechanism**: Configurable retry attempts for failed jobs.
- **Logging**: Logs all job executions, including job status (running, completed, failed).
- **Job Delay and Priority**: Ability to delay job execution and set job priority.
- **Dashboard**: Web-based dashboard to monitor and manage jobs.

## Setup

Clone the project

```bash
  git clone git@github.com:yogesh16/Custom-Background-Job-Runner-for-Laravel.git
```

Go to the project directory

```bash
  cd Custom-Background-Job-Runner-for-Laravel
```

Install dependencies

```bash
  composer install
```
if you are using yarn
```bash
  yarn && yarn run build
```
if you are using npm
```bash
  npm install && npm run build
```

To continuously run the job runner in the background, Need to set up Laravel’s `schedule:run` command to execute every minute.
  
- Open your server’s crontab editor:
```bash
crontab -e
```
- Add the following cron job to run Laravel’s schedule:run command every minute
```bash
* * * * * cd /Custom-Background-Job-Runner-for-Laravel && php artisan schedule:run >> /dev/null 2>&1

```


Start the server

```bash
  php artisan serve
```


## Configuration

You can configure background job-runner in config/background_jobs.php file.

- **approved_classes**: These are list of allowed classed to run using custom background jobs. If you create a new background job class, do not forget to add it here.

- **max_retries**: Max retries of a job, default is set to **3**
## Usage

To run a background job, call runBackgroundJob() with the class name, method, and optional parameters.

```php
runBackgroundJob(\App\Jobs\ExampleJob::class, 'execute', ['param1' => 'value1', 'param2' => 'value2']);
```

You can also pass following optional parameters to runBackgroundJob() function

- **Priority**: pass integer number as per your required priority, and job runner will execute jobs based on provided priority

  **Note: default priority is : 1**

```php
runBackgroundJob(\App\Jobs\ExampleJob::class, 'execute', ['param1' => 'value1', 'param2' => 'value2'], 2);
```

- **Delay**: pass number of seconds (integer), to delay execution of a job.

For example if you want to run a job after 5min.
```php
runBackgroundJob(\App\Jobs\ExampleJob::class, 'execute', ['param1' => 'value1', 'param2' => 'value2'], 2, 300);
```
## Log Files

Two log files are created in storage/logs to capture job execution details:

- **Job Execution Log** (background_jobs.log): Logs each job's class, method, execution time, and status.

```yaml
[2024-11-15 05:54:15] local.INFO: Job 5 running, Class: App\CustomJobs\ExampleJob, Method: execute  
[2024-11-15 05:54:15] local.INFO: Job 5 completed.

```

- **Error Log** (background_jobs_errors.log): Captures any exceptions or errors encountered during job execution.

```yaml
[2023-11-13 12:01:00] Job 8 failed: Class not found
```
## Dashboard

Dashboard to monitor jobs

Goto following url to see Dashboard
```bash
{localhost}/jobs
```