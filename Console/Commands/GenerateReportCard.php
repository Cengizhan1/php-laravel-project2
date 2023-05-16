<?php

namespace App\Console\Commands;

use App\Jobs\ReportCard;
use Illuminate\Console\Command;

class GenerateReportCard extends Command
{
    protected $signature = 'cuser:subscriptions:report:generate';

    protected $description = 'Command description';

    public function handle()
    {
        ReportCard::dispatch();
    }
}
