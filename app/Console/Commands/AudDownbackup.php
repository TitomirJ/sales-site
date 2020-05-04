<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\CustomServices\Backtofutures;

class AudDownbackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auddown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backup info products in yesterday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       (new Backtofutures)->aud_rollback();
     
    }
}
