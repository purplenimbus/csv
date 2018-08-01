<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessCsv;

class CsvController extends Controller
{
    public function process(Request $request){
		//validate?
		
		ProcessCsv::dispatch($request->file('csv'));
	}
}
