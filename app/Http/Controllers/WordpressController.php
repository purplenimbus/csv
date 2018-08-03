<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Jobs\ProcessUpload;

class WordpressController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function processFile(Request $request){
		try{
			//validate file?
			
			$upload = new Upload;
			
			$upload->save();
			
			$files = array_map(function($v){
				return [
					'path' => $v->path()
				];
			},$request->file('files'));
		
			ProcessUpload::dispatch($files,$upload);
			
			return response()->json(['uuid' => $upload->uuid,'status' => 'processing'],200);
			
		}catch(Exception $e){
			//var_dump($e);
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
