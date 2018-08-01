<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Csv;

class ProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$csv)
    {
        $this->data = $data;
        $this->csv = $csv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
			//get csv
			var_dump($this->data);
			var_dump($this->csv);
			//$csv = str_getcsv();
			//var_dump($csv);
			//loop through data
			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
