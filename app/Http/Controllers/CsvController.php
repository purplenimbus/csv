<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Csv;
use App\Jobs\ProcessCsv;

class CsvController extends Controller
{
    public function process(Request $request){
		//validate?
		try{
			$csv = new Csv;
			
			$file = $request->file('files')[0];
									
			if(!$file->path()){
				return response()->json(['status' => 'cant find file path' ],500);
			}
			
			$csv->save();
			
			ProcessCsv::dispatch($file->path(),$csv)->onQueue('default');
						
			return response()->json(['id' => $csv->uuid,'status' => 'processing'],200);
		}catch(Exception $e){
			//var_dump($e);
			return response()->json(['status' => $e->getMessage() ],500);	
		}

	}
	
	public function getResult($id){
		$csv = Csv::find($id);
		
		return response()->json($csv,200);
	}
}
