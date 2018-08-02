<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Csv;
//use App\VehicleMake;
//use App\VehicleModel;
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
			
			var_dump($this->csv_path);
			
			/*$csv = Reader::createFromPath($this->csv_path,'r');
			
			$results = $csv;
						
			var_dump("Delimiter ".$csv->getDelimiter());
			var_dump("Enclosure ".$csv->getEnclosure());
			var_dump("Escape ".$csv->getEscape());
			var_dump("BOM ".$csv->getInputBOM());
			var_dump(str_getcsv($csv->__toString(),','));*/
			
			
			/*$rows   = array_map('str_getcsv', file($this->csv_path));
			$header = array_shift($rows);
			$parsed    = array();*/
			
			//var_dump($header);
			
			/*foreach($rows as $row) {
				//var_dump($row);
				//$parsed[] = array_combine($header, $row);
				
				$parsed[] = $data = array_combine($header, $row);
				
				$modelYear = (int)$row[1];
				$makeName = mb_strtolower($row[2]);
				$modelName = mb_strtolower($row[3]);
				
				//echo "Make : $makeName | Model : $modelName | Year : $modelYear"."\r\n";
				
				//$model = VehicleModel::firstOrCreate(['name' => $modelName]);
				
				//$model = VehicleModel::where('name',$modelName)->first();
				
				//var_dump(isset($model->id));
				
				if(isset($model->id)){
					echo 'VehicleModel Exists? : '.$model->name."\r\n";
					continue;
				}else{
					$newModel = new VehicleModel;
					
					$newModel->name = $modelName;
					$newModel->meta = [ 'year' => $modelYear ];
									
					$carMake = VehicleMake::where('name',$makeName)->first();
					
					if(isset($carMake->id)){
						echo 'VehicleMake Exists : '.$carMake->name."\r\n";
						$newModel->make_id = $carMake->id;
					}else{
						$newMake = new VehicleMake;
						$newMake->name = $makeName;
						$newMake->save();
						$newModel->make_id = $newMake->id;
					}		
					
					$newModel->save();

					
				}
			}*/

			//var_dump(['yes']);

			/*$this->model->result = $parsed;
			
			$this->model->processed = true;
			
			$this->model->save();
			
			$this->model->notify(new CsvProcessed($this->model));*/
			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
