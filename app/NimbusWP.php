<?php

namespace App\Wordpress;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class NimbusWP
{
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	//var $auth;
	//var $http_options;
	
	function __construct($url){
		$this->guzzle = new GuzzleClient();
		$this->wordpress_url = $url;
		//$this->http_options = [];
		//$this->auth = $this->oauth();
	}
	
	public function oauth(){

	}
	
	public function WP_REQ($request_type,$endpoint,$payload){
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
	

}
