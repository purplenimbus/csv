<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class ProcessUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	var $http;
	var $wordpress_url;
	var $upload;
	var $files;
	
	function __construct($files,$upload){
		$this->guzzle = new GuzzleClient();
		$this->wordpress_url = env('NIMBUS_MEDIA_API_ENPOINT');
		$this->upload = $upload;
		$this->files = $files;
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump($this->files);
    }
}
