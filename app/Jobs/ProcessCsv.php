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
			$records = 0;
			
			foreach($rows as $key => $row) {
				
				if($key >= 100){
					return false;
				}
								
				$modelYear = explode(',',str_replace('-',',',$row[1]));
				$makeName = mb_strtolower($row[2]);
				$modelName = mb_strtolower($row[3]);
								
				$vehicleMake = VehicleMake::firstOrCreate(['name' => $makeName]);
				
				$vehicleModel = VehicleModel::firstOrCreate(['name' => $modelName,'make_id' => $vehicleMake->id]);
																		
				$years = array_merge($modelYear,explode(',',$vehicleModel->years));
				
				//echo "Model Years"."\r\n";
				
				//var_dump($modelYear);
				
				//echo "Years"."\r\n";
				
				//var_dump($years);
				
				$yearsFiltered = array_unique($years);
				
				//echo "Years (Duplicates Removed)"."\r\n";
				
				//var_dump($yearsFiltered);
				
				$vehicleModel->years = implode(',',array_filter($yearsFiltered));
				
				$vehicleModel->save();
				
				$records++;
								
				//var_dump($vehicleModel->years);
								
				//echo "Make : $vehicleMake->name | Model : $vehicleModel->name | Year : $vehicleModel->years"."\r\n";
				
				\Log::info("Make : $vehicleMake->name | Model : $vehicleModel->name | Year : $vehicleModel->years");

			}

			$this->model->result = [];
			
			$this->model->processed = true;
			
			$this->model->save();
			
			$this->model->notify(new CsvProcessed($this->model));
			
			\Log::info("$records processed");
			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
