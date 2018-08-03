<?php

namespace App\Wordpress;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Psr\Http\Message\RequestInterface;


class NimbusWP
{
	
	var $http;
	var $wordpress_url;
	var $guzzle;
	//var $auth;
	//var $http_options;
	
	function __construct($url=''){
		$this->guzzle = new GuzzleClient();
		$this->wordpress_url = $url;
		//$this->auth = $this->oauth();
	}
	
	public function oauth(){

	}
	
	public function WP_REQ($request_type,$endpoint,$opt){
		$url = $this->wordpress_url.$endpoint;
		
		$stack = $this->handler(env('NIMBUS_MEDIA_CLIENT_KEY'),env('NIMBUS_MEDIA_CLIENT_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN_SECRET'),env('NIMBUS_MEDIA_OAUTH_TOKEN'));
		
		$self = $this;
		
		if(isset($opt['headers'])){
			foreach($opt['headers'] as $key => $header){
				$stack->push($self->add_header($key,$header));
			}
		}
		
		$options = array( 	
			'handler' => $stack, 
			'auth' => 'oauth',
			'exceptions ' =>  true,
			//'query' => [	'per_page' => 100	 ]
		);
		
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
		
		$stack->push($middleware);
		
		return $stack;
	}
	

}
