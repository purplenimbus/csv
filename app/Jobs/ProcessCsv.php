<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Csv;
use App\VehicleMake;
use App\VehicleModel;
use App\Notifications\CsvProcessed;

use League\Csv\Reader;
use League\Csv\Statement;

class ProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $csv_path;
	public $model;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csv_path,$model)
    {
        $this->csv_path = $csv_path;
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Making Csv');
		try{			
			
			$rows   = array_map('str_getcsv', file($this->csv_path));
			$header = array_shift($rows);
			$parsed    = array();
			
			foreach($rows as $row) {
								
				$modelYear = str_replace('-',',',$row[1]);//explode($row[1],'-');
				$makeName = mb_strtolower($row[2]);
				$modelName = mb_strtolower($row[3]);
				
				//echo "Make : $makeName | Model : $modelName | Year : $modelYear"."\r\n";
				
				$make = VehicleMake::firstOrCreate(['name' => $makeName]);
				
				$model = VehicleModel::firstOrCreate(['name' => $modelName,'make_id' => $make->id , 'years' => $modelYear]);
				
				echo "Make : $make->name | Model : $model->name | Year : $model->years"."\r\n";

			}

			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
