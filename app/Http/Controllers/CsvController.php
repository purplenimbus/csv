<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Csv;
use App\Jobs\ProcessCsv;

class CsvController extends Controller
{
    public function process(Request $request){
		//validate?
		$csv = new Csv;
		
		$csv->save();
		
		$path = $request->file('files')[0]->getPathname();
		
		$file = fopen($path, "r");
		
		$csv_data = fread($file,filesize($path));
		
		ProcessCsv::dispatch($csv_data,$csv);
		
		return response()->json(['id' => $csv->uuid,'status' => 'processing'],200);
	}
}
