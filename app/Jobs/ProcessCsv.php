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
	public $csv_string;
	public $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csv_string,$model)
    {
        $this->csv_string = $csv_string;
        $this->model = $model;
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
			var_dump($this->csv_string);
			var_dump($this->model->uuid);
			//$csv = str_getcsv();
			//var_dump($csv);
			//loop through data
			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
