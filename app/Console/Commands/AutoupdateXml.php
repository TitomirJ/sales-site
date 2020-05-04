<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\CronController;
use App\Tempcompany;

class AutoupdateXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:audxml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'autoupdate xml files from companies';

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
		//try {
			//(new CronController)->autonew();
		//} catch (\Exception $e) {
			//dd($e);
		//};

		if(count(Tempcompany::all()) > 0){
           (new CronController)->autonew(); 
        }else{
            \Log::info('all companies  updated. This work cron');
        }
    }
}