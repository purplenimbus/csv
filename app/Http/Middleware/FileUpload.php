<?php

namespace App\Http\Middleware;

use Closure;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class FileUpload
{
  	var $http;
	var $wordpress_url;
	
	function __construct(){
		$this->guzzle = new GuzzleHttp\Client();
		$this->wordpress_url = env('NIMBUS_MEDIA_API_ENPOINT');
	}
	
	protected function  WP($type,$endpoint,$payload){
		$url = $this->wordpress_url.$endpoint;
		
		$stack = $this->handler(env('NIMBUS_MEDIA_CLIENT_KEY'),env('NIMBUS_MEDIA_CLIENT_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN'));

		$options = array( 	
							'form_params' => $payload ? $payload : null , 
							'handler' => $stack, 
							'auth' => 'oauth',
							'exceptions ' =>  false,
							'query' => [	'per_page' => 100	 ]
		);
		
		return $response = $this->guzzle->request($type,$url,$options);
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
	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //get file
		var_dump($request->all());
		
		return $next($request);
    }
}
