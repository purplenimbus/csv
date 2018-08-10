<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Notifications\UploadProcessed;

use Illuminate\Support\Facades\Auth;

use App\Jobs\ProcessUpload;
use App\NimbusWP;

class WordpressController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	var $api;
	
	function __construct(){
		$this->api = new NimbusWP(env('NIMBUS_MEDIA_API_ENPOINT'));
	}
	
	public function processFile(Request $request){
		try{
			//validate file?	

			/*$file = $request->file('files')[0];
			
			ProcessUpload::dispatch($file->path(),$file->getClientOriginalName());
			
			$res = ['message' => 'processing','status' => 200];*/
									
			$res = $this->api->process($request);
			
			return response()->json($res,$res['status']);
			
		}catch(Exception $e){
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
	
	public function getFiles($uuid,Request $request){
		try{
			//validate request?
			
			$images = Upload::with('user')->where(['user_uuid' => $uuid])->latest()->paginate(10);

			return response()->json($images,200);
			
		}catch(Exception $e){
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
