<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Company;
use App\Tempcompany;

class TempArr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mtac';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make temp arr companies with autoupdate setting notnull';

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
       $arr = Tempcompany::all();
       if(count($arr)>0){
        Tempcompany::whereNotNull('company_id')->delete();
       }

        $company_w_autoupdate = Company::where('update_auto','!=',NULL)->get();
        $i = 0;
        $e =0;
        foreach($company_w_autoupdate as $item){
			
			$set_update = json_decode($item->update_auto);
			
			if(!empty($set_update[2])){
				
            $flight = Tempcompany::create(['company_id' => $item->id]);
            $i++;
            if(!$flight){
                $e++;
               \Log::info('company_id = '.$item->id.'error created in tempcompanies ');
            }
				
			}
        }
			

        \Log::info('table maked success: count row:'.$i.' error:'.$e);
    }
}