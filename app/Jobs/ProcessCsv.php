<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Csv;
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
        try{
			
			/*$csv = Reader::createFromPath($this->csv_path,'r');
			
			$results = $csv;
						
			var_dump("Delimiter ".$csv->getDelimiter());
			var_dump("Enclosure ".$csv->getEnclosure());
			var_dump("Escape ".$csv->getEscape());
			var_dump("BOM ".$csv->getInputBOM());
			var_dump(str_getcsv($csv->__toString(),','));*/
			
			
			$rows   = array_map('str_getcsv', file($this->csv_path));
			$header = array_shift($rows);
			$parsed    = array();
			
			//var_dump($header);
			
			foreach($rows as $row) {
				//var_dump($row);
				$parsed[] = array_combine($header, $row);
				
			}

			//var_dump($parsed);

			$this->model->result = $parsed;
			
			$this->model->processed = true;
			
			$this->model->save();
			
			$this->model->notify(new CsvProcessed($this->model));
			
		}catch(Exception $e){
			//DO something on error?
		}
    }
}
