<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Joblist;
use App\Models\Workingnotify;
use App\Jobs\SendJobEndingEmail;

class ActiveJoblistChecker extends Command
{
    
    protected $signature   = 'app:active-joblist-checker';
    protected $description = 'Check all the Jobs that currently active!!!';

    public function handle()
    {
        $notToSend = Workingnotify::pluck('joblist_id')->toArray();
        $jobs      = Joblist::whereNotIn('id', $notToSend)->where('job_status', '3')->get();
        foreach ($jobs as $key => $job) {

            $eligible = check_job_before_15minutes_end($job->id);

            if ($eligible==true) {
                Workingnotify::create([
                    'employee_id' => $job->employee_id,
                    'joblist_id'  => $job->id,
                ]);

                dispatch(new SendJobEndingEmail($job->employee_id, $job->id));
            }
        }
    }
}