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
		
		ProcessCsv::dispatch($request->file('csv'),$csv);
		
		return response()->json(['process id' => $csv->id]);
	}
}
