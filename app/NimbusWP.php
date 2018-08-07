<?php

namespace App;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Psr\Http\Message\RequestInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Notifications\UploadProcessed;

use App\Upload;

class NimbusWP
{
	use DispatchesJobs;
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	
	function __construct($url=''){
		$this->guzzle = new GuzzleClient();
		$this->wordpress_url = $url;
	}
	
	public function process(Request $request,Upload $upload){
		
		try{
			$file = $request->file('files')[0];
			
			$self = $this;
			
			$res = [];
			
			$payload = [
				'title' => $file->getClientOriginalName(),
				'files' => fopen($file->path(), 'r'),
				'meta' => []
			];
			
			if(Auth::user() && isset(Auth::user()->uuid)){
				$payload['meta']['user_uuid'] = Auth::user()->uuid;
			}	
			
			$options = [
				'multipart' => [
					[
						'name'     => 'media',
						'contents' => 'data',
						'headers'  => ['Content-Disposition' => 'form-data; filename='.$file->getClientOriginalName()]
					],
					[
						'name'     => 'file',
						'contents' => fopen($file->path(), 'r'),
						'filename' => $file->getClientOriginalName()
					]
				]
			];
			
			$response = $self->API('POST','media',$options);
									
			if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
				
				$upload->processed = true;
				
				$payload = json_decode($response->getBody()->getContents());
										
				$upload->meta = [
					'wp_data' => $payload,
				];
				
				if(Auth::user()->uuid){
					$upload->user_uuid = Auth::user()->uuid; //move to middelware or model?
				}
				
				$upload->save();
				
				if(Auth::user()->uuid){
					Auth::user()->notify(new UploadProcessed($upload));
				}
							
			$res['data'] = ['uuid' => $upload->uuid,'status' => 'processed','wp_data' => $upload->meta['wp_data']];
				
				 \Log::info('Processed '.$file->getClientOriginalName());
				
			}else{
				
				$res = ['message' => 'somethings wrong', 'errors' => $payload];
			}
			
			$res['status'] = $response->getStatusCode();
						
			return $res;
		}catch(Exception $e){
			
			return ['status' => $response->getStatusCode(), 'message' => $e->getMessage() ];	
			
		}
	}
	
	public function API($request_type,$endpoint,$opt){
		$url = $this->wordpress_url.$endpoint;
		
		$stack = $this->handler(env('NIMBUS_MEDIA_CLIENT_KEY'),env('NIMBUS_MEDIA_CLIENT_SECRET'),'6QMpkC0zqR65dvsuPCGsWuRmNpRHATabu0dqQThQ2wdpzIy1',env('NIMBUS_MEDIA_OAUTH_TOKEN'));
		
		$self = $this;
		
		$options = array( 	
			'handler' => $stack, 
			'auth' => 'oauth',
			'exceptions ' =>  false,
			'http_errors' =>  false,
			//'query' => [	'per_page' => 100	 ]
		);		
		
		$options = array_merge($options,$opt);

				
		return $this->guzzle->request($request_type,$url,$options);
				
	}
	
	private function add_header($header, $value)
	{
		return function (callable $handler) use ($header, $value) {
			return function (
				RequestInterface $request,
				array $options
			) use ($handler, $header, $value) {
				$request = $request->withHeader($header, $value);
				return $handler($request, $options);
			};
		};
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
		
		//var_dump($middleware);
		
		$stack->push($middleware);
		
		return $stack;
	}
	

}
