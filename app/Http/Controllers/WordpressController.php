<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Jobs\ProcessUpload;
use App\Wordpress\NimbusWP;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class WordpressController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	
	function __construct(){
		$this->guzzle = new GuzzleClient();
		$this->WP = new NimbusWP(env('NIMBUS_MEDIA_API_ENPOINT'));
	}
	
	
	public function processFile(Request $request){
		try{
			//validate file?
			
			$upload = new Upload;
						
			$file = $request->file('files')[0];
			
			$payload = [
				'title' => $file->getClientOriginalName(),
				'files' => $file
			];
			
			$options = [
				'headers'	=>	[	
					'content-disposition' => 'attachment; filename=example.com',
					'content-type' => 'application/x-www-form-urlencoded'
				],
				//'form_params' => $payload
			];
			
			$response = $this->WP->WP_REQ('POST','media',$options);
			
			if($response->getStatusCode() === 200){
				
				$upload->processed = true;
			
				$upload->save();
				
				$data = ['uuid' => $upload->uuid,'status' => 'processed','data' => json_decode($response->getBody()->getContents())];
				
			}else{
				$data = ['message' => 'somethings wrong', 'errors' => $response->getReasonPhrase()];
			}

			return response()->json($data,$response->getStatusCode());
		}catch(Exception $e){
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
