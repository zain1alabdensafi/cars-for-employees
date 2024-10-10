<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunETLJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-e-t-l-job';

    /**
     * The console command description.
     *
     * @var string
     */
 
    protected $description = 'Run the ETL job to update the data warehouse';

    /**
     * Execute the console command.
     */
 
 
 
     public function __construct()
     {
         parent::__construct();
     }
 
     public function handle()
     {
         ETLJob::dispatch();
         $this->info('ETL job dispatched successfully.');
     }
}
