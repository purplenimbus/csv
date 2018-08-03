<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use App\Upload;
use App\Jobs\ProcessUpload;

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
		$this->wordpress_url = env('NIMBUS_MEDIA_API_ENPOINT');
	}
	
	protected function  WP($request_type,$endpoint,$payload){
		$url = $this->wordpress_url.$endpoint;
		
		$stack = $this->handler(env('NIMBUS_MEDIA_CLIENT_KEY'),env('NIMBUS_MEDIA_CLIENT_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN'));

		$options = array( 	
							'form_params' => $payload ? $payload : null , 
							'handler' => $stack, 
							'auth' => 'oauth',
							'exceptions ' =>  false,
							'query' => [	'per_page' => 100	 ]
		);
		
		return $this->guzzle->request($request_type,$url,$options);
	}
	
	private function handler($consumer_key,$consumer_secret,$token_secret,$token){
		$handler = new CurlHandler();
		
		$stack = HandlerStack::create($handler);

		$middleware = new Oauth1([
			'consumer_key'    => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'token_secret'    => $token_secret,
			'token'           => $token,
			'request_method' => Oauth1::REQUEST_METHOD_QUERY,
			'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC
		]);
		
		$stack->push($middleware);
		
		return $stack;
	}
	
	public function processFile(Request $request){
		try{
			//validate file?
			
			$upload = new Upload;
			
			$upload->save();
			
			$file = $request->file('files')[0];
			
			$payload = [
				'title' => $file->getClientOriginalName(),
				'files' => $file
			];
			
			$response = $this->WP('POST','/media',$payload);
			
			var_dump($response);
					
			//return response()->json(['uuid' => $upload->uuid,'status' => 'processing'],200);
			
		}catch(Exception $e){
			//var_dump($e);
			return response()->json(['status' => $e->getMessage() ],500);	
		}
	}
}
