<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Notifications\UploadProcessed;
use App\Wordpress\NimbusWP;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

use Illuminate\Support\Facades\Auth;

class WordpressController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	var $api;
	
	function __construct(){
		$this->guzzle = new GuzzleClient();
		$this->api = new NimbusWP(env('NIMBUS_MEDIA_API_ENPOINT'));
	}
	
	
	public function processFile(Request $request){
		try{
			//validate file?
			
			$upload = new Upload;
			
			$res = $this->api->process($request,$upload);

			return response()->json($res,$res['status']);
			
		}catch(Exception $e){
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
